<x-app-layout>
    <div class="space-y-6">
        <!-- Header with Back Button -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('contacts.index') }}"
                    class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    title="Back to Messages">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-bold text-xl sm:text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Message Details') }}
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                        Conversation with {{ $contact->name }}
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                @if (!$contact->is_read)
                    <form action="{{ route('contacts.mark-read', $contact) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Mark as Read
                        </button>
                    </form>
                @endif

                <button type="button" onclick="window.print()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span class="hidden sm:inline">Print</span>
                </button>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-4">
                <x-alert type="success" :message="session('success')" dismissible="true" />
            </div>
        @endif

        <!-- Message Thread Container -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

            <!-- Contact Info Header -->
            <div
                class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-br from-gray-50 to-white dark:from-gray-900/50 dark:to-gray-800">
                <div class="flex items-start gap-4">
                    <!-- Avatar -->
                    <div class="w-14 h-14 rounded-full flex items-center justify-center font-bold text-white text-xl flex-shrink-0"
                        style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    </div>

                    <!-- Contact Details -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 flex-wrap">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $contact->name }}
                            </h3>
                            @if ($contact->is_read)
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Read
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs font-medium">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
                                    Unread
                                </span>
                            @endif
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 mt-2">
                            <a href="mailto:{{ $contact->email }}"
                                class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $contact->email }}
                            </a>
                            <span class="inline-flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $contact->created_at->format('M d, Y \a\t h:i A') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message Thread -->
            <div class="p-6 space-y-6 max-h-[600px] overflow-y-auto bg-gray-50 dark:bg-gray-900/20">

                <!-- Original Message -->
                <div class="flex gap-4">
                    <!-- Avatar -->
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-semibold text-white flex-shrink-0"
                        style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    </div>

                    <!-- Message Bubble -->
                    <div class="flex-1 min-w-0">
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl rounded-tl-none shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                            <!-- Subject Header -->
                            <div class="mb-3 pb-3 border-b border-gray-200 dark:border-gray-700">
                                <h4 class="font-semibold text-gray-900 dark:text-white flex items-start gap-2">
                                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                    {{ $contact->subject }}
                                </h4>
                            </div>

                            <!-- Message Content -->
                            <div class="prose prose-sm dark:prose-invert max-w-none">
                                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">
                                    {{ $contact->message }}</p>
                            </div>

                            <!-- Message Footer -->
                            <div
                                class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $contact->name }}
                                </span>
                                <span>{{ $contact->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Replies -->
                @foreach ($contact->replies as $reply)
                    <div class="flex gap-4 {{ $reply->sender === 'admin' ? 'flex-row-reverse' : '' }}">
                        <!-- Avatar -->
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-semibold text-white flex-shrink-0"
                            style="background: {{ $reply->sender === 'admin' ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'linear-gradient(135deg, #1363C6 0%, #0d4a99 100%)' }};">
                            {{ $reply->sender === 'admin' ? 'A' : strtoupper(substr($contact->name, 0, 1)) }}
                        </div>

                        <!-- Reply Bubble -->
                        <div class="flex-1 min-w-0">
                            <div
                                class="rounded-2xl shadow-sm border p-4 {{ $reply->sender === 'admin' ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800 rounded-tr-none' : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 rounded-tl-none' }}">
                                <!-- Reply Content -->
                                <div class="prose prose-sm dark:prose-invert max-w-none">
                                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">
                                        {{ $reply->message }}</p>
                                </div>

                                <!-- Reply Footer -->
                                <div
                                    class="mt-3 pt-3 border-t flex items-center justify-between text-xs {{ $reply->sender === 'admin' ? 'border-green-200 dark:border-green-800 text-green-700 dark:text-green-400' : 'border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400' }}">
                                    <span class="flex items-center gap-1 font-medium">
                                        @if ($reply->sender === 'admin')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            Admin
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ ucfirst($reply->sender) }}
                                        @endif
                                    </span>
                                    <span>{{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Reply Form -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <form action="{{ route('contacts.reply', $contact) }}" method="POST" class="space-y-4"
                    x-data="{ message: '' }">
                    @csrf

                    <div>
                        <label for="message"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Write a Reply
                        </label>
                        <div class="relative">
                            <textarea id="message" name="message" rows="4" x-model="message" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors resize-none"
                                placeholder="Type your response here..."></textarea>

                            <!-- Character Counter -->
                            <div class="absolute bottom-3 right-3 text-xs text-gray-400 dark:text-gray-500">
                                <span x-text="message.length"></span> characters
                            </div>
                        </div>
                        @error('message')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                        <!-- Tips -->
                        <div class="flex items-start gap-2 text-xs text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Your reply will be sent to {{ $contact->email }}</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('contacts.index') }}"
                                class="px-4 py-2.5 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors text-sm font-medium">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] bg-gradient-to-br from-green-600 to-green-700 hover:from-green-700 hover:to-green-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Send Reply
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Quick Actions
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <a href="mailto:{{ $contact->email }}"
                    class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors group">
                    <div
                        class="p-2 bg-blue-100 dark:bg-blue-900/40 rounded-lg group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Send Email</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Open mail client</p>
                    </div>
                </a>

                <button onclick="window.print()"
                    class="flex items-center gap-3 p-4 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg transition-colors group">
                    <div
                        class="p-2 bg-purple-100 dark:bg-purple-900/40 rounded-lg group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Print Thread</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Save as PDF</p>
                    </div>
                </button>

                <form action="{{ route('contacts.destroy', $contact) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this message?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full flex items-center gap-3 p-4 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors group">
                        <div
                            class="p-2 bg-red-100 dark:bg-red-900/40 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Delete Thread</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Permanently remove</p>
                        </div>
                    </button>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
