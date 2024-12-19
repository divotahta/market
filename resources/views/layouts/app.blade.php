<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Secondpedia') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @auth
                @if(auth()->user()->role === 'admin')
                    <div class="flex">
                        <!-- Sidebar -->
                        <div class="w-64 bg-white shadow-lg min-h-screen">
                            <!-- Logo -->
                            <div class="px-6 py-4 border-b">
                                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-blue-600">
                                    Secondpedia
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <nav class="mt-6">
                                <div class="px-4 space-y-2">
                                    <a href="{{ route('admin.dashboard') }}" 
                                       class="{{ request()->routeIs('admin.dashboard') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-blue-50' }} 
                                              flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all">
                                        <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                                        Dashboard
                                    </a>

                                    <a href="{{ route('admin.products.create') }}"
                                       class="{{ request()->routeIs('admin.products.create') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-blue-50' }}
                                              flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all">
                                        <i class="fas fa-plus w-5 h-5 mr-3"></i>
                                        Tambah Produk
                                    </a>

                                    <a href="{{ route('admin.report') }}"
                                       class="{{ request()->routeIs('admin.report') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-blue-50' }}
                                              flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all">
                                        <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                                        Laporan
                                    </a>
                                </div>
                            </nav>
                        </div>

                        <!-- Main Content -->
                        <div class="flex-1">
                            <!-- Top Navigation -->
                            <div class="bg-white shadow">
                                <div class="px-6 py-4 flex justify-end">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                <div>{{ Auth::user()->name }}</div>
                                                <div class="ml-1">
                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('profile.edit')">
                                                {{ __('Profile') }}
                                            </x-dropdown-link>

                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <x-dropdown-link :href="route('logout')"
                                                        onclick="event.preventDefault();
                                                                    this.closest('form').submit();">
                                                    {{ __('Log Out') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </div>

                            <!-- Page Content -->
                            <main class="p-6">
                                {{ $slot }}
                            </main>
                        </div>
                    </div>
                @else
                    @include('layouts.navigation-pelanggan')
                    <main>
                        {{ $slot }}
                    </main>
                @endif
            @else
                @include('layouts.navigation')
                <main>
                    {{ $slot }}
                </main>
            @endauth
        </div>

        @stack('scripts')
    </body>
</html>
