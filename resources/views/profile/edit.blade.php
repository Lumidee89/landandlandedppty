@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 pt-20 pb-10">
    <div class="container mx-auto max-w-5xl px-4">
        @if(session('success'))
            <div class="mb-6 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-red-700">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-8 rounded-2xl bg-gradient-to-r from-primary to-primary/80 p-8 text-white">
            <h1 class="text-3xl font-bold">Your Profile</h1>
            <p class="mt-2 text-white/90">Update your details, profile picture, and account information.</p>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            <div class="rounded-2xl bg-white p-6 shadow-md">
                <div class="text-center">
                    <img id="profileAvatarPreview" src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                         class="mx-auto h-36 w-36 rounded-full border-4 border-primary/10 object-cover">
                    <h2 class="mt-4 text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-sm font-semibold capitalize text-primary">{{ $user->role }}</p>
                    <p class="mt-3 text-sm text-gray-500">{{ $user->email }}</p>
                    @if($user->phone)
                        <p class="mt-1 text-sm text-gray-500">{{ $user->phone }}</p>
                    @endif
                </div>

                <div class="mt-6 space-y-3 rounded-xl bg-gray-50 p-4 text-sm text-gray-600">
                    <div class="flex items-center justify-between">
                        <span>Company</span>
                        <span class="font-medium text-gray-800">{{ $user->company_name ?: 'Not set' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>License</span>
                        <span class="font-medium text-gray-800">{{ $user->license_number ?: 'Not set' }}</span>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-md lg:col-span-2">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Basic Information</h3>
                        <p class="text-sm text-gray-500">Keep your contact and personal details up to date.</p>
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Profile Picture</label>
                            <input type="file" name="avatar" id="profileAvatar" accept="image/png,image/jpeg,image/jpg"
                                   class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-primary file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-primary/90">
                        </div>
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Company Name</label>
                            <input type="text" name="company_name" value="{{ old('company_name', $user->company_name) }}"
                                   class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">License Number</label>
                            <input type="text" name="license_number" value="{{ old('license_number', $user->license_number) }}"
                                   class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">Bio</label>
                        <textarea name="bio" rows="5"
                                  class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                                  placeholder="Tell people a little more about yourself">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-bold text-gray-800">Change Password</h3>
                        <p class="text-sm text-gray-500">Leave these blank if you do not want to change your password.</p>
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">New Password</label>
                            <div class="relative">
                                <input type="password" name="password"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-3 pr-12 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                                <button type="button"
                                        class="password-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary focus:outline-none"
                                        aria-label="Show password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-3 pr-12 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                                <button type="button"
                                        class="password-toggle absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary focus:outline-none"
                                        aria-label="Show password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 pt-2 sm:flex-row">
                        <button type="submit" class="rounded-lg bg-primary px-6 py-3 font-semibold text-white transition hover:bg-primary/90">
                            Save Profile
                        </button>
                        <a href="{{ route('dashboard') }}" class="rounded-lg border border-gray-300 px-6 py-3 text-center font-semibold text-gray-700 transition hover:bg-gray-50">
                            Back to Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
