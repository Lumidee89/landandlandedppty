@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen pt-16">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
            <p class="text-gray-600">Manage users, properties, and platform analytics</p>
        </div>
        
        <!-- Stats Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Users</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Agents</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalAgents }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-tie text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Properties</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalProperties }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-building text-green-600 text-xl"></i>
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
        </div>
        
        <!-- Recent Properties -->
        <div class="grid lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Recent Properties</h2>
                    <a href="{{ route('properties.search') }}" class="text-primary text-sm">View All →</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($recentProperties as $property)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">{{ Str::limit($property->title, 50) }}</h3>
                                <p class="text-sm text-gray-500">By: {{ $property->user->name }}</p>
                                <div class="flex items-center space-x-4 mt-2">
                                    <span class="text-sm text-gray-600">{{ $property->formatted_price }}</span>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $property->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($property->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('properties.show', $property) }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-check-circle"></i>
                                </a>
                                <a href="{{ route('properties.edit', $property) }}" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-times-circle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Recent Users -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Recent Users</h2>
                    <a href="{{ route('dashboard') }}" class="text-primary text-sm">View All →</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($recentUsers as $user)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-gray-500"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $user->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ ucfirst($user->role) }} • Joined {{ $user->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('dashboard') }}" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-ban"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
            <div class="grid md:grid-cols-4 gap-4">
                <a href="{{ route('register') }}" class="bg-primary text-white px-4 py-3 rounded-lg hover:bg-primary/90 transition flex items-center justify-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>Add Admin</span>
                </a>
                <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition flex items-center justify-center space-x-2">
                    <i class="fas fa-chart-line"></i>
                    <span>View Reports</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="bg-purple-600 text-white px-4 py-3 rounded-lg hover:bg-purple-700 transition flex items-center justify-center space-x-2">
                    <i class="fas fa-cog"></i>
                    <span>Site Settings</span>
                </a>
                <a href="{{ route('properties.search') }}" class="bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition flex items-center justify-center space-x-2">
                    <i class="fas fa-download"></i>
                    <span>Export Data</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
