<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'type', 'property_type',
        'price', 'rent_price', 'bedrooms', 'bathrooms', 'area_sqft',
        'land_length_ft', 'land_width_ft', 'land_length_m', 'land_width_m', 'area_sqm',
        'address', 'city', 'state', 'zip_code', 'latitude', 'longitude',
        'features', 'images', 'video_url', 'is_featured', 'status', 'views'
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'rent_price' => 'decimal:2',
        'land_length_ft' => 'decimal:2',
        'land_width_ft' => 'decimal:2',
        'land_length_m' => 'decimal:2',
        'land_width_m' => 'decimal:2',
        'area_sqm' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getMainImageAttribute()
    {
        if ($this->images && count($this->images) > 0) {
            return Storage::url($this->images[0]);
        }
        return '/images/placeholder.jpg';
    }

    public function getPropertyTypeLabelAttribute()
    {
        $types = [
            'bungalow' => 'Bungalow',
            'duplex' => 'Duplex',
            'apartment' => 'Apartment',
            'block_of_flat' => 'Block of Flats',
            'mansion' => 'Mansion',
            'townhouse' => 'Townhouse',
            'commercial' => 'Commercial',
            'land' => 'Land',
        ];
        return $types[$this->property_type] ?? ucfirst($this->property_type);
    }

    public function getFormattedPriceAttribute()
    {
        $amount = $this->type === 'rent' && $this->rent_price
            ? $this->rent_price
            : $this->price;

        $suffix = match ($this->type) {
            'rent' => ' / month',
            'lease' => ' / lease',
            default => '',
        };

        return '₦' . number_format((float) $amount) . $suffix;
    }
}
