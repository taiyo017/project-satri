@props(['placeholder' => 'Enter your email', 'buttonText' => 'Subscribe'])

<form action="{{ route('subscription.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-2">
    @csrf
    
    <input type="email" 
           name="email" 
           placeholder="{{ $placeholder }}" 
           required
           class="flex-1 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    
    @php
        $firstTopic = \App\Models\SubscriptionTopic::active()->first();
    @endphp
    <input type="hidden" name="topics[]" value="{{ $firstTopic?->id ?? 1 }}">
    
    <button type="submit" 
            class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors whitespace-nowrap">
        {{ $buttonText }}
    </button>
</form>

@error('email')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
