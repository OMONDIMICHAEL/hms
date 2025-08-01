<x-guest-layout>
    <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden p-8">
        <!-- Hospital Logo/Header -->
        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7v10m5-5H7"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Hospital Portal</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-2">Secure access to medical records</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-md" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-6">
                <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                <x-text-input 
                    id="email" 
                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username" 
                    placeholder="teresa.mendoza@gmail.com"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
            </div>

            <!-- Password -->
            <div class="mb-6">
                <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                <x-text-input 
                    id="password" 
                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mb-6">
                <label for="remember_me" class="inline-flex items-center">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:ring-blue-500 dark:bg-gray-700 dark:focus:ring-blue-600" 
                        name="remember"
                    >
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-300">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a 
                        class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 hover:underline" 
                        href="{{ route('password.request') }}"
                    >
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <div>
                <x-primary-button class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Footer Links -->
        <div class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
            <p>Need an account? 
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 hover:underline">
                        {{ __('Register here') }}
                    </a>
                @endif
            </p>
        </div>
    </div>
</x-guest-layout>