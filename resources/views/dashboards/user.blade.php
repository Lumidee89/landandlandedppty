@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen pt-16">
    <div class="container mx-auto px-4 py-8">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-primary to-primary/70 rounded-2xl p-8 mb-8 text-white">
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}"
                         class="h-20 w-20 rounded-full border-4 border-white/20 object-cover">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                        <p class="text-lg opacity-90">Find your dream property or manage your favorites</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center rounded-lg bg-white px-5 py-3 font-semibold text-primary transition hover:bg-gray-100">
                    <i class="fas fa-user-edit mr-2"></i> Edit Profile
                </a>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Saved Properties</p>
                        <p class="text-3xl font-bold text-gray-800">{{ Auth::user()->favorites()->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                        <i class="fas fa-heart text-primary text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Inquiries Sent</p>
                        <p class="text-3xl font-bold text-gray-800">{{ Auth::user()->inquiries()->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                        <i class="fas fa-envelope text-primary text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Properties Viewed</p>
                        <p class="text-3xl font-bold text-gray-800">24</p>
                    </div>
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                        <i class="fas fa-eye text-primary text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Favorites Section -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Your Saved Properties</h2>
                <a href="{{ route('properties.search') }}" class="text-primary hover:text-primary/80">View All →</a>
            </div>
            
            @if($favorites->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($favorites as $property)
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg property-card transition">
                        <img src="{{ $property->main_image }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-1">{{ $property->title }}</h3>
                            <div class="text-primary font-bold mb-2">{{ $property->formatted_price }}</div>
                            <div class="flex items-center text-gray-500 text-sm mb-3">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                <span>{{ $property->city }}, {{ $property->state }}</span>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('properties.show', $property) }}" class="flex-1 bg-primary text-white px-3 py-2 rounded-lg hover:bg-primary/90 text-sm text-center">
                                    View Details
                                </a>
                                <button class="px-3 py-2 border border-red-500 text-red-500 rounded-lg hover:bg-red-50">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl shadow-md p-12 text-center">
                    <i class="fas fa-heart-broken text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No saved properties yet</h3>
                    <p class="text-gray-500 mb-4">Start exploring properties and save your favorites</p>
                    <a href="{{ route('properties.search') }}" class="bg-primary text-white px-6 py-2 rounded-lg inline-block">Browse Properties</a>
                </div>
            @endif
        </div>
        
        <!-- Recent Inquiries -->
        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Recent Inquiries</h2>
                <a href="{{ route('properties.search') }}" class="text-primary hover:text-primary/80">View All →</a>
            </div>
            
            @if($inquiries->count() > 0)
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    @foreach($inquiries as $inquiry)
                    <div class="border-b border-gray-200 p-4 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <a href="{{ route('properties.show', $inquiry->property) }}" class="font-semibold text-gray-800 hover:text-primary">
                                    {{ $inquiry->property->title }}
                                </a>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($inquiry->message, 100) }}</p>
                                <span class="inline-block text-xs text-gray-500 mt-2">{{ $inquiry->created_at->diffForHumans() }}</span>
                            </div>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Pending</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl shadow-md p-12 text-center">
                    <i class="fas fa-comments text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No inquiries yet</h3>
                    <p class="text-gray-500">Contact agents about properties you're interested in</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
