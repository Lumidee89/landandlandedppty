@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen pt-20">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Search Results</h1>
            <p class="text-gray-600">Found {{ $properties->total() }} properties matching your criteria</p>
        </div>
        
        <div class="grid lg:grid-cols-4 gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                    <h3 class="font-bold text-gray-800 mb-4">Filter Properties</h3>
                    <form action="{{ route('properties.search') }}" method="GET">
                        <!-- Add filter inputs here -->
                        <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg">Apply Filters</button>
                    </form>
                </div>
            </div>
            
            <!-- Results -->
            <div class="lg:col-span-3">
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($properties as $property)
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition">
                        <a href="{{ route('properties.show', $property) }}">
                            <img src="{{ $property->main_image }}" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800">{{ $property->title }}</h3>
                            <div class="text-primary font-bold">{{ $property->formatted_price }}</div>
                            <div class="flex items-center text-gray-500 text-sm mt-2">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                <span>{{ $property->city }}, {{ $property->state }}</span>
                            </div>
                            <a href="{{ route('properties.show', $property) }}" class="block text-center mt-4 bg-primary text-white py-2 rounded-lg hover:bg-primary/90 transition">
                                View Details
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $properties->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection