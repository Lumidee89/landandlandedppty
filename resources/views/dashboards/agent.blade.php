@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen pt-16">
    <div class="container mx-auto px-4 py-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-green-700">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-700">&times;</button>
            </div>
        @endif

        <!-- Welcome Header with Add Property Button and Logout -->
        <div class="bg-gradient-to-r from-primary to-primary/70 rounded-2xl p-8 mb-8 text-white">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}"
                         class="h-20 w-20 rounded-full border-4 border-white/20 object-cover">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Agent Dashboard - <span> {{ Auth::user()->name }} </span></h1>
                        <p class="text-lg opacity-90">Manage your properties and track performance</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('profile.edit') }}" class="bg-white text-primary px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition inline-flex items-center">
                        <i class="fas fa-user-edit mr-2"></i>Edit Profile
                    </a>
                    @if(Auth::user()->hasActiveSubscription())

                    <a href="{{ route('properties.create') }}"
                    class="bg-white text-primary px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i>Add New Property
                    </a>

                    @else

                    <a href="{{ route('agent.subscription') }}"
                    class="bg-red-500 text-white px-6 py-2 rounded-lg font-semibold inline-flex items-center">
                        <i class="fas fa-lock mr-2"></i>Subscribe to Post
                    </a>

                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-white/20 hover:bg-white/30 text-white px-6 py-2 rounded-lg transition flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if(Auth::user()->hasActiveSubscription())

        <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-xl mb-6">
            Your subscription is active until
            <strong>
                {{ Auth::user()->subscription_expires_at->format('F d, Y') }}
            </strong>
        </div>

        @else

        <div class="bg-red-100 border border-red-300 text-red-800 p-4 rounded-xl mb-6">
            Your subscription has expired.

            <a
                href="{{ route('agent.subscription') }}"
                class="underline font-semibold"
            >
                Renew Subscription
            </a>
        </div>

        @endif
        
        <!-- Stats Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Properties</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalProperties }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-building text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Active Listings</p>
                        <p class="text-3xl font-bold text-green-600">{{ $activeProperties }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Pending Approval</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $pendingProperties }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Views</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $totalViews }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-eye text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Properties Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">Your Properties</h2>
                @if(Auth::user()->hasActiveSubscription())

                <a href="{{ route('properties.create') }}"
                class="text-primary hover:text-primary/80 text-sm">
                    <i class="fas fa-plus mr-1"></i> Add New
                </a>

                @else

                <a href="{{ route('agent.subscription') }}"
                class="text-red-500 text-sm font-semibold">
                    <i class="fas fa-lock mr-1"></i> Subscribe
                </a>

                @endif
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Property</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Views</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($properties as $property)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img src="{{ $property->main_image }}" class="w-12 h-12 rounded object-cover mr-3">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ Str::limit($property->title, 30) }}</div>
                                        <div class="text-sm text-gray-500">{{ $property->city }}, {{ $property->state }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="capitalize">{{ $property->type }}</span>
                            </td>
                            <td class="px-6 py-4 font-semibold">{{ $property->formatted_price }}</td>
                            <td class="px-6 py-4">
                                @if($property->status == 'active')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                                @elseif($property->status == 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Pending</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">{{ ucfirst($property->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $property->views }}</td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('properties.edit', $property) }}" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('properties.destroy', $property) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this property?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($properties->count() == 0)
                <div class="p-12 text-center">
                    <i class="fas fa-home text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No properties listed yet</h3>
                    <p class="text-gray-500 mb-4">Start listing your properties to reach potential buyers</p>
                    @if(Auth::user()->hasActiveSubscription())

                    <a href="{{ route('properties.create') }}"
                    class="bg-primary text-white px-6 py-2 rounded-lg inline-block hover:bg-primary/90 transition">
                        Add Your First Property
                    </a>

                    @else

                    <a href="{{ route('agent.subscription') }}"
                    class="bg-red-500 text-white px-6 py-2 rounded-lg inline-block">
                        Subscribe to Start Posting
                    </a>

                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
