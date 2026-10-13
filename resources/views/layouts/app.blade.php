<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Land & Landed Properties - Find Your Dream Property</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#00A86B',
                        secondary: '#FF6B35',
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .property-card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md fixed w-full z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="{{ route('landing') }}" class="flex items-center space-x-2">
                    <i class="fas fa-home text-primary text-2xl"></i>
                    <span class="text-2xl font-bold text-gray-800">Land & Landed<span class="text-primary"> Properties</span></span>
                </a>
                
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('landing') }}" class="text-gray-700 hover:text-primary transition">Home</a>
                    <a href="{{ route('properties.search', ['purpose' => 'sale']) }}" class="text-gray-700 hover:text-primary transition">Buy</a>
                    <a href="{{ route('properties.search', ['purpose' => 'rent']) }}" class="text-gray-700 hover:text-primary transition">Rent</a>
                    <a href="{{ route('properties.search', ['purpose' => 'lease']) }}" class="text-gray-700 hover:text-primary transition">Lease</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-primary transition">Agents</a>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="relative" data-dropdown>
                            <button type="button"
                                    class="flex items-center space-x-2 text-gray-700 hover:text-primary transition"
                                    data-dropdown-toggle
                                    aria-expanded="false"
                                    aria-haspopup="true">
                                <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}"
                                     class="w-8 h-8 rounded-full object-cover border border-primary/20">
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden" data-dropdown-menu>
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                    <i class="fas fa-user-circle mr-2"></i> Profile
                                </a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                    <i class="fas fa-cog mr-2"></i> Settings
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 transition">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-200 transition">
                            Log In
                        </a>
                        <a href="{{ route('register') }}" class="bg-primary text-white px-5 py-2 rounded-lg hover:bg-primary/90 transition">
                            Create an account
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Mobile menu JavaScript -->
    <script>
        // For mobile menu toggle if needed
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            if (menu) menu.classList.toggle('hidden');
        });

        document.querySelectorAll('.password-toggle').forEach(function(button) {
            button.addEventListener('click', function() {
                const input = button.parentElement.querySelector('input');
                const icon = button.querySelector('i');
                const isPassword = input.type === 'password';

                input.type = isPassword ? 'text' : 'password';
                button.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
                icon.classList.toggle('fa-eye', !isPassword);
                icon.classList.toggle('fa-eye-slash', isPassword);
            });
        });

        const registerAvatarInput = document.getElementById('registerAvatar');
        if (registerAvatarInput) {
            registerAvatarInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('registerAvatarPreview');
                const icon = document.getElementById('registerAvatarIcon');

                if (!file || !preview || !icon) return;

                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                icon.classList.add('hidden');
            });
        }

        const profileAvatarInput = document.getElementById('profileAvatar');
        if (profileAvatarInput) {
            profileAvatarInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('profileAvatarPreview');

                if (!file || !preview) return;

                preview.src = URL.createObjectURL(file);
            });
        }

        document.querySelectorAll('[data-dropdown]').forEach(function(dropdown) {
            const toggle = dropdown.querySelector('[data-dropdown-toggle]');
            const menu = dropdown.querySelector('[data-dropdown-menu]');

            if (!toggle || !menu) return;

            function closeDropdown() {
                menu.classList.add('hidden');
                toggle.setAttribute('aria-expanded', 'false');
            }

            function openDropdown() {
                menu.classList.remove('hidden');
                toggle.setAttribute('aria-expanded', 'true');
            }

            toggle.addEventListener('click', function(event) {
                event.stopPropagation();

                const isOpen = !menu.classList.contains('hidden');
                document.querySelectorAll('[data-dropdown-menu]').forEach(function(otherMenu) {
                    if (otherMenu !== menu) {
                        otherMenu.classList.add('hidden');
                    }
                });
                document.querySelectorAll('[data-dropdown-toggle]').forEach(function(otherToggle) {
                    if (otherToggle !== toggle) {
                        otherToggle.setAttribute('aria-expanded', 'false');
                    }
                });

                if (isOpen) {
                    closeDropdown();
                } else {
                    openDropdown();
                }
            });

            document.addEventListener('click', function(event) {
                if (!dropdown.contains(event.target)) {
                    closeDropdown();
                }
            });

            dropdown.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeDropdown();
                    toggle.focus();
                }
            });
        });
    </script>
</body>
</html>
