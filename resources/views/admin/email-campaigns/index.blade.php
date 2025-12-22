<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Email Campaigns') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 sm:mt-1">
                    Create and manage email marketing campaigns
                </p>
            </div>

            <!-- Create Button -->
            <a href="{{ route('admin.email-campaigns.create') }}"
                class="inline-flex items-center gap-1.5 sm:gap-2 px-4 sm:px-5 py-2 sm:py-2.5 text-white text-xs sm:text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] whitespace-nowrap"
                style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="hidden sm:inline">{{ __('Create Campaign') }}</span>
                <span class="sm:hidden">{{ __('Create') }}</span>
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Flash Messages -->
        @foreach (['success', 'error'] as $msg)
            @if (session($msg))
                <div class="mb-4">
                    <x-alert type="{{ $msg }}" :message="session($msg)" dismissible="true" />
                </div>
            @endif
        @endforeach

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Total Campaigns -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Campaigns</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ $campaigns->total() }}</p>
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

            <!-- Sent -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Sent</p>
                        <p class="text-xl font-bold text-green-600 dark:text-green-400 mt-1">
                            {{ $campaigns->where('status', 'sent')->count() }}
                        </p>
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

            <!-- Draft -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Draft</p>
                        <p class="text-xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">
                            {{ $campaigns->where('status', 'draft')->count() }}
                        </p>
                    </div>
                    <div class="p-2.5 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Scheduled -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Scheduled</p>
                        <p class="text-xl font-bold text-blue-600 dark:text-blue-400 mt-1">
                            {{ $campaigns->where('status', 'scheduled')->count() }}
                        </p>
                    </div>
                    <div class="p-2.5 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        <!-- Campaigns Table -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

            <!-- Table Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Campaigns</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Showing {{ $campaigns->count() }} of {{ $campaigns->total() }} campaigns
                        </p>
                    </div>
                </div>
            </div>

            <!-- Table -->
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
                                Status
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Recipients
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Performance
                            </th>
                            <th
                                class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($campaigns as $campaign)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">

                                <!-- Campaign Info -->
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
                                                {{ Str::limit($campaign->subject, 50) }}
                                            </span>
                                            @if ($campaign->scheduled_at)
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    Scheduled: {{ $campaign->scheduled_at->format('M d, Y H:i') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Topic -->
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        {{ $campaign->topic->name }}
                                    </span>
                                </td>

                                <!-- Status -->
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
                                            'failed' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                                        ];
                                        $colorClass =
                                            $statusColors[$campaign->status] ??
                                            'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium {{ $colorClass }}">
                                        {{ ucfirst($campaign->status) }}
                                    </span>
                                </td>

                                <!-- Recipients -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $campaign->sent_count }} / {{ $campaign->total_recipients }}
                                        </span>
                                        @if ($campaign->total_recipients > 0)
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-1">
                                                <div class="bg-blue-600 h-1.5 rounded-full"
                                                    style="width: {{ ($campaign->sent_count / $campaign->total_recipients) * 100 }}%">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Performance -->
                                <td class="px-6 py-4">
                                    @if ($campaign->status === 'sent')
                                        <div class="flex items-center gap-3">
                                            <div class="text-center">
                                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                                    {{ $campaign->open_rate }}%</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Opens</p>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                                    {{ $campaign->click_rate }}%</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Clicks</p>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 text-sm">-</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">

                                        <!-- View -->
                                        <a href="{{ route('admin.email-campaigns.show', $campaign) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors text-xs font-medium"
                                            title="View Campaign">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        <!-- Edit (Draft only) -->
                                        @if ($campaign->status === 'draft')
                                            <a href="{{ route('admin.email-campaigns.edit', $campaign) }}"
                                                class="p-2 rounded-lg text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors"
                                                title="Edit Campaign">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        @endif

                                        <!-- Send (Draft/Scheduled) -->
                                        @if (in_array($campaign->status, ['draft', 'scheduled']))
                                            <form action="{{ route('admin.email-campaigns.send', $campaign) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="p-2 rounded-lg text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors"
                                                    onclick="return confirm('Send this campaign now to {{ $campaign->topic->activeSubscribers()->count() }} subscribers?')"
                                                    title="Send Campaign">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

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
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No
                                            campaigns found</h3>
                                        <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by creating your
                                            first email campaign</p>
                                        <a href="{{ route('admin.email-campaigns.create') }}"
                                            class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Create First Campaign
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if (method_exists($campaigns, 'hasPages') && $campaigns->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    {{ $campaigns->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
