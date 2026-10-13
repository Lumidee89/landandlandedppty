@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen pt-16">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Edit Property</h1>
                <p class="text-gray-600">Update your property details</p>
            </div>

            <!-- Form -->
            <form action="{{ route('properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md overflow-hidden">
                @csrf
                @method('PUT')
                
                <div class="p-6 space-y-6">
                    <!-- Basic Information -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Basic Information</h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Property Title *</label>
                                <input type="text" name="title" required value="{{ old('title', $property->title) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Property Type *</label>
                                <select name="property_type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                                    <option value="">Select Property Type</option>
                                    <option value="bungalow" {{ old('property_type', $property->property_type) == 'bungalow' ? 'selected' : '' }}>Bungalow</option>
                                    <option value="duplex" {{ old('property_type', $property->property_type) == 'duplex' ? 'selected' : '' }}>Duplex</option>
                                    <option value="apartment" {{ old('property_type', $property->property_type) == 'apartment' ? 'selected' : '' }}>Apartment</option>
                                    <option value="block_of_flat" {{ old('property_type', $property->property_type) == 'block_of_flat' ? 'selected' : '' }}>Block of Flats</option>
                                    <option value="mansion" {{ old('property_type', $property->property_type) == 'mansion' ? 'selected' : '' }}>Mansion</option>
                                    <option value="townhouse" {{ old('property_type', $property->property_type) == 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                                    <option value="commercial" {{ old('property_type', $property->property_type) == 'commercial' ? 'selected' : '' }}>Commercial</option>
                                    <option value="land" {{ old('property_type', $property->property_type) == 'land' ? 'selected' : '' }}>Land</option>
                                </select>
                                @error('property_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea name="description" rows="5" required 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                      placeholder="Describe your property in detail...">{{ old('description', $property->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Property Details -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Property Details</h2>
                        <div class="grid md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Listing Type *</label>
                                <select name="type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                                    <option value="">Select Type</option>
                                    <option value="sale" {{ old('type', $property->type) == 'sale' ? 'selected' : '' }}>For Sale</option>
                                    <option value="rent" {{ old('type', $property->type) == 'rent' ? 'selected' : '' }}>For Rent</option>
                                    <option value="lease" {{ old('type', $property->type) == 'lease' ? 'selected' : '' }}>For Lease</option>
                                </select>
                                @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Price (₦) *</label>
                                <input type="number" name="price" required value="{{ old('price', $property->price) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                       placeholder="0.00">
                                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Rent Price (₦) <span class="text-gray-400 text-xs">(if rent)</span></label>
                                <input type="number" name="rent_price" value="{{ old('rent_price', $property->rent_price) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                       placeholder="0.00">
                                @error('rent_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-3 gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bedrooms</label>
                                <input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                       placeholder="Number of bedrooms">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bathrooms</label>
                                <input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                       placeholder="Number of bathrooms">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Area (sq ft)</label>
                                <input type="number" name="area_sqft" value="{{ old('area_sqft', $property->area_sqft) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                       placeholder="Square feet">
                            </div>
                        </div>

                        <div id="landDimensionSection" class="{{ old('property_type', $property->property_type) === 'land' ? '' : 'hidden' }} mt-6 rounded-xl border border-primary/20 bg-primary/5 p-5">
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Land Dimensions</h3>
                                <p class="text-sm text-gray-600">Optional for landed properties. Enter feet-by-feet or meter-by-meter and the system will calculate total square meters.</p>
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Length (ft)</label>
                                    <input type="number" step="0.01" min="0" name="land_length_ft" value="{{ old('land_length_ft', $property->land_length_ft) }}"
                                           class="land-dimension-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                           placeholder="e.g. 100">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Width (ft)</label>
                                    <input type="number" step="0.01" min="0" name="land_width_ft" value="{{ old('land_width_ft', $property->land_width_ft) }}"
                                           class="land-dimension-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                           placeholder="e.g. 50">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Length (m)</label>
                                    <input type="number" step="0.01" min="0" name="land_length_m" value="{{ old('land_length_m', $property->land_length_m) }}"
                                           class="land-dimension-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                           placeholder="e.g. 30">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Width (m)</label>
                                    <input type="number" step="0.01" min="0" name="land_width_m" value="{{ old('land_width_m', $property->land_width_m) }}"
                                           class="land-dimension-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                           placeholder="e.g. 15">
                                </div>
                            </div>

                            <div class="mt-4 rounded-lg border border-gray-200 bg-white px-4 py-3">
                                <p class="text-sm text-gray-500">Calculated total area</p>
                                <p id="areaSqmPreview" class="text-2xl font-bold text-primary">
                                    {{ $property->area_sqm ? number_format((float) $property->area_sqm, 2) . ' m²' : '-- m²' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Location Information -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Location</h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                                <input type="text" name="address" required value="{{ old('address', $property->address) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                       placeholder="Street address">
                                @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                <input type="text" name="city" required value="{{ old('city', $property->city) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                       placeholder="City">
                                @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                                <select name="state" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                                    <option value="">Select State</option>
                                    <option value="Abia" {{ old('state', $property->state) == 'Abia' ? 'selected' : '' }}>Abia</option>
                                    <option value="Adamawa" {{ old('state', $property->state) == 'Adamawa' ? 'selected' : '' }}>Adamawa</option>
                                    <option value="Akwa Ibom" {{ old('state', $property->state) == 'Akwa Ibom' ? 'selected' : '' }}>Akwa Ibom</option>
                                    <option value="Anambra" {{ old('state', $property->state) == 'Anambra' ? 'selected' : '' }}>Anambra</option>
                                    <option value="Bauchi" {{ old('state', $property->state) == 'Bauchi' ? 'selected' : '' }}>Bauchi</option>
                                    <option value="Bayelsa" {{ old('state', $property->state) == 'Bayelsa' ? 'selected' : '' }}>Bayelsa</option>
                                    <option value="Benue" {{ old('state', $property->state) == 'Benue' ? 'selected' : '' }}>Benue</option>
                                    <option value="Borno" {{ old('state', $property->state) == 'Borno' ? 'selected' : '' }}>Borno</option>
                                    <option value="Cross River" {{ old('state', $property->state) == 'Cross River' ? 'selected' : '' }}>Cross River</option>
                                    <option value="Delta" {{ old('state', $property->state) == 'Delta' ? 'selected' : '' }}>Delta</option>
                                    <option value="Ebonyi" {{ old('state', $property->state) == 'Ebonyi' ? 'selected' : '' }}>Ebonyi</option>
                                    <option value="Edo" {{ old('state', $property->state) == 'Edo' ? 'selected' : '' }}>Edo</option>
                                    <option value="Ekiti" {{ old('state', $property->state) == 'Ekiti' ? 'selected' : '' }}>Ekiti</option>
                                    <option value="Enugu" {{ old('state', $property->state) == 'Enugu' ? 'selected' : '' }}>Enugu</option>
                                    <option value="Gombe" {{ old('state', $property->state) == 'Gombe' ? 'selected' : '' }}>Gombe</option>
                                    <option value="Imo" {{ old('state', $property->state) == 'Imo' ? 'selected' : '' }}>Imo</option>
                                    <option value="Jigawa" {{ old('state', $property->state) == 'Jigawa' ? 'selected' : '' }}>Jigawa</option>
                                    <option value="Kaduna" {{ old('state', $property->state) == 'Kaduna' ? 'selected' : '' }}>Kaduna</option>
                                    <option value="Kano" {{ old('state', $property->state) == 'Kano' ? 'selected' : '' }}>Kano</option>
                                    <option value="Katsina" {{ old('state', $property->state) == 'Katsina' ? 'selected' : '' }}>Katsina</option>
                                    <option value="Kebbi" {{ old('state', $property->state) == 'Kebbi' ? 'selected' : '' }}>Kebbi</option>
                                    <option value="Kogi" {{ old('state', $property->state) == 'Kogi' ? 'selected' : '' }}>Kogi</option>
                                    <option value="Kwara" {{ old('state', $property->state) == 'Kwara' ? 'selected' : '' }}>Kwara</option>
                                    <option value="Lagos" {{ old('state', $property->state) == 'Lagos' ? 'selected' : '' }}>Lagos</option>
                                    <option value="Nasarawa" {{ old('state', $property->state) == 'Nasarawa' ? 'selected' : '' }}>Nasarawa</option>
                                    <option value="Niger" {{ old('state', $property->state) == 'Niger' ? 'selected' : '' }}>Niger</option>
                                    <option value="Ogun" {{ old('state', $property->state) == 'Ogun' ? 'selected' : '' }}>Ogun</option>
                                    <option value="Ondo" {{ old('state', $property->state) == 'Ondo' ? 'selected' : '' }}>Ondo</option>
                                    <option value="Osun" {{ old('state', $property->state) == 'Osun' ? 'selected' : '' }}>Osun</option>
                                    <option value="Oyo" {{ old('state', $property->state) == 'Oyo' ? 'selected' : '' }}>Oyo</option>
                                    <option value="Plateau" {{ old('state', $property->state) == 'Plateau' ? 'selected' : '' }}>Plateau</option>
                                    <option value="Rivers" {{ old('state', $property->state) == 'Rivers' ? 'selected' : '' }}>Rivers</option>
                                    <option value="Sokoto" {{ old('state', $property->state) == 'Sokoto' ? 'selected' : '' }}>Sokoto</option>
                                    <option value="Taraba" {{ old('state', $property->state) == 'Taraba' ? 'selected' : '' }}>Taraba</option>
                                    <option value="Yobe" {{ old('state', $property->state) == 'Yobe' ? 'selected' : '' }}>Yobe</option>
                                    <option value="Zamfara" {{ old('state', $property->state) == 'Zamfara' ? 'selected' : '' }}>Zamfara</option>
                                    <option value="FCT Abuja" {{ old('state', $property->state) == 'FCT Abuja' ? 'selected' : '' }}>FCT Abuja</option>
                                </select>
                                @error('state') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Zip Code</label>
                                <input type="text" name="zip_code" value="{{ old('zip_code', $property->zip_code) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                                       placeholder="Zip code">
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Features & Amenities</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @php
                                $featureOptions = ['Swimming Pool', 'Parking', 'Gym', 'Garden', 'Security', 'Balcony', 'Elevator', 'Furnished', 'Air Conditioning', 'Solar Panel', 'Water Heater', 'Internet'];
                                $selectedFeatures = old('features', $property->features ?? []);
                            @endphp
                            @foreach($featureOptions as $feature)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="features[]" value="{{ $feature }}" 
                                           {{ in_array($feature, (array)$selectedFeatures) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="text-sm text-gray-700">{{ $feature }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Existing Images -->
                    @if($property->images && count($property->images) > 0)
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Current Images</h2>
                        <div class="grid grid-cols-3 gap-4">
                            @foreach($property->images as $image)
                            <div class="relative">
                                <img src="{{ Storage::url($image) }}" class="w-full h-32 object-cover rounded-lg">
                                <button type="button" onclick="markImageForDeletion(this, '{{ $image }}')" 
                                        class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                    ×
                                </button>
                            </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="deleted_images" id="deleted_images" value="">
                    </div>
                    @endif

                    <!-- Add New Images -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Add New Images</h2>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                            <div class="text-center">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                <p class="text-gray-600 mb-2">Click or drag images to upload</p>
                                <p class="text-sm text-gray-500">You can upload multiple images (Max 5MB each)</p>
                                <input type="file" name="images[]" multiple accept="image/*" 
                                       class="hidden" id="imageUpload">
                                <button type="button" onclick="document.getElementById('imageUpload').click()"
                                        class="mt-3 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition">
                                    Select Images
                                </button>
                            </div>
                            <div id="imagePreview" class="grid grid-cols-3 gap-4 mt-4"></div>
                        </div>
                        @error('images.*') <p class="text-red-500 text-xs mt-1">Each image must be less than 5MB</p> @enderror
                    </div>

                    <!-- Video URL -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Video Tour URL (Optional)</label>
                        <input type="url" name="video_url" value="{{ old('video_url', $property->video_url) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"
                               placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition font-semibold">
                        <i class="fas fa-save mr-2"></i>Update Property
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const propertyTypeInput = document.querySelector('select[name="property_type"]');
    const landDimensionSection = document.getElementById('landDimensionSection');
    const areaSqmPreview = document.getElementById('areaSqmPreview');

    function toggleLandDimensionSection() {
        if (!propertyTypeInput || !landDimensionSection) return;
        landDimensionSection.classList.toggle('hidden', propertyTypeInput.value !== 'land');
    }

    function updateAreaSqmPreview() {
        if (!areaSqmPreview) return;

        const lengthFt = parseFloat(document.querySelector('input[name="land_length_ft"]')?.value || 0);
        const widthFt = parseFloat(document.querySelector('input[name="land_width_ft"]')?.value || 0);
        const lengthM = parseFloat(document.querySelector('input[name="land_length_m"]')?.value || 0);
        const widthM = parseFloat(document.querySelector('input[name="land_width_m"]')?.value || 0);

        let areaSqm = null;
        if (lengthM > 0 && widthM > 0) {
            areaSqm = lengthM * widthM;
        } else if (lengthFt > 0 && widthFt > 0) {
            areaSqm = (lengthFt * 0.3048) * (widthFt * 0.3048);
        }

        areaSqmPreview.textContent = areaSqm ? `${areaSqm.toFixed(2)} m²` : '-- m²';
    }

    propertyTypeInput?.addEventListener('change', toggleLandDimensionSection);
    document.querySelectorAll('.land-dimension-input').forEach(function(input) {
        input.addEventListener('input', updateAreaSqmPreview);
    });

    toggleLandDimensionSection();
    updateAreaSqmPreview();

    // Image preview for new images
    document.getElementById('imageUpload').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
                    <button type="button" onclick="this.parentElement.remove()" 
                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">
                        ×
                    </button>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    });

    // Handle image deletion
    function markImageForDeletion(button, imagePath) {
        if (confirm('Are you sure you want to delete this image?')) {
            button.parentElement.remove();
            let deletedImages = document.getElementById('deleted_images').value;
            if (deletedImages) {
                deletedImages += ',';
            }
            deletedImages += imagePath;
            document.getElementById('deleted_images').value = deletedImages;
        }
    }
</script>
@endsection
