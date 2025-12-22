<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Topic Analytics') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Performance metrics for {{ $analytics['topic']->name }}
                </p>
            </div>

            <a href="{{ route('admin.email-analytics.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Topic Info Card -->
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
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Topic Information</h3>
                    </div>

                    <!-- Status Badge -->
                    @if ($analytics['topic']->is_active)
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Active
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            Inactive
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Topic Name</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $analytics['topic']->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Slug</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $analytics['topic']->slug }}
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Description</p>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            {{ $analytics['topic']->description ?? 'No description provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Subscribers</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                            {{ number_format($analytics['total_subscribers']) }}</p>
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

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Active Subscribers</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">
                            {{ number_format($analytics['active_subscribers']) }}</p>
                    </div>
                    <div class="p-2.5 bg-green-100 dark:bg-green-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Campaigns</p>
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400 mt-1">
                            {{ number_format($analytics['total_campaigns']) }}</p>
                    </div>
                    <div class="p-2.5 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
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
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Avg Open Rate</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">
                            {{ $analytics['avg_open_rate'] }}%</p>
                    </div>
                    <div class="p-2.5 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
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
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Performance Metrics</h3>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div
                        class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:shadow-md transition">
                        <div class="text-2xl font-bold text-blue-700 dark:text-blue-400">
                            {{ $analytics['avg_open_rate'] }}%</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Average Open Rate</div>
                    </div>
                    <div
                        class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg hover:shadow-md transition">
                        <div class="text-2xl font-bold text-green-700 dark:text-green-400">
                            {{ $analytics['avg_click_rate'] }}%</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Average Click Rate</div>
                    </div>
                    <div
                        class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:shadow-md transition">
                        <div class="text-2xl font-bold text-purple-700 dark:text-purple-400">
                            {{ number_format($analytics['total_campaigns']) }}</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Campaigns Sent</div>
                    </div>
                    <div
                        class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg hover:shadow-md transition">
                        <div class="text-2xl font-bold text-yellow-700 dark:text-yellow-400">
                            {{ $analytics['active_subscribers'] > 0 ? round(($analytics['active_subscribers'] / max($analytics['total_subscribers'], 1)) * 100, 1) : 0 }}%
                        </div>
                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Active Rate</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Campaigns for This Topic -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Recent Campaigns</h3>
                    <span
                        class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                        Last 10
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Subject</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Status</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Sent</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Open Rate</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Click Rate</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($analytics['topic']->campaigns()->latest()->limit(10)->get() as $campaign)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.email-campaigns.show', $campaign) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                        {{ $campaign->subject }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'sent' =>
                                                'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                                            'sending' =>
                                                'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                            'scheduled' =>
                                                'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
                                            'draft' =>
                                                'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
                                            'failed' =>
                                                'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                                        ];
                                        $colorClass =
                                            $statusColors[$campaign->status] ??
                                            'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $colorClass }}">
                                        {{ ucfirst($campaign->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ number_format($campaign->sent_count) }}</td>
                                <td class="px-6 py-4">
                                    @if ($campaign->status === 'sent')
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-semibold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            {{ $campaign->open_rate }}%
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($campaign->status === 'sent')
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-semibold bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                            </svg>
                                            {{ $campaign->click_rate }}%
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    {{ $campaign->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3"
                                            style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%);">
                                            <svg class="w-6 h-6" style="color: #1363C6;" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 dark:text-gray-400 font-medium">No campaigns sent yet
                                        </p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Create your first
                                            campaign to see analytics</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Quick Actions</h3>
                </div>
            </div>

            <div class="p-6">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.email-campaigns.create') }}?topic={{ $analytics['topic']->id }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-white font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                        style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        Create Campaign
                    </a>
                    <a href="{{ route('admin.subscribers.index') }}?topic={{ $analytics['topic']->id }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        View Subscribers
                    </a>
                    <a href="{{ route('admin.subscription-topics.edit', $analytics['topic']) }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 text-white font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Topic
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
