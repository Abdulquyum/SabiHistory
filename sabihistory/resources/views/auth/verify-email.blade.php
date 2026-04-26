<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Verify Email Address</h2>
        <p class="text-gray-600 text-sm mt-1">One final step to complete your registration</p>
    </div>

    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-800">
        <i class="fas fa-envelope-open-text mr-2"></i>
        {{ __('Thanks for signing up! We\'ve sent a verification link to your email. Click it to activate your account.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-800 flex items-center gap-2">
            <i class="fas fa-check-circle text-lg"></i>
            <div>
                <p class="font-semibold">{{ __('Verification Link Sent') }}</p>
                <p class="text-xs">{{ __('A new verification link has been sent to your email address.') }}</p>
            </div>
        </div>
    @endif

    <div class="space-y-3 mt-6">
        <form method="POST" action="{{ route('verification.send') }}" class="block">
            @csrf
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-2.5 px-4 rounded-lg transition duration-200 shadow-lg">
                <i class="fas fa-redo mr-2"></i> {{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="block">
            @csrf
            <button type="submit" class="w-full text-gray-700 hover:text-gray-900 font-medium py-2 px-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
            </button>
        </form>
    </div>

    <p class="text-center text-xs text-gray-500 mt-6 border-t border-gray-200 pt-4">
        {{ __('Didn\'t receive the email? Check your spam folder or contact support.') }}
    </p>
</x-guest-layout>
