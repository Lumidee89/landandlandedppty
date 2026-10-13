<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAgentSubscription
{
    public function handle(Request $request, Closure $next)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user && $user->role === 'agent') {

            // Auto deactivate expired subscription
            if (
                $user->subscription_expires_at &&
                now()->gt($user->subscription_expires_at)
            ) {
                $user->update([
                    'is_subscribed' => false
                ]);
            }

            if (!$user->hasActiveSubscription()) {
                return redirect()
                    ->route('agent.subscription')
                    ->with('error', 'Your subscription has expired. Please subscribe to continue posting properties.');
            }
        }

        return $next($request);
    }
}