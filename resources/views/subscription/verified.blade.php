<x-guest-layout>
    <div class="max-w-2xl mx-auto py-12 px-4">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="mb-6">
                <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">Email Verified!</h1>
            <p class="text-gray-600 mb-8">
                Thank you for verifying your email address. You're now subscribed and will receive updates based on your preferences.
            </p>

            <div class="bg-blue-50 rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-gray-900 mb-3">Your Subscriptions:</h3>
                <ul class="text-left space-y-2">
                    @foreach($subscriber->topics as $topic)
                        <li class="flex items-center text-gray-700">
                            <svg class="h-5 w-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $topic->name }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <a href="{{ route('frontend.home') }}" class="inline-block bg-blue-600 text-white py-3 px-8 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                Return to Home
            </a>

            <p class="text-sm text-gray-500 mt-6">
                Want to change your preferences? 
                <a href="{{ route('subscription.preferences', $subscriber->unsubscribe_token) }}" class="text-blue-600 hover:underline">
                    Manage your subscription
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
