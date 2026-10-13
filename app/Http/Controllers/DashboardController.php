<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user && $user->role === 'admin') {
            return $this->adminDashboard();
        } elseif ($user && $user->role === 'agent') {
            return $this->agentDashboard();
        }
        
        return $this->userDashboard();
    }

    private function userDashboard()
    {
        $user = Auth::user();
        $favorites = collect();
        if (is_callable([$user, 'favorites'])) {
            $favorites = call_user_func([$user, 'favorites'])->latest()->take(6)->get();
        }
        $inquiries = Inquiry::where('user_id', $user->id)->latest()->take(5)->get();
        
        return view('dashboards.user', compact('favorites', 'inquiries'));
    }

    private function agentDashboard()
    {
        $user = Auth::user();
        $properties = Property::where('user_id', $user->id)->latest()->get();
        $totalProperties = $properties->count();
        $activeProperties = $properties->where('status', 'active')->count();
        $pendingProperties = $properties->where('status', 'pending')->count();
        $totalViews = $properties->sum('views');
        
        return view('dashboards.agent', compact(
            'properties', 'totalProperties', 'activeProperties', 
            'pendingProperties', 'totalViews'
        ));
    }

    private function adminDashboard()
    {
        $totalUsers = User::count();
        $totalAgents = User::where('role', 'agent')->count();
        $totalProperties = Property::count();
        $pendingProperties = Property::where('status', 'pending')->count();
        $activeProperties = Property::where('status', 'active')->count();
        $recentProperties = Property::latest()->take(10)->get();
        $recentUsers = User::latest()->take(10)->get();
        
        return view('dashboards.admin', compact(
            'totalUsers', 'totalAgents', 'totalProperties', 
            'pendingProperties', 'activeProperties', 'recentProperties', 'recentUsers'
        ));
    }
}