@props(['background' => 'bg-gray-900'])

<section class="{{ $background }} py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <!-- Left Side - Info -->
            <div class="text-white">
                <h2 class="text-3xl font-bold mb-4">Never Miss an Update</h2>
                <p class="text-gray-300 mb-6">
                    Subscribe to our newsletter and be the first to know about new job openings, 
                    course launches, and important announcements.
                </p>
                <div class="flex flex-wrap gap-4">
                    @php
                        $topics = \App\Models\SubscriptionTopic::active()->get();
                    @endphp
                    @foreach($topics as $topic)
                        <div class="flex items-center text-sm">
                            <svg class="h-5 w-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-300">{{ $topic->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Side - Compact Form -->
            <div>
                <x-subscription-widget 
                    title="Subscribe Now" 
                    description="Get updates delivered to your inbox"
                    :compact="true" 
                    class="bg-gradient-to-br from-blue-500 to-blue-700" />
            </div>
        </div>
    </div>
</section>
