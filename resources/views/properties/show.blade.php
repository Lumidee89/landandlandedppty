@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen pt-20">
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li><a href="/" class="text-gray-600 hover:text-primary">Home</a></li>
                    <li><i class="fas fa-chevron-right text-gray-400 text-sm"></i></li>
                    <li><a href="{{ route('properties.search') }}" class="text-gray-600 hover:text-primary">Properties</a></li>
                    <li><i class="fas fa-chevron-right text-gray-400 text-sm"></i></li>
                    <li><span class="text-gray-800">{{ Str::limit($property->title, 50) }}</span></li>
                </ol>
            </nav>
        </div>

        <!-- Main Property Details -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Image Gallery -->
            <div class="relative">
                @php
                    $propertyImages = collect($property->images ?? [])
                        ->map(fn ($image) => Storage::url($image))
                        ->values()
                        ->all();

                    if (count($propertyImages) === 0) {
                        $propertyImages = [$property->main_image];
                    }
                @endphp

                <div class="p-4">
                    <div class="relative overflow-hidden rounded-xl bg-gray-100">
                        @foreach($propertyImages as $index => $image)
                            <button type="button"
                                    class="property-carousel-slide {{ $index === 0 ? 'block' : 'hidden' }} w-full"
                                    data-index="{{ $index }}"
                                    onclick="openModal({{ $index }})">
                                <img src="{{ $image }}" alt="{{ $property->title }} image {{ $index + 1 }}"
                                     class="w-full h-80 md:h-[32rem] object-cover">
                            </button>
                        @endforeach

                        @if(count($propertyImages) > 1)
                            <button type="button"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white w-11 h-11 rounded-full flex items-center justify-center transition"
                                    onclick="movePropertySlide(-1)"
                                    aria-label="Previous property image">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button type="button"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white w-11 h-11 rounded-full flex items-center justify-center transition"
                                    onclick="movePropertySlide(1)"
                                    aria-label="Next property image">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <div class="absolute bottom-4 right-4 bg-black/60 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                <span id="propertyCarouselCurrent">1</span> / {{ count($propertyImages) }}
                            </div>
                        @endif
                    </div>

                    @if(count($propertyImages) > 1)
                        <div class="mt-3 flex gap-3 overflow-x-auto pb-1">
                            @foreach($propertyImages as $index => $image)
                                <button type="button"
                                        class="property-carousel-thumb shrink-0 w-24 h-20 rounded-lg overflow-hidden border-2 {{ $index === 0 ? 'border-primary' : 'border-transparent' }}"
                                        data-index="{{ $index }}"
                                        onclick="showPropertySlide({{ $index }})"
                                        aria-label="Show property image {{ $index + 1 }}">
                                    <img src="{{ $image }}" alt="{{ $property->title }} thumbnail {{ $index + 1 }}"
                                         class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Property Badges -->
                <div class="absolute top-6 left-6 flex gap-2">
                    <span class="bg-primary text-white px-4 py-2 rounded-lg font-semibold">
                        {{ ucfirst($property->type) }}
                    </span>
                    @if($property->is_featured)
                        <span class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold">
                            <i class="fas fa-star mr-1"></i> Featured
                        </span>
                    @endif
                </div>
            </div>

            <!-- Property Information -->
            <div class="p-8">
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Left Column - Property Details -->
                    <div class="lg:col-span-2">
                        <div class="mb-6">
                            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $property->title }}</h1>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                                <span>{{ $property->address }}, {{ $property->city }}, {{ $property->state }} {{ $property->zip_code }}</span>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="bg-gradient-to-r from-primary/10 to-transparent p-4 rounded-xl mb-6">
                            <div class="text-3xl font-bold text-primary">{{ $property->formatted_price }}</div>
                        </div>

                        <!-- Key Features -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                            @if($property->bedrooms)
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <i class="fas fa-bed text-primary text-2xl mb-2"></i>
                                    <p class="font-semibold text-gray-800">{{ $property->bedrooms }}</p>
                                    <p class="text-sm text-gray-600">Bedrooms</p>
                                </div>
                            @endif
                            @if($property->bathrooms)
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <i class="fas fa-bath text-primary text-2xl mb-2"></i>
                                    <p class="font-semibold text-gray-800">{{ $property->bathrooms }}</p>
                                    <p class="text-sm text-gray-600">Bathrooms</p>
                                </div>
                            @endif
                            @if($property->area_sqm)
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <i class="fas fa-ruler-combined text-primary text-2xl mb-2"></i>
                                    <p class="font-semibold text-gray-800">{{ number_format((float) $property->area_sqm, 2) }}</p>
                                    <p class="text-sm text-gray-600">Sq Meters</p>
                                </div>
                            @endif
                            @if($property->area_sqft)
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <i class="fas fa-vector-square text-primary text-2xl mb-2"></i>
                                    <p class="font-semibold text-gray-800">{{ number_format($property->area_sqft) }}</p>
                                    <p class="text-sm text-gray-600">Sq Ft</p>
                                </div>
                            @endif
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <i class="fas fa-eye text-primary text-2xl mb-2"></i>
                                <p class="font-semibold text-gray-800">{{ $property->views }}</p>
                                <p class="text-sm text-gray-600">Views</p>
                            </div>
                        </div>

                        <!-- Property Type Badge -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Property Type</h3>
                            <span class="inline-block bg-primary/10 text-primary px-4 py-2 rounded-lg font-semibold">
                                {{ $property->getPropertyTypeLabelAttribute() }}
                            </span>
                        </div>

                        <!-- Description -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Description</h3>
                            <div class="prose max-w-none text-gray-600 leading-relaxed">
                                {{ $property->description }}
                            </div>
                        </div>

                        <!-- Features & Amenities -->
                        @if($property->features && count($property->features) > 0)
                            <div class="mb-8">
                                <h3 class="text-xl font-bold text-gray-800 mb-3">Features & Amenities</h3>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach($property->features as $feature)
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-primary mr-2"></i>
                                            <span class="text-gray-600">{{ $feature }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Video Tour -->
                        @if($property->video_url)
                            <div class="mb-8">
                                <h3 class="text-xl font-bold text-gray-800 mb-3">Video Tour</h3>
                                <div class="aspect-w-16 aspect-h-9">
                                    <iframe class="w-full h-96 rounded-xl" 
                                            src="{{ str_replace('watch?v=', 'embed/', $property->video_url) }}" 
                                            frameborder="0" 
                                            allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        @endif

                        <!-- Location Map -->
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Location</h3>
                            <div class="bg-gray-200 rounded-xl h-64 flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-map-marker-alt text-4xl text-primary mb-2"></i>
                                    <p class="text-gray-600">{{ $property->address }}, {{ $property->city }}</p>
                                    <p class="text-sm text-gray-500 mt-2">Interactive map coming soon</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Agent & Contact Form -->
                    <div class="lg:col-span-1">
                        <!-- Agent Card -->
                        <div class="bg-gray-50 rounded-xl p-6 sticky top-24">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Listed By</h3>
                            
                            <div class="text-center mb-4">
                                <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-user-tie text-4xl text-primary"></i>
                                </div>
                                <h4 class="text-lg font-bold text-gray-800">{{ $property->user->name }}</h4>
                                <p class="text-primary text-sm font-semibold mt-1">
                                    <i class="fas fa-check-circle mr-1"></i> Verified Agent
                                </p>
                            </div>

                            <div class="space-y-3 mb-6">
                                @if($property->user->phone)
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-primary w-6"></i>
                                        <span class="text-gray-600">{{ $property->user->phone }}</span>
                                    </div>
                                @endif
                                @if($property->user->email)
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope text-primary w-6"></i>
                                        <span class="text-gray-600">{{ $property->user->email }}</span>
                                    </div>
                                @endif
                                @if($property->user->license_number)
                                    <div class="flex items-center">
                                        <i class="fas fa-id-card text-primary w-6"></i>
                                        <span class="text-gray-600">License: {{ $property->user->license_number }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Contact Form -->
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="font-semibold text-gray-800 mb-3">Contact Agent</h4>
                                
                                @if(session('success'))
                                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form action="{{ route('properties.inquiry', $property) }}" method="POST">
                                    @csrf
                                    <div class="space-y-3">
                                        <div>
                                            <input type="text" name="name" required 
                                                   value="{{ Auth::user()->name ?? old('name') }}"
                                                   placeholder="Your Name"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                                        </div>
                                        <div>
                                            <input type="email" name="email" required
                                                   value="{{ Auth::user()->email ?? old('email') }}"
                                                   placeholder="Your Email"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                                        </div>
                                        <div>
                                            <input type="tel" name="phone" required
                                                   value="{{ Auth::user()->phone ?? old('phone') }}"
                                                   placeholder="Your Phone Number"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                                        </div>
                                        <div>
                                            <textarea name="message" rows="4" required
                                                      placeholder="I'm interested in this property. Please contact me with more information..."
                                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary"></textarea>
                                        </div>
                                        <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary/90 transition">
                                            <i class="fas fa-paper-plane mr-2"></i> Send Inquiry
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Share Buttons -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <p class="text-sm text-gray-600 mb-3">Share this property:</p>
                                <div class="flex space-x-2">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                                       target="_blank" class="flex-1 bg-blue-600 text-white py-2 rounded-lg text-center hover:bg-blue-700 transition">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($property->title) }}" 
                                       target="_blank" class="flex-1 bg-blue-400 text-white py-2 rounded-lg text-center hover:bg-blue-500 transition">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://wa.me/?text={{ urlencode($property->title . ' - ' . url()->current()) }}" 
                                       target="_blank" class="flex-1 bg-green-600 text-white py-2 rounded-lg text-center hover:bg-green-700 transition">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Properties -->
        @if($relatedProperties->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Similar Properties You Might Like</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProperties as $related)
                        <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group">
                            <div class="relative overflow-hidden">
                                <img src="{{ $related->main_image }}" alt="{{ $related->title }}" 
                                     class="w-full h-48 object-cover group-hover:scale-110 transition duration-500">
                                <div class="absolute top-2 right-2">
                                    <span class="bg-primary text-white px-2 py-1 rounded text-xs">
                                        {{ ucfirst($related->type) }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-1 line-clamp-1">{{ $related->title }}</h3>
                                <div class="text-primary font-bold mb-2">{{ $related->formatted_price }}</div>
                                <div class="flex items-center text-gray-500 text-sm mb-3">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    <span>{{ $related->city }}, {{ $related->state }}</span>
                                </div>
                                <a href="{{ route('properties.show', $related) }}" class="block text-center bg-gray-100 text-gray-700 py-2 rounded-lg hover:bg-primary hover:text-white transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center p-4" onclick="closeModal()">
    <div class="relative w-full max-w-6xl" onclick="event.stopPropagation()">
        <img id="modalImage" src="" alt="Full size" class="w-full max-h-[85vh] object-contain rounded-lg">
        <button type="button" onclick="closeModal()" class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300" aria-label="Close image carousel">
            <i class="fas fa-times"></i>
        </button>
        @if(count($propertyImages) > 1)
            <button type="button"
                    onclick="moveModalSlide(-1)"
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white w-11 h-11 rounded-full flex items-center justify-center transition"
                    aria-label="Previous image">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button type="button"
                    onclick="moveModalSlide(1)"
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white w-11 h-11 rounded-full flex items-center justify-center transition"
                    aria-label="Next image">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black/60 text-white px-3 py-1 rounded-full text-sm font-semibold">
                <span id="modalCarouselCurrent">1</span> / {{ count($propertyImages) }}
            </div>
        @endif
    </div>
</div>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .aspect-w-16 {
        position: relative;
        padding-bottom: 56.25%;
    }
    
    .aspect-w-16 iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>

<script>
    const propertyImages = @json($propertyImages);
    let propertySlideIndex = 0;
    let modalSlideIndex = 0;

    function showPropertySlide(index) {
        propertySlideIndex = (index + propertyImages.length) % propertyImages.length;

        document.querySelectorAll('.property-carousel-slide').forEach(function(slide) {
            slide.classList.toggle('hidden', Number(slide.dataset.index) !== propertySlideIndex);
            slide.classList.toggle('block', Number(slide.dataset.index) === propertySlideIndex);
        });

        document.querySelectorAll('.property-carousel-thumb').forEach(function(thumb) {
            thumb.classList.toggle('border-primary', Number(thumb.dataset.index) === propertySlideIndex);
            thumb.classList.toggle('border-transparent', Number(thumb.dataset.index) !== propertySlideIndex);
        });

        const counter = document.getElementById('propertyCarouselCurrent');
        if (counter) counter.textContent = propertySlideIndex + 1;
    }

    function movePropertySlide(direction) {
        showPropertySlide(propertySlideIndex + direction);
    }

    function showModalSlide(index) {
        modalSlideIndex = (index + propertyImages.length) % propertyImages.length;
        document.getElementById('modalImage').src = propertyImages[modalSlideIndex];

        const counter = document.getElementById('modalCarouselCurrent');
        if (counter) counter.textContent = modalSlideIndex + 1;
    }

    function moveModalSlide(direction) {
        showModalSlide(modalSlideIndex + direction);
    }

    function openModal(index) {
        const modal = document.getElementById('imageModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        showModalSlide(index);
        document.body.style.overflow = 'hidden';
    }
    
    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        const modalIsOpen = document.getElementById('imageModal').classList.contains('flex');

        if (e.key === 'Escape') {
            closeModal();
        } else if (modalIsOpen && e.key === 'ArrowLeft') {
            moveModalSlide(-1);
        } else if (modalIsOpen && e.key === 'ArrowRight') {
            moveModalSlide(1);
        }
    });
</script>
@endsection
