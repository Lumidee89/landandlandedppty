@extends('layouts.app')

@section('content')

<div class="container mx-auto py-16">

    <div class="max-w-2xl mx-auto bg-white shadow-xl rounded-2xl p-10">

        <h1 class="text-3xl font-bold mb-6">
            Agent Subscription
        </h1>

        <p class="mb-6 text-gray-600">
            Subscribe monthly to continue posting properties.
        </p>

        <form method="POST" action="{{ route('agent.subscription.subscribe') }}">

            @csrf

            <div class="mb-6">
                <label class="block mb-2 font-semibold">
                    Number of Months
                </label>

                <select
                    name="months"
                    class="w-full border rounded-lg p-3"
                >
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">
                            {{ $i }} Month(s)
                        </option>
                    @endfor
                </select>
            </div>

            <button
                class="bg-primary text-white px-6 py-3 rounded-lg"
            >
                Subscribe Now
            </button>

        </form>

    </div>

</div>

@endsection