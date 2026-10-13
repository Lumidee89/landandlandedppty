<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    private function calculateAreaSqm(array $validated): ?float
    {
        $lengthM = isset($validated['land_length_m']) ? (float) $validated['land_length_m'] : null;
        $widthM = isset($validated['land_width_m']) ? (float) $validated['land_width_m'] : null;

        if ($lengthM && $widthM) {
            return round($lengthM * $widthM, 2);
        }

        $lengthFt = isset($validated['land_length_ft']) ? (float) $validated['land_length_ft'] : null;
        $widthFt = isset($validated['land_width_ft']) ? (float) $validated['land_width_ft'] : null;

        if ($lengthFt && $widthFt) {
            return round(($lengthFt * 0.3048) * ($widthFt * 0.3048), 2);
        }

        return null;
    }

    public function create()
    {
        return view('properties.create');
    }
    public function show(Property $property)
    {
        // Increment view count
        $property->incrementViews();
        
        // Get related properties
        $relatedProperties = Property::where('status', 'active')
            ->where('id', '!=', $property->id)
            ->where(function($query) use ($property) {
                $query->where('city', $property->city)
                    ->orWhere('property_type', $property->property_type);
            })
            ->limit(4)
            ->get();
        
        return view('properties.show', compact('property', 'relatedProperties'));
    }

    // Add this method to handle inquiries
    public function inquiry(Request $request, Property $property)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|min:10',
        ]);

        $inquiry = Inquiry::create([
            'property_id' => $property->id,
            'user_id' => Auth::id() ?? null,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'message' => $validated['message'],
            'status' => 'unread',
        ]);

        return redirect()->back()->with('success', 'Your inquiry has been sent successfully! The agent will contact you soon.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:sale,rent,lease',
            'property_type' => 'required|in:bungalow,duplex,apartment,block_of_flat,mansion,townhouse,commercial,land',
            'price' => 'required|numeric|min:0',
            'rent_price' => 'nullable|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area_sqft' => 'nullable|numeric|min:0',
            'land_length_ft' => 'nullable|numeric|min:0',
            'land_width_ft' => 'nullable|numeric|min:0',
            'land_length_m' => 'nullable|numeric|min:0',
            'land_width_m' => 'nullable|numeric|min:0',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'nullable|string',
            'features' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'video_url' => 'nullable|url',
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $imagePaths[] = $path;
            }
        }

        $areaSqm = $this->calculateAreaSqm($validated);

        // Create property with status 'active' instead of 'pending'
        $property = Property::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'property_type' => $validated['property_type'],
            'price' => $validated['price'],
            'rent_price' => $validated['rent_price'] ?? null,
            'bedrooms' => $validated['bedrooms'] ?? null,
            'bathrooms' => $validated['bathrooms'] ?? null,
            'area_sqft' => $validated['area_sqft'] ?? null,
            'land_length_ft' => $validated['land_length_ft'] ?? null,
            'land_width_ft' => $validated['land_width_ft'] ?? null,
            'land_length_m' => $validated['land_length_m'] ?? null,
            'land_width_m' => $validated['land_width_m'] ?? null,
            'area_sqm' => $areaSqm,
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip_code' => $validated['zip_code'] ?? null,
            'features' => $validated['features'] ?? [],
            'images' => $imagePaths,
            'video_url' => $validated['video_url'] ?? null,
            'status' => 'active', // Changed from 'pending' to 'active'
        ]);

        return redirect()->route('dashboard')->with('success', 'Property listed successfully! It is now live on the platform.');
    }

    public function edit(Property $property)
    {
        // Check if user owns this property
        $user = Auth::user();
        $isAdmin = false;
        if ($user) {
            if (is_callable([$user, 'isAdmin'])) {
                $isAdmin = call_user_func([$user, 'isAdmin']);
            } else {
                $isAdmin = $user->is_admin ?? false;
            }
        }
        if ($property->user_id !== Auth::id() && ! $isAdmin) {
            abort(403);
        }
        return view('properties.edit', compact('property'));
        // Check if user owns this property
        $currentUser = Auth::user();
        $isAdmin = false;
        if ($currentUser) {
            if (is_callable([$currentUser, 'isAdmin'])) {
                $isAdmin = call_user_func([$currentUser, 'isAdmin']);
            } else {
                $isAdmin = $currentUser->is_admin ?? false;
            }
        }
        if ($property->user_id !== Auth::id() && ! $isAdmin) {
            abort(403);
        }
        // Check if user owns this property
        $checkUser = Auth::user();
        $checkIsAdmin = false;
        if ($checkUser) {
            if (is_callable([$checkUser, 'isAdmin'])) {
                $checkIsAdmin = call_user_func([$checkUser, 'isAdmin']);
            } else {
                $checkIsAdmin = $checkUser->is_admin ?? false;
            }
        }
        if ($property->user_id !== Auth::id() && ! $checkIsAdmin) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:sale,rent,lease',
            'property_type' => 'required|in:bungalow,duplex,apartment,block_of_flat,mansion,townhouse,commercial',
            'price' => 'required|numeric|min:0',
            'rent_price' => 'nullable|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area_sqft' => 'nullable|numeric|min:0',
            'land_length_ft' => 'nullable|numeric|min:0',
            'land_width_ft' => 'nullable|numeric|min:0',
            'land_length_m' => 'nullable|numeric|min:0',
            'land_width_m' => 'nullable|numeric|min:0',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'nullable|string',
            'features' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'video_url' => 'nullable|url',
        ]);

        // Handle new image uploads
        $imagePaths = $property->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $imagePaths[] = $path;
            }
        }

        $areaSqm = $this->calculateAreaSqm($validated);

        // Update property
        $property->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'property_type' => $validated['property_type'],
            'price' => $validated['price'],
            'rent_price' => $validated['rent_price'] ?? null,
            'bedrooms' => $validated['bedrooms'] ?? null,
            'bathrooms' => $validated['bathrooms'] ?? null,
            'area_sqft' => $validated['area_sqft'] ?? null,
            'land_length_ft' => $validated['land_length_ft'] ?? null,
            'land_width_ft' => $validated['land_width_ft'] ?? null,
            'land_length_m' => $validated['land_length_m'] ?? null,
            'land_width_m' => $validated['land_width_m'] ?? null,
            'area_sqm' => $areaSqm,
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip_code' => $validated['zip_code'] ?? null,
            'features' => $validated['features'] ?? [],
            'images' => $imagePaths,
            'video_url' => $validated['video_url'] ?? null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Property updated successfully!');
    }

    public function destroy(Property $property)
    {
        // Check if user owns this property
        $user = Auth::user();
        $isAdmin = false;
        if ($user) {
            if (is_callable([$user, 'isAdmin'])) {
                $isAdmin = call_user_func([$user, 'isAdmin']);
            } else {
                $isAdmin = $user->is_admin ?? false;
            }
        }
        if ($property->user_id !== Auth::id() && ! $isAdmin) {
            abort(403);
        }

        // Delete images from storage
        if ($property->images) {
            foreach ($property->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $property->delete();

        return redirect()->route('dashboard')->with('success', 'Property deleted successfully!');
    }
    // Update the update method in PropertyController.php

    public function update(Request $request, Property $property)
    {
        // Check if user owns this property or is admin
        $user = Auth::user();
        $isAdmin = false;
        if ($user) {
            if (is_callable([$user, 'isAdmin'])) {
                $isAdmin = call_user_func([$user, 'isAdmin']);
            } else {
                $isAdmin = $user->is_admin ?? false;
            }
        }
        if ($property->user_id !== Auth::id() && ! $isAdmin) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:sale,rent,lease',
            'property_type' => 'required|in:bungalow,duplex,apartment,block_of_flat,mansion,townhouse,commercial,land',
            'price' => 'required|numeric|min:0',
            'rent_price' => 'nullable|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area_sqft' => 'nullable|numeric|min:0',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'nullable|string',
            'features' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'video_url' => 'nullable|url',
            'deleted_images' => 'nullable|string',
        ]);

        // Handle deleted images
        if ($request->has('deleted_images') && $request->deleted_images) {
            $deletedImages = explode(',', $request->deleted_images);
            $currentImages = $property->images ?? [];
            
            foreach ($deletedImages as $deletedImage) {
                if (in_array($deletedImage, $currentImages)) {
                    // Remove from storage
                    Storage::disk('public')->delete($deletedImage);
                    // Remove from array
                    $currentImages = array_diff($currentImages, [$deletedImage]);
                }
            }
            $imagePaths = array_values($currentImages);
        } else {
            $imagePaths = $property->images ?? [];
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $imagePaths[] = $path;
            }
        }

        // Update property
        $property->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'property_type' => $validated['property_type'],
            'price' => $validated['price'],
            'rent_price' => $validated['rent_price'] ?? null,
            'bedrooms' => $validated['bedrooms'] ?? null,
            'bathrooms' => $validated['bathrooms'] ?? null,
            'area_sqft' => $validated['area_sqft'] ?? null,
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip_code' => $validated['zip_code'] ?? null,
            'features' => $validated['features'] ?? [],
            'images' => $imagePaths,
            'video_url' => $validated['video_url'] ?? null,
            'status' => 'active',
        ]);

        return redirect()->route('dashboard')->with('success', 'Property updated successfully!');
    }
}
