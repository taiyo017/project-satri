<x-guest-layout>
    <div class="max-w-2xl mx-auto py-12 px-4">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="mb-6">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">You've Been Unsubscribed</h1>
            <p class="text-gray-600 mb-8">
                We're sorry to see you go. You've been successfully unsubscribed from all email updates.
            </p>

            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <p class="text-gray-700">
                    You will no longer receive emails from us. If you change your mind, you can always subscribe again.
                </p>
            </div>

            <div class="space-x-4">
                <a href="{{ route('subscription.form') }}" class="inline-block bg-blue-600 text-white py-3 px-8 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                    Subscribe Again
                </a>
                <a href="{{ route('frontend.home') }}" class="inline-block bg-gray-200 text-gray-700 py-3 px-8 rounded-lg font-semibold hover:bg-gray-300 transition duration-200">
                    Return to Home
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
