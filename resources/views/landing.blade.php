@extends('layouts.app')

@section('content')
<!-- Navigation -->
<nav class="bg-white shadow-md fixed w-full z-50 transition-all duration-300">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <i class="fas fa-home text-primary text-2xl"></i>
                <span class="text-2xl font-bold text-gray-800">Land & Landed<span class="text-primary"> Properties</span></span>
            </div>
            
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('properties.search', ['purpose' => 'sale']) }}" class="text-gray-700 hover:text-primary transition font-medium">Buy</a>
                <a href="{{ route('properties.search', ['purpose' => 'rent']) }}" class="text-gray-700 hover:text-primary transition font-medium">Rent</a>
                <a href="{{ route('properties.search', ['purpose' => 'lease']) }}" class="text-gray-700 hover:text-primary transition font-medium">Lease</a>
                <a href="{{ route('register') }}" class="text-gray-700 hover:text-primary transition font-medium">Agents</a>
            </div>
            
            <div class="flex space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-primary text-white px-5 py-2 rounded-lg hover:bg-primary/90 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-200 transition">
                        Log In
                    </a>
                    <a href="{{ route('register') }}" class="bg-primary text-white px-5 py-2 rounded-lg hover:bg-primary/90 transition">
                        Create an account
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section with Enhanced Search -->
<section class="relative min-h-screen flex items-center pt-16 overflow-hidden" id="hero-section">
    <!-- Carousel Images -->
    <div class="absolute inset-0 w-full h-full">
        <div class="carousel-container relative w-full h-full">
            <div class="carousel-slide absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out opacity-0">
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/50 z-10"></div>
                <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3" 
                     alt="Luxury Villa" 
                     class="w-full h-full object-cover">
            </div>
            <div class="carousel-slide absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out opacity-0">
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/50 z-10"></div>
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3" 
                     alt="Modern Apartment" 
                     class="w-full h-full object-cover">
            </div>
            <div class="carousel-slide absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out opacity-0">
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/50 z-10"></div>
                <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3" 
                     alt="Luxury House" 
                     class="w-full h-full object-cover">
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="container mx-auto px-4 relative z-20">
        <div class="text-center text-white max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 animate-fadeInUp leading-tight">
                Find Your <span class="text-primary">Dream Property</span> in Nigeria
            </h1>
            <p class="text-xl mb-10 animate-fadeInUp animation-delay-200 text-gray-200">
                Discover the best properties for sale, rent, and lease across Nigeria
            </p>
            
            <!-- Enhanced Search Bar -->
            <form action="{{ route('properties.search') }}" method="GET" class="bg-white rounded-2xl shadow-2xl p-6 animate-fadeInUp animation-delay-400">
                <div class="grid md:grid-cols-4 gap-4">
                    <div class="relative group">
                        <i class="fas fa-search absolute left-3 top-3.5 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                        <input type="text" 
                               name="search"
                               placeholder="Search by location, property type..." 
                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-gray-800 placeholder-gray-400 bg-white transition-all">
                    </div>
                    
                    <div class="relative group">
                        <i class="fas fa-home absolute left-3 top-3.5 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                        <select name="property_type" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-gray-800 bg-white appearance-none cursor-pointer">
                            <option value="">Property Type</option>
                            <option value="bungalow">Bungalow</option>
                            <option value="duplex">Duplex</option>
                            <option value="apartment">Apartment</option>
                            <option value="block_of_flat">Block of Flats</option>
                            <option value="mansion">Mansion</option>
                            <option value="townhouse">Townhouse</option>
                            <option value="commercial">Commercial</option>
                            <option value="land">Land</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3.5 text-gray-400 pointer-events-none"></i>
                    </div>
                    
                    <div class="relative group">
                        <i class="fas fa-tag absolute left-3 top-3.5 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                        <select name="purpose" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-gray-800 bg-white appearance-none cursor-pointer">
                            <option value="">Purpose</option>
                            <option value="sale">For Sale</option>
                            <option value="rent">For Rent</option>
                            <option value="lease">For Lease</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3.5 text-gray-400 pointer-events-none"></i>
                    </div>
                    
                    <button type="submit" class="bg-primary text-white py-3 rounded-lg hover:bg-primary/90 transition font-semibold shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-search"></i>
                        <span>Search Properties</span>
                    </button>
                </div>
                
                <!-- Advanced Filters Toggle -->
                <div class="mt-4 text-center">
                    <button type="button" id="advancedFiltersBtn" class="text-sm text-gray-500 hover:text-primary transition">
                        <i class="fas fa-sliders-h mr-1"></i> Advanced Filters
                    </button>
                </div>
                
                <!-- Advanced Filters -->
                <div id="advancedFilters" class="hidden mt-4 pt-4 border-t border-gray-200">
                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Min Price (₦)</label>
                            <input type="number" name="min_price" placeholder="Min Price" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Max Price (₦)</label>
                            <input type="number" name="max_price" placeholder="Max Price" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bedrooms</label>
                            <select name="bedrooms" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                                <option value="">Any</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                                <option value="5">5+</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Carousel Controls -->
    <div class="absolute bottom-8 left-0 right-0 z-20 flex justify-center space-x-3">
        <button class="carousel-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all duration-300" data-slide="0"></button>
        <button class="carousel-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all duration-300" data-slide="1"></button>
        <button class="carousel-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all duration-300" data-slide="2"></button>
    </div>

    <button class="carousel-prev absolute left-4 md:left-8 top-1/2 transform -translate-y-1/2 z-20 bg-white/20 hover:bg-white/30 text-white w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center transition-all duration-300">
        <i class="fas fa-chevron-left text-xl"></i>
    </button>
    <button class="carousel-next absolute right-4 md:right-8 top-1/2 transform -translate-y-1/2 z-20 bg-white/20 hover:bg-white/30 text-white w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center transition-all duration-300">
        <i class="fas fa-chevron-right text-xl"></i>
    </button>
</section>

<!-- Featured Properties with Modern Design -->
<section id="featured-properties" class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="text-primary font-semibold text-sm uppercase tracking-wider">Featured Listings</span>
            <h2 class="text-4xl font-bold text-gray-800 mb-4 mt-2">Hand-picked Properties Just for You</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Discover our most exclusive properties curated by our expert team</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredProperties as $property)
            <div class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="relative overflow-hidden">
                    <img src="{{ $property->main_image }}" alt="{{ $property->title }}" 
                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute top-4 left-4">
                        <span class="bg-primary text-white px-3 py-1 rounded-full text-xs font-semibold">
                            {{ ucfirst($property->type) }}
                        </span>
                    </div>
                    @if($property->is_featured)
                    <div class="absolute top-4 right-4">
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-star mr-1"></i> Featured
                        </span>
                    </div>
                    @endif
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                        <div class="text-white">
                            <div class="flex items-center text-sm">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                <span>{{ $property->city }}, {{ $property->state }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-1">{{ $property->title }}</h3>
                    <div class="text-2xl font-bold text-primary mb-4">{{ $property->formatted_price }}</div>
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex space-x-4">
                            @if($property->bedrooms)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-bed text-primary mr-1"></i>
                                <span class="text-sm">{{ $property->bedrooms }} beds</span>
                            </div>
                            @endif
                            @if($property->bathrooms)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-bath text-primary mr-1"></i>
                                <span class="text-sm">{{ $property->bathrooms }} baths</span>
                            </div>
                            @endif
                            @if($property->area_sqm)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-ruler-combined text-primary mr-1"></i>
                                <span class="text-sm">{{ number_format((float) $property->area_sqm, 2) }} m²</span>
                            </div>
                            @endif
                            @if($property->area_sqft)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-vector-square text-primary mr-1"></i>
                                <span class="text-sm">{{ number_format($property->area_sqft) }} sqft</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-primary text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-600 ml-2">{{ $property->user->name ?? 'Agent' }}</span>
                        </div>
                        <a href="{{ route('properties.show', $property) }}" class="text-primary hover:text-primary/80 font-semibold text-sm">
                            View Details <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">No featured properties available.</p>
            </div>
            @endforelse
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('properties.search') }}" class="inline-flex items-center bg-primary text-white px-8 py-3 rounded-lg hover:bg-primary/90 transition font-semibold shadow-md hover:shadow-lg">
                Browse All Properties
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-primary">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-4 gap-8 text-center text-white">
            <div>
                <div class="text-4xl font-bold mb-2">{{ number_format($totalProperties ?? 0) }}+</div>
                <div class="text-white/80">Properties Listed</div>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">{{ number_format($totalAgents ?? 0) }}+</div>
                <div class="text-white/80">Trusted Agents</div>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">{{ number_format($happyCustomers ?? 0) }}+</div>
                <div class="text-white/80">Happy Customers</div>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">{{ number_format($totalCities ?? 0) }}+</div>
                <div class="text-white/80">Cities Covered</div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="text-primary font-semibold text-sm uppercase tracking-wider">Why Choose Us</span>
            <h2 class="text-4xl font-bold text-gray-800 mb-4 mt-2">We Make Property Transactions Seamless</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Experience the best real estate service with our trusted platform</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center group hover:transform hover:scale-105 transition duration-300">
                <div class="w-20 h-20 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary/20 transition transform rotate-0 group-hover:rotate-6">
                    <i class="fas fa-shield-alt text-3xl text-primary"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Verified Properties</h3>
                <p class="text-gray-600">All properties are verified by our team to ensure authenticity and quality</p>
            </div>
            <div class="text-center group hover:transform hover:scale-105 transition duration-300">
                <div class="w-20 h-20 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary/20 transition transform rotate-0 group-hover:rotate-6">
                    <i class="fas fa-handshake text-3xl text-primary"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Trusted Agents</h3>
                <p class="text-gray-600">Work with licensed and verified real estate professionals</p>
            </div>
            <div class="text-center group hover:transform hover:scale-105 transition duration-300">
                <div class="w-20 h-20 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary/20 transition transform rotate-0 group-hover:rotate-6">
                    <i class="fas fa-chart-line text-3xl text-primary"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Best Prices</h3>
                <p class="text-gray-600">Get the best market prices for your dream property with no hidden fees</p>
            </div>
        </div>
    </div>
</section>

<!-- Recent Properties Grid -->
<section id="recent-properties" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="text-primary font-semibold text-sm uppercase tracking-wider">New Listings</span>
            <h2 class="text-4xl font-bold text-gray-800 mb-4 mt-2">Recently Added Properties</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Check out the latest properties on our platform</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($recentProperties as $property)
            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group">
                <div class="relative overflow-hidden">
                    <img src="{{ $property->main_image }}" alt="{{ $property->title }}" 
                         class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <a href="{{ route('properties.show', $property) }}" class="bg-white text-primary px-4 py-2 rounded-lg font-semibold text-sm hover:bg-primary hover:text-white transition">
                            Quick View
                        </a>
                    </div>
                </div>
                <div class="p-4">
                                    <h3 class="font-bold text-gray-800 mb-1 line-clamp-1">{{ Str::limit($property->title, 40) }}</h3>
                    <div class="text-primary font-bold mb-2">{{ $property->formatted_price }}</div>
                    <div class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-map-marker-alt mr-1 text-primary"></i>
                        <span>{{ $property->city }}, {{ $property->state }}</span>
                    </div>
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            <span>{{ $property->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="fas fa-eye mr-1"></i>
                            <span>{{ $property->views }} views</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center py-12">
                <p class="text-gray-500">No properties available yet.</p>
            </div>
            @endforelse
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('properties.search') }}" class="inline-flex items-center text-primary hover:text-primary/80 font-semibold">
                View All Properties
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-16 bg-gradient-to-r from-primary to-primary/80">
    <div class="container mx-auto px-4 text-center">
        <h3 class="text-3xl font-bold text-white mb-4">Stay Updated with New Properties</h3>
        <p class="text-white/90 mb-8 max-w-2xl mx-auto">Subscribe to our newsletter and get the latest property listings delivered to your inbox</p>
        <form class="max-w-md mx-auto flex flex-col md:flex-row gap-4">
            <input type="email" placeholder="Enter your email address" 
                   class="flex-1 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-white">
            <button type="submit" class="bg-white text-primary px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Subscribe Now
            </button>
        </form>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <i class="fas fa-home text-primary text-2xl"></i>
                    <span class="text-xl font-bold">Land & Landed Properties</span>
                </div>
                <p class="text-gray-400">Find your dream property in Nigeria with ease and confidence.</p>
                <div class="flex space-x-4 mt-4">
                    <a href="{{ route('landing') }}" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary transition" aria-label="Home">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="{{ route('properties.search') }}" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary transition" aria-label="Browse properties">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="{{ route('register') }}" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary transition" aria-label="Register">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ route('login') }}" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary transition" aria-label="Login">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
            <div>
                <h3 class="font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('landing') }}" class="hover:text-primary transition">About Us</a></li>
                    <li><a href="mailto:info@landandlandedproperties.com" class="hover:text-primary transition">Contact Us</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="hover:text-primary transition">Privacy Policy</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-primary transition">Terms of Service</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-4">Property Types</h3>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('properties.search', ['property_type' => 'apartment']) }}" class="hover:text-primary transition">Apartments</a></li>
                    <li><a href="{{ route('properties.search', ['property_type' => 'bungalow']) }}" class="hover:text-primary transition">Houses</a></li>
                    <li><a href="{{ route('properties.search', ['property_type' => 'land']) }}" class="hover:text-primary transition">Lands</a></li>
                    <li><a href="{{ route('properties.search', ['property_type' => 'commercial']) }}" class="hover:text-primary transition">Commercial</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-4">Contact Info</h3>
                <ul class="space-y-2 text-gray-400">
                    <li><i class="fas fa-phone mr-2"></i> +234 123 456 7890</li>
                    <li><i class="fas fa-envelope mr-2"></i> info@landandlandedproperties.com</li>
                    <li><i class="fas fa-map-marker-alt mr-2"></i> Abuja, Nigeria</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; 2026 Land & Landed Properties. All rights reserved.</p>
        </div>
    </div>
</footer>

<style>
    /* Animation Keyframes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fadeInUp {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .animation-delay-200 {
        animation-delay: 0.2s;
        opacity: 0;
    }
    
    .animation-delay-400 {
        animation-delay: 0.4s;
        opacity: 0;
    }
    
    /* Carousel transitions */
    .carousel-slide {
        transition: opacity 1s ease-in-out;
    }
    
    .carousel-slide.active {
        opacity: 1 !important;
        z-index: 1;
    }
    
    .carousel-dot.active {
        background-color: white;
        width: 2rem;
    }
    
    /* Line clamp for text */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    // Advanced Filters Toggle
    document.getElementById('advancedFiltersBtn')?.addEventListener('click', function() {
        const filters = document.getElementById('advancedFilters');
        filters.classList.toggle('hidden');
        const icon = this.querySelector('i');
        if (icon.classList.contains('fa-sliders-h')) {
            icon.classList.remove('fa-sliders-h');
            icon.classList.add('fa-sliders-h');
        }
    });
    
    // Carousel Functionality - FIXED VERSION
    (function() {
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded - initializing carousel');
            
            const slides = document.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll('.carousel-dot');
            const prevBtn = document.querySelector('.carousel-prev');
            const nextBtn = document.querySelector('.carousel-next');
            
            if (!slides.length) {
                console.error('No carousel slides found');
                return;
            }
            
            console.log('Found', slides.length, 'slides');
            
            let currentSlide = 0;
            let slideCount = slides.length;
            let autoPlayInterval = null;
            const autoPlayDelay = 4000; // 2 seconds
            
            // Function to show a specific slide
            function showSlide(index) {
                // Remove active class from all slides
                slides.forEach(slide => {
                    slide.classList.remove('active');
                });
                
                // Remove active class from all dots
                dots.forEach(dot => {
                    dot.classList.remove('active');
                });
                
                // Add active class to current slide and dot
                slides[index].classList.add('active');
                if (dots[index]) {
                    dots[index].classList.add('active');
                }
                
                currentSlide = index;
                console.log('Showing slide:', index);
            }
            
            // Function to show next slide
            function nextSlide() {
                let nextIndex = currentSlide + 1;
                if (nextIndex >= slideCount) {
                    nextIndex = 0;
                }
                showSlide(nextIndex);
            }
            
            // Function to show previous slide
            function prevSlide() {
                let prevIndex = currentSlide - 1;
                if (prevIndex < 0) {
                    prevIndex = slideCount - 1;
                }
                showSlide(prevIndex);
            }
            
            // Start auto-play
            function startAutoPlay() {
                if (autoPlayInterval) {
                    clearInterval(autoPlayInterval);
                }
                console.log('Starting auto-play with delay:', autoPlayDelay, 'ms');
                autoPlayInterval = setInterval(() => {
                    console.log('Auto-changing slide...');
                    nextSlide();
                }, autoPlayDelay);
            }
            
            // Stop auto-play
            function stopAutoPlay() {
                if (autoPlayInterval) {
                    console.log('Stopping auto-play');
                    clearInterval(autoPlayInterval);
                    autoPlayInterval = null;
                }
            }
            
            // Reset auto-play
            function resetAutoPlay() {
                stopAutoPlay();
                startAutoPlay();
            }
            
            // Show first slide
            showSlide(0);
            
            // Start auto-play
            startAutoPlay();
            
            // Add event listeners for buttons
            if (prevBtn) {
                prevBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Previous button clicked');
                    prevSlide();
                    resetAutoPlay();
                });
            }
            
            if (nextBtn) {
                nextBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Next button clicked');
                    nextSlide();
                    resetAutoPlay();
                });
            }
            
            // Add event listeners for dots
            dots.forEach((dot, index) => {
                dot.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Dot', index, 'clicked');
                    showSlide(index);
                    resetAutoPlay();
                });
            });
            
            // Pause auto-play on hover
            const heroSection = document.getElementById('hero-section');
            if (heroSection) {
                heroSection.addEventListener('mouseenter', function() {
                    console.log('Mouse entered - pausing auto-play');
                    stopAutoPlay();
                });
                heroSection.addEventListener('mouseleave', function() {
                    console.log('Mouse left - resuming auto-play');
                    startAutoPlay();
                });
            }
            
            console.log('Carousel initialized successfully');
        });
    })();
</script>
@endsection
