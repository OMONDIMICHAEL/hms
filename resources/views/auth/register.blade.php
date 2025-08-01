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
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Hospital Staff Registration</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-2">Create your account to access the system</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Full Name')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                <x-text-input 
                    id="name" 
                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" 
                    type="text" 
                    name="name" 
                    :value="old('name')" 
                    required 
                    autofocus 
                    autocomplete="name"
                    placeholder="Teresa Mendoza"
                />
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm text-red-600 dark:text-red-400" />
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                <x-text-input 
                    id="email" 
                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autocomplete="email"
                    placeholder="teresa.mendoza@gmail.com"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600 dark:text-red-400" />
            </div>

            <!-- Role Selection -->
            <div class="mb-4">
                <x-input-label for="role" :value="__('Role')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                <div class="relative">
                    <select id="role" name="role" required
                        class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm rounded-md">
                        <option value="" disabled selected>Select your role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                        <option value="doctor" {{ old('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                        <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>Patient</option>
                        <option value="nurse" {{ old('role') == 'nurse' ? 'selected' : '' }}>Nurse</option>
                        <option value="receptionist" {{ old('role') == 'receptionist' ? 'selected' : '' }}>Receptionist</option>
                        <option value="lab_technician" {{ old('role') == 'lab_technician' ? 'selected' : '' }}>Lab Technician</option>
                        <option value="pharmacist" {{ old('role') == 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('role')" class="mt-1 text-sm text-red-600 dark:text-red-400" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                <x-text-input 
                    id="password" 
                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                    type="password"
                    name="password"
                    required 
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600 dark:text-red-400" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                <x-text-input 
                    id="password_confirmation" 
                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                    type="password"
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-sm text-red-600 dark:text-red-400" />
            </div>

            <!-- Register Button -->
            <div class="mb-4">
                <x-primary-button class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                    {{ __('Register') }}
                </x-primary-button>
            </div>

            <!-- Login Link -->
            <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                <p>Already have an account? 
                    <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 hover:underline">
                        {{ __('Login here') }}
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>