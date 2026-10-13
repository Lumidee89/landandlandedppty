<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;

class PageController extends Controller
{
    public function landing()
    {
        $featuredProperties = Property::where('is_featured', true)
            ->where('status', 'active')
            ->latest()
            ->take(6)
            ->get();
            
        $recentProperties = Property::where('status', 'active')
            ->latest()
            ->take(8)
            ->get();

        // Stats for the landing page
        $totalProperties = Property::where('status', 'active')->count();
        $totalAgents = User::where('role', 'agent')->count();
        $happyCustomers = User::where('role', 'user')->count();
        $totalCities = Property::where('status', 'active')->distinct('city')->count('city');

        return view('landing', compact(
            'featuredProperties', 
            'recentProperties',
            'totalProperties',
            'totalAgents',
            'happyCustomers',
            'totalCities'
        ));
    }
}