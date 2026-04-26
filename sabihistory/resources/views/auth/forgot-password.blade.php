<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Reset Password</h2>
        <p class="text-gray-600 text-sm mt-1">Forgot your password? We'll help you reset it.</p>
    </div>

    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-800">
        <i class="fas fa-info-circle mr-2"></i>
        {{ __('Enter your email address and we\'ll send you a link to reset your password.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="font-semibold text-gray-700" />
            <x-text-input id="email" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" type="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm" />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full mt-6 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-2.5 px-4 rounded-lg transition duration-200 shadow-lg">
            {{ __('Send Reset Link') }}
        </button>

        <!-- Back to Login -->
        <p class="text-center text-sm text-gray-600 mt-4">
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">{{ __('Back to login') }}</a>
        </p>
    </form>
</x-guest-layout>
