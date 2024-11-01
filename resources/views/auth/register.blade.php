<x-guest-layout>
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg mt-10 transition-shadow duration-200 hover:shadow-2xl">
        <h2 class="text-3xl font-semibold text-center mb-8 text-gray-800">
            Create an Account
        </h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Username -->
            <div class="mb-5">
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input
                    id="username"
                    class="block mt-1 w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400"
                    type="text"
                    name="username"
                    :value="old('username')"
                    required
                    autofocus
                    autocomplete="username"
                />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mb-5">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input
                    id="email"
                    class="block mt-1 w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autocomplete="username"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-5">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input
                    id="password"
                    class="block mt-1 w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-5">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input
                    id="password_confirmation"
                    class="block mt-1 w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-8">
                <a
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-400 transition-colors duration-200"
                    href="{{ route('login') }}"
                >
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-transform duration-200 transform hover:scale-105">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
