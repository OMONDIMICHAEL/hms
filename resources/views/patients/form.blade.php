@php
    $patient = $patient ?? null;
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="mb-5">
            <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-1">
                First Name
                <span class="text-red-500">*</span>
            </label>
            <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" id="first_name" name="first_name" class="form-control block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 sm:text-sm" placeholder="Teresa"  value="{{ old('first_name', $patient->first_name ?? '') }}" required >
            </div>
            <p class="mt-1 text-xs text-gray-500">Enter patient's first name.</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-5">
            <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-1">
                Last Name
                <span class="text-red-500">*</span>
            </label>
            <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" id="last_name" name="last_name" class="form-control block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 sm:text-sm" placeholder="Teresita"  value="{{ old('last_name', $patient->last_name ?? '') }}" required >
            </div>
            <p class="mt-1 text-xs text-gray-500">Enter patient's last name.</p>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-4">
        <div class="mb-4">
            <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">
                Gender <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <select id="gender" name="gender" required class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md appearance-none bg-white">
                    <option value="">-- Select Gender --</option>
                    <option value="Male" {{ old('gender', $patient->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $patient->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-4">
            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">
                Date of Birth <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth ?? '') }}" required class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm appearance-none bg-white"
                    max="{{ now()->format('Y-m-d') }}">
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-700">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="mb-4 md:w-1/2 md:pr-2">
        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
            Phone Number
        </label>
        <div class="relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 left-0 flex items-center">
                <select name="phone_code" class="h-full py-0 pl-3 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-l-md">
                    <option>+254</option>
                    <!-- Add more country codes as needed -->
                </select>
            </div>
            <input type="tel" id="phone" name="phone" value="{{ old('phone', $patient->phone ?? '') }}" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="123-456-7890" class="block w-full pl-16 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>
        <p class="mt-1 text-xs text-gray-500">Format: 123-456-7890</p>
    </div>
    <div class="col-md-6">
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                Email Address
            </label>
            <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                </div>
                <input type="email" id="email" name="email" 
                    value="{{ old('email', $patient->email ?? '') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="patient@example.com"
                    autocomplete="email">
            </div>
            <p class="mt-1 text-xs text-gray-500">We'll never share your email with anyone else.</p>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
            
            <!-- Street Address -->
            <div class="mb-2">
                <input type="text" name="address" value="{{ old('address', $patient->address ?? '') }}"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-t-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Street address"
                    autocomplete="address"
                >
            </div>
            
            <!-- Address Line 2 -->
            <div class="mb-2">
                <input type="text" name="address_line2" value=""
                    class="block w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Apartment, suite, etc. (optional)"
                    autocomplete="address-line2">
            </div>
            
            <!-- City, State, ZIP -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <div>
                    <input type="text" name="city" value=""
                        class="block w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        placeholder="City"
                        autocomplete="address-level2"
                    >
                </div>
                <div>
                    <input type="text" name="state" value=""
                        class="block w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        placeholder="State/Province"
                        autocomplete="address-level1"
                    >
                </div>
                <div>
                    <input type="text" name="postal_code" value="" class="block w-full px-3 py-2 border border-gray-300 rounded-b-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="ZIP/Postal code"
                        autocomplete="postal-code">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="mb-4">
            <div class="flex justify-between items-center mb-1">
                <label for="medical_history" class="block text-sm font-medium text-gray-700">
                    Medical History
                </label>
                <span id="medical_history_counter" class="text-xs text-gray-500">0/2000</span>
            </div>
            <div class="relative rounded-md shadow-sm">
                <textarea id="medical_history"  name="medical_history" rows="6" maxlength="2000"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter detailed medical history..."
                    oninput="document.getElementById('medical_history_counter').textContent = this.value.length + '/2000'"
                >{{ old('medical_history', $patient->medical_history ?? '') }}</textarea>
            </div>
            <div class="flex justify-between mt-1">
                <p class="text-xs text-gray-500">Include conditions, allergies, medications, and family history</p>
                <button type="button" class="text-xs text-blue-600 hover:text-blue-800" onclick="document.getElementById('medical_history').value = ''">Clear</button>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="mb-4 md:w-1/2">
            <label for="insurance_provider" class="block text-sm font-medium text-gray-700 mb-1">
                Insurance Provider
            </label>
            <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H3zm6.5-6a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" id="insurance_provider" 
                    name="insurance_provider" value="{{ old('insurance_provider', $patient->insurance_provider ?? '') }}"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Search insurance providers..."
                    list="insuranceProviders"
                    autocomplete="off"
                >
                <datalist id="insuranceProviders">
                    <option value="Aetna">
                    <option value="Blue Cross Blue Shield">
                    <option value="Cigna">
                    <option value="UnitedHealthcare">
                    <option value="Humana">
                    <option value="Kaiser Permanente">
                    <option value="Medicare">
                    <option value="Medicaid">
                    <option value="Tricare">
                </datalist>
            </div>
            <p class="mt-1 text-xs text-gray-500">Start typing to see suggestions</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-4">
            <label for="insurance_number" class="block text-sm font-medium text-gray-700 mb-1">
                Insurance Policy Number
                <span class="text-red-500">*</span>
            </label>
            <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm12 2H4v8h12V6zm-5 3a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" id="insurance_number"  name="insurance_number" value="{{ old('insurance_number', $patient->insurance_number ?? '') }}"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="XX-123456789"
                    pattern="[A-Za-z]{2}-?\d{6,12}" 
                    title="Format: Two letters followed by 6-12 numbers (e.g., AB12345678)" required maxlength="15" oninput="this.value = this.value.toUpperCase()">
            </div>
            <div class="flex items-center mt-1">
                <svg class="h-4 w-4 text-gray-500 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <p class="text-xs text-gray-500">Format: Two letters followed by 6-12 numbers</p>
            </div>
        </div>
    </div>
</div>

