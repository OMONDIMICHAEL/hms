<x-app-layout>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

     @if(session('error')) 
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
             {{ session('error') }} 
        </div>
     @endif 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Staff') }}
        </h2>
    </x-slot>
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">Edit Staff Member</h1>

        <form method="POST" action="{{ route('staff.update', $staff->id) }}" class="max-w-lg">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $staff->first_name) }} {{( $staff->last_name) }}" class="border w-full p-2" required>
            </div>

            <div class="mb-4">
                <label class="block">Email</label>
                <input type="email" name="email" value="{{ old('email', $staff->email) }}" class="border w-full p-2" required>
            </div>

            <div class="mb-4">
                <label class="block">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $staff->phone) }}" class="border w-full p-2">
            </div>

            <div class="mb-4">
                <label class="block">Department</label>
                <select name="department_id" class="border w-full p-2">
                    @foreach($departments as $d)
                        <option value="{{ $d->id }}" {{ $staff->department_id == $d->id ? 'selected' : '' }}>
                            {{ $d->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block">Job Title</label>
                <input type="text" name="job_title" value="{{ old('job_title', $staff->job_title) }}" class="border w-full p-2">
            </div>

            <div class="mb-4">
                <label class="block">Status</label>
                <select name="status" class="border w-full p-2">
                    <option value="active" {{ $staff->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $staff->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block">Hire Date</label>
                <input type="date" name="hire_date" value="{{ old('hire_date', $staff->hire_date) }}" class="border w-full p-2">
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Update Staff</button>
            <a href="{{ route('staff.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>
</x-app-layout>
