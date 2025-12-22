<x-guest-layout>
    <div class="max-w-2xl mx-auto py-12 px-4">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="mb-6">
                <svg class="mx-auto h-16 w-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">Check Your Email</h1>
            <p class="text-gray-600 mb-8">
                We've sent a verification email to your inbox. Please click the verification link to confirm your subscription.
            </p>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-gray-900 mb-2">Didn't receive the email?</h3>
                <ul class="text-left text-sm text-gray-600 space-y-2">
                    <li>• Check your spam or junk folder</li>
                    <li>• Make sure you entered the correct email address</li>
                    <li>• Wait a few minutes and check again</li>
                </ul>
            </div>

            <a href="{{ route('frontend.home') }}" class="inline-block bg-blue-600 text-white py-3 px-8 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                Return to Home
            </a>
        </div>
    </div>
</x-guest-layout>
