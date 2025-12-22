<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Campaign Analytics') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Detailed performance metrics for {{ $analytics['campaign']->subject }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.email-campaigns.show', $analytics['campaign']) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-white font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View Campaign
                </a>
                <a href="{{ route('admin.email-analytics.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Campaign Info Card -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Campaign Information</h3>
                    </div>

                    <!-- Status Badge -->
                    @php
                        $statusColors = [
                            'sent' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                            'sending' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                            'scheduled' =>
                                'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
                            'draft' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
                            'failed' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                        ];
                        $colorClass =
                            $statusColors[$analytics['campaign']->status] ??
                            'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                    @endphp
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium {{ $colorClass }}">
                        {{ ucfirst($analytics['campaign']->status) }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Subject</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $analytics['campaign']->subject }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Topic</p>
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            {{ $analytics['campaign']->topic->name }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Created</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $analytics['campaign']->created_at->format('M d, Y H:i') }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $analytics['campaign']->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Sent At</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $analytics['campaign']->sent_at ? $analytics['campaign']->sent_at->format('M d, Y H:i') : 'Not sent yet' }}
                        </p>
                        @if ($analytics['campaign']->sent_at)
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $analytics['campaign']->sent_at->diffForHumans() }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Sent</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                            {{ number_format($analytics['total_sent']) }}</p>
                    </div>
                    <div class="p-2.5 rounded-lg"
                        style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Opened</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">
                            {{ number_format($analytics['total_opened']) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $analytics['unique_opens'] }}
                            unique</p>
                    </div>
                    <div class="p-2.5 bg-green-100 dark:bg-green-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Clicked</p>
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400 mt-1">
                            {{ number_format($analytics['total_clicked']) }}</p>
                    </div>
                    <div class="p-2.5 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Failed</p>
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400 mt-1">
                            {{ number_format($analytics['campaign']->failed_count) }}</p>
                    </div>
                    <div class="p-2.5 bg-red-100 dark:bg-red-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Rates -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Performance Rates</h3>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Open Rate -->
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Open Rate</span>
                            <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $analytics['open_rate'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                            <div class="bg-green-600 dark:bg-green-500 h-3 rounded-full transition-all duration-500"
                                style="width: {{ min($analytics['open_rate'], 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            {{ number_format($analytics['total_opened']) }} of
                            {{ number_format($analytics['total_sent']) }} opened</p>
                    </div>

                    <!-- Click Rate -->
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Click Rate</span>
                            <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $analytics['click_rate'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                            <div class="bg-purple-600 dark:bg-purple-500 h-3 rounded-full transition-all duration-500"
                                style="width: {{ min($analytics['click_rate'], 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            {{ number_format($analytics['total_clicked']) }} of
                            {{ number_format($analytics['total_sent']) }} clicked</p>
                    </div>

                    <!-- Click-Through Rate -->
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Click-Through Rate</span>
                            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $analytics['click_through_rate'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                            <div class="bg-blue-600 dark:bg-blue-500 h-3 rounded-full transition-all duration-500"
                                style="width: {{ min($analytics['click_through_rate'], 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            {{ number_format($analytics['total_clicked']) }} of
                            {{ number_format($analytics['total_opened']) }} who opened</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Engagement Summary -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Engagement Summary</h3>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div
                        class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:shadow-md transition">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ number_format($analytics['total_sent']) }}</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Emails Sent</div>
                    </div>
                    <div
                        class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg hover:shadow-md transition">
                        <div class="text-2xl font-bold text-green-700 dark:text-green-400">
                            {{ number_format($analytics['unique_opens']) }}</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Unique Opens</div>
                    </div>
                    <div
                        class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:shadow-md transition">
                        <div class="text-2xl font-bold text-purple-700 dark:text-purple-400">
                            {{ number_format($analytics['total_clicked']) }}</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Link Clicks</div>
                    </div>
                    <div class="text-center p-4 bg-red-50 dark:bg-red-900/20 rounded-lg hover:shadow-md transition">
                        <div class="text-2xl font-bold text-red-700 dark:text-red-400">
                            {{ number_format($analytics['campaign']->failed_count) }}</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Failed Deliveries</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Performing Links (if available) -->
        @php
            $topClicks = $analytics['campaign']
                ->emailLogs()
                ->with('clicks')
                ->get()
                ->flatMap(fn($log) => $log->clicks)
                ->groupBy('url')
                ->map(fn($clicks) => $clicks->count())
                ->sortDesc()
                ->take(10);
        @endphp

        @if ($topClicks->isNotEmpty())
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                <div
                    class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Top Clicked Links</h3>
                        <span
                            class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                            Top 10
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="space-y-3">
                        @foreach ($topClicks as $url => $count)
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:shadow-md transition group">
                                <div class="flex items-center gap-3 flex-1 min-w-0 mr-4">
                                    <div
                                        class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg group-hover:scale-110 transition">
                                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                        </svg>
                                    </div>
                                    <a href="{{ $url }}" target="_blank"
                                        class="text-blue-600 dark:text-blue-400 hover:underline text-sm truncate flex-1">
                                        {{ $url }}
                                    </a>
                                </div>
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 rounded-lg text-sm font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                    </svg>
                                    {{ $count }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
