<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertySearchController extends Controller
{
    public function search(Request $request)
    {
        $query = Property::where('status', 'active');
        
        // Search by keyword (title, description, address, city, state)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('address', 'LIKE', "%{$search}%")
                  ->orWhere('city', 'LIKE', "%{$search}%")
                  ->orWhere('state', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter by property type
        if ($request->filled('property_type') && $request->property_type != '') {
            $query->where('property_type', $request->property_type);
        }
        
        // Filter by purpose (sale/rent/lease)
        if ($request->filled('purpose') && $request->purpose != '') {
            $query->where('type', $request->purpose);
        }
        
        // Filter by price range
        if ($request->filled('min_price')) {
            if ($request->purpose == 'rent') {
                $query->where('rent_price', '>=', $request->min_price);
            } else {
                $query->where('price', '>=', $request->min_price);
            }
        }
        
        if ($request->filled('max_price')) {
            if ($request->purpose == 'rent') {
                $query->where('rent_price', '<=', $request->max_price);
            } else {
                $query->where('price', '<=', $request->max_price);
            }
        }
        
        // Filter by bedrooms
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }
        
        $properties = $query->latest()->paginate(12);
        
        if ($request->ajax()) {
            return view('partials.property-cards', compact('properties'))->render();
        }
        
        return view('properties.search-results', compact('properties'));
    }
}