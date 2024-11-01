<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col pt-6 sm:pt-0 ">
        <div class="container mx-auto flex flex-col space-y-10">
            <nav class="flex justify-between items-center py-4 px-6 bg-white shadow-md"> <!-- Added background color and shadow -->
                <div>
                    <a href="/" class="group font-bold text-lg md:text-xl flex items-center space-x-4 hover:text-emerald-600 transition duration-300 ease-in-out">
                        <x-application-logo class="w-10 h-10 fill-current text-gray-500 group-hover:text-emerald-500 transition duration-300 ease-in-out" />
                        <span class="text-gray-800">Mini-Instagram</span>
                    </a>



                </div>

                @guest
                <div class="flex items-center space-x-6"> <!-- Increased spacing between links -->
                    <a class="font-bold text-gray-700 hover:text-emerald-600 transition duration-300 ease-in-out" href="{{ route('login') }}">Login</a>
                    <a class="font-bold text-gray-700 hover:text-emerald-600 transition duration-300 ease-in-out" href="{{ route('register') }}">Register</a>
                </div>
                @endguest

                @auth
                <div class="flex items-center space-x-6"> <!-- Added a container for auth links -->
                    <a class="font-bold text-gray-700 hover:text-emerald-600 transition duration-300 ease-in-out text-sm md:text-base" href="{{ route('profile.edit') }}">Profile</a>
<a class="font-bold text-gray-700 hover:text-emerald-600 transition duration-300 ease-in-out text-sm md:text-base" href="{{ route('posts.create') }}">Create a post</a>



                    <x-dropdown>
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-emerald-600 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-emerald-600 transition duration-300 ease-in-out" href="{{ route('profile.edit') }}">Profile</a> --}}
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-emerald-600 transition duration-300 ease-in-out">
                                    Logout
                                </button>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                @endauth
            </nav>



            <main>
                {{ $slot }}
            </main>

        </div>

    </div>
    <x-footer-card />
</body>

</html>
