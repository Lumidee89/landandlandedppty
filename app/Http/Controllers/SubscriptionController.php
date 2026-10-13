<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('subscriptions.index');
    }

    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'months' => 'required|integer|min:1|max:12',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $months = (int) $validated['months'];

        $monthlyPrice = 100000;

        $amount = $monthlyPrice * $months;

        // Create pending subscription
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'months' => $months,
            'amount' => $amount,
            'starts_at' => now(),
            'expires_at' => now()->addMonths($months),
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_gateway' => 'paystack',
        ]);

        // Initialize Paystack payment
        $response = Http::withToken(
            config('services.paystack.secret_key')
        )->post(
            config('services.paystack.payment_url') . '/transaction/initialize',
            [
                'email' => $user->email,

                // Paystack expects amount in kobo
                'amount' => $amount * 100,

                'callback_url' => route('payment.callback'),

                'metadata' => [
                    'subscription_id' => $subscription->id,
                    'months' => $months,
                    'user_id' => $user->id,
                ],
            ]
        );

        $data = $response->json();

        if (!$data['status']) {

            return back()->with(
                'error',
                'Unable to initialize payment.'
            );
        }

        return redirect($data['data']['authorization_url']);
    }

    public function callback(Request $request)
    {
        $reference = $request->reference;

        if (!$reference) {

            return redirect()
                ->route('agent.subscription')
                ->with('error', 'Payment reference missing.');
        }

        // Verify payment with Paystack
        $response = Http::withToken(
            config('services.paystack.secret_key')
        )->get(
            config('services.paystack.payment_url') .
            '/transaction/verify/' .
            $reference
        );

        $data = $response->json();

        if (
            !$data['status'] ||
            $data['data']['status'] !== 'success'
        ) {

            return redirect()
                ->route('agent.subscription')
                ->with('error', 'Payment verification failed.');
        }

        $metadata = $data['data']['metadata'];

        $subscription =
            Subscription::findOrFail(
                $metadata['subscription_id']
            );

        /** @var \App\Models\User $user */
        $user = $subscription->user;

        $months = $subscription->months;

        // Extend current subscription if active
        $startDate = $user->hasActiveSubscription()
            ? $user->subscription_expires_at
            : now();

        $expiryDate =
            $startDate->copy()->addMonths($months);

        // Activate user subscription
        $user->update([
            'is_subscribed' => true,
            'subscription_expires_at' => $expiryDate,
        ]);

        // Update subscription
        $subscription->update([
            'starts_at' => now(),
            'expires_at' => $expiryDate,
            'status' => 'active',
            'payment_status' => 'paid',
            'payment_reference' => $reference,
        ]);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Subscription activated successfully!'
            );
    }
}