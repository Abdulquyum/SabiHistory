@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Create Admin User</h1>
        <p class="text-gray-600 mt-1">Add a new administrator to the system</p>
    </div>

    <!-- Form Container -->
    <div class="max-w-2xl">
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Admin Registration
                </h2>
            </div>

            <form method="POST" action="{{ route('admin.users.store-admin') }}" class="p-6 space-y-6">
                @csrf
                
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-1"></i> Full Name *
                    </label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-1"></i> Email Address *
                    </label>
                    <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-1"></i> Password *
                    </label>
                    <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" id="password" name="password" placeholder="Minimum 8 characters" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">
                        <i class="fas fa-info-circle mr-1"></i> Must be at least 8 characters long
                    </p>
                </div>
                
                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock-open mr-1"></i> Confirm Password *
                    </label>
                    <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="password_confirmation" name="password_confirmation" placeholder="Re-enter password" required>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-800 flex items-start">
                        <i class="fas fa-lightbulb mr-2 mt-0.5 flex-shrink-0"></i>
                        <span>This user will have full admin privileges. Ensure you're creating this for a trusted individual.</span>
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-2 pt-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition flex items-center justify-center gap-2">
                        <i class="fas fa-check"></i> Create Admin
                    </button>
                    <a href="{{ route('admin.users') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg font-medium transition flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Requirements Card -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
        <h3 class="font-bold text-yellow-900 flex items-center mb-3">
            <i class="fas fa-exclamation-triangle mr-2"></i> Requirements
        </h3>
        <ul class="text-sm text-yellow-800 space-y-2">
            <li><i class="fas fa-check text-green-600 mr-2"></i> Email must be unique and valid</li>
            <li><i class="fas fa-check text-green-600 mr-2"></i> Password must be at least 8 characters</li>
            <li><i class="fas fa-check text-green-600 mr-2"></i> Password confirmation must match</li>
            <li><i class="fas fa-check text-green-600 mr-2"></i> Admin will have full system access</li>
        </ul>
    </div>
</div>
@endsection
