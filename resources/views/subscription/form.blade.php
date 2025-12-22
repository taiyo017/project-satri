<x-guest-layout>
    <div class="max-w-2xl mx-auto py-12 px-4">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Subscribe to Updates</h1>
            <p class="text-gray-600 mb-8">Stay informed about our latest job postings, courses, and announcements.</p>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('subscription.subscribe') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                    <input type="email" name="email" id="email" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name (Optional)</label>
                    <input type="text" name="name" id="name"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Select Topics *</label>
                    <div class="space-y-3">
                        @foreach($topics as $topic)
                            <label class="flex items-start p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="topics[]" value="{{ $topic->id }}"
                                       class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                       {{ in_array($topic->id, old('topics', [])) ? 'checked' : '' }}>
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">{{ $topic->name }}</div>
                                    @if($topic->description)
                                        <div class="text-sm text-gray-600 mt-1">{{ $topic->description }}</div>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('topics')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                    Subscribe Now
                </button>

                <p class="text-xs text-gray-500 mt-4 text-center">
                    By subscribing, you agree to receive email updates. You can unsubscribe at any time.
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
