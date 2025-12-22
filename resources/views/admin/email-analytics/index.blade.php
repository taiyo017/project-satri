<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Email Analytics') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 sm:mt-1">
                    Track email performance and engagement metrics
                </p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Overview Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Total Subscribers -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Subscribers</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">
                            {{ number_format($analytics['subscribers']['total']) }}</p>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                            {{ $analytics['subscribers']['active'] }} active
                        </p>
                    </div>
                    <div class="p-2.5 rounded-lg"
                        style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Campaigns -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Campaigns</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">
                            {{ number_format($analytics['campaigns']['total']) }}</p>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                            {{ $analytics['campaigns']['sent'] }} sent
                        </p>
                    </div>
                    <div class="p-2.5 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Overall Open Rate -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Overall Open Rate</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">
                            {{ $analytics['emails']['open_rate'] }}%</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ number_format($analytics['emails']['total_opens']) }} opens
                        </p>
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

            <!-- Overall Click Rate -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Overall Click Rate</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">
                            {{ $analytics['emails']['click_rate'] }}%</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ number_format($analytics['emails']['total_clicks']) }} clicks
                        </p>
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

        </div>

        <!-- Subscriber Status Breakdown -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Subscriber Status Breakdown</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Current subscriber distribution</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                        <div class="text-3xl font-bold text-green-700 dark:text-green-400">
                            {{ $analytics['subscribers']['active'] }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">Active</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                        <div class="text-3xl font-bold text-yellow-700 dark:text-yellow-400">
                            {{ $analytics['subscribers']['pending'] }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">Pending</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="text-3xl font-bold text-gray-700 dark:text-gray-300">
                            {{ $analytics['subscribers']['unsubscribed'] }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">Unsubscribed</div>
                    </div>
                    <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="text-3xl font-bold text-blue-700 dark:text-blue-400">
                            {{ number_format($analytics['emails']['total_sent']) }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">Emails Sent</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Campaigns Performance -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Campaigns Performance</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Latest campaign engagement metrics</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Campaign
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Topic
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Sent
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Open Rate
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Click Rate
                            </th>
                            <th
                                class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($recentCampaigns as $campaign)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">

                                <!-- Campaign -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                                            style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%);">
                                            <svg class="w-5 h-5" style="color: #1363C6;" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <span class="font-semibold text-gray-900 dark:text-white text-sm truncate">
                                                {{ Str::limit($campaign->subject, 40) }}
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $campaign->sent_at ? $campaign->sent_at->diffForHumans() : 'Not sent' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Topic -->
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                                        {{ $campaign->topic->name }}
                                    </span>
                                </td>

                                <!-- Sent Count -->
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ number_format($campaign->sent_count) }}
                                    </span>
                                </td>

                                <!-- Open Rate -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $campaign->open_rate }}%
                                        </span>
                                        <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2 w-20">
                                            <div class="bg-green-600 h-2 rounded-full"
                                                style="width: {{ min($campaign->open_rate, 100) }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Click Rate -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $campaign->click_rate }}%
                                        </span>
                                        <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2 w-20">
                                            <div class="bg-purple-600 h-2 rounded-full"
                                                style="width: {{ min($campaign->click_rate, 100) }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end">
                                        <a href="{{ route('admin.email-analytics.campaign', $campaign) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors text-xs font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                            View Details
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4"
                                            style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%);">
                                            <svg class="w-8 h-8" style="color: #1363C6;" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No campaigns
                                            sent yet</h3>
                                        <p class="text-gray-500 dark:text-gray-400">Analytics will appear here once you
                                            send your first campaign</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
