@props(['title' => 'Stay Updated', 'description' => 'Subscribe to our newsletter and get the latest updates delivered to your inbox.', 'compact' => false])

<div {{ $attributes->merge(['class' => 'bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg shadow-xl overflow-hidden']) }}>
    <div class="p-6 md:p-8">
        @if(!$compact)
            <div class="text-center mb-6">
                <svg class="mx-auto h-12 w-12 text-white/90 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <h3 class="text-2xl font-bold text-white mb-2">{{ $title }}</h3>
                <p class="text-blue-100">{{ $description }}</p>
            </div>
        @else
            <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
            <p class="text-blue-100 text-sm mb-4">{{ $description }}</p>
        @endif

        <form action="{{ route('subscription.subscribe') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <input type="email" 
                       name="email" 
                       placeholder="Enter your email address" 
                       required
                       class="w-full px-4 py-3 rounded-lg border-2 border-transparent focus:border-white focus:ring-2 focus:ring-white/50 transition-all">
                @error('email')
                    <p class="text-red-200 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            @if(!$compact)
                <div>
                    <input type="text" 
                           name="name" 
                           placeholder="Your name (optional)" 
                           class="w-full px-4 py-3 rounded-lg border-2 border-transparent focus:border-white focus:ring-2 focus:ring-white/50 transition-all">
                </div>

                @php
                    $topics = \App\Models\SubscriptionTopic::active()->get();
                @endphp

                @if($topics->isNotEmpty())
                    <div class="space-y-2">
                        <label class="text-white font-medium text-sm">Select topics you're interested in:</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($topics as $topic)
                                <label class="flex items-center p-3 bg-white/10 hover:bg-white/20 rounded-lg cursor-pointer transition-all">
                                    <input type="checkbox" 
                                           name="topics[]" 
                                           value="{{ $topic->id }}" 
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                           {{ $loop->first ? 'checked' : '' }}>
                                    <span class="ml-2 text-white text-sm">{{ $topic->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('topics')
                            <p class="text-red-200 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @else
                    <input type="hidden" name="topics[]" value="1">
                @endif
            @else
                @php
                    $firstTopic = \App\Models\SubscriptionTopic::active()->first();
                @endphp
                <input type="hidden" name="topics[]" value="{{ $firstTopic?->id ?? 1 }}">
            @endif

            <button type="submit" 
                    class="w-full bg-white text-blue-600 font-semibold py-3 px-6 rounded-lg hover:bg-blue-50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                Subscribe Now
            </button>

            <p class="text-xs text-blue-100 text-center">
                By subscribing, you agree to receive email updates. You can unsubscribe at any time.
            </p>
        </form>
    </div>
</div>
