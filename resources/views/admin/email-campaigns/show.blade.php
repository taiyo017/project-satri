<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Campaign Details') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    View campaign performance and details
                </p>
            </div>

            <div class="flex items-center gap-3">
                @if (in_array($emailCampaign->status, ['draft', 'scheduled']))
                    <form method="POST" action="{{ route('admin.email-campaigns.send', $emailCampaign) }}"
                        class="inline">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-white font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] bg-gradient-to-br from-green-600 to-green-700 hover:from-green-700 hover:to-green-800"
                            onclick="return confirm('Send this campaign now to {{ $emailCampaign->topic->activeSubscribers()->count() }} subscribers?')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Send Campaign
                        </button>
                    </form>
                @endif

                <a href="{{ route('admin.email-campaigns.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Campaigns
                </a>
            </div>
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
                            $statusColors[$emailCampaign->status] ??
                            'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                    @endphp
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium {{ $colorClass }}">
                        {{ ucfirst($emailCampaign->status) }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Subject</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $emailCampaign->subject }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Topic</p>
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            {{ $emailCampaign->topic->name }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Created</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $emailCampaign->created_at->format('M d, Y H:i') }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $emailCampaign->created_at->diffForHumans() }}
                        </p>
                    </div>
                    @if ($emailCampaign->scheduled_at)
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Scheduled For</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $emailCampaign->scheduled_at->format('M d, Y H:i') }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $emailCampaign->scheduled_at->diffForHumans() }}
                            </p>
                        </div>
                    @endif
                    @if ($emailCampaign->sent_at)
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Sent At</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $emailCampaign->sent_at->format('M d, Y H:i') }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $emailCampaign->sent_at->diffForHumans() }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Campaign Stats -->
        @if ($emailCampaign->status === 'sent')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Sent</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                                {{ number_format($emailCampaign->sent_count) }}</p>
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
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Open Rate</p>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">
                                {{ $emailCampaign->open_rate }}%</p>
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
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Click Rate</p>
                            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400 mt-1">
                                {{ $emailCampaign->click_rate }}%</p>
                        </div>
                        <div class="p-2.5 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
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
                                {{ number_format($emailCampaign->failed_count) }}</p>
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
        @elseif($emailCampaign->status === 'sending')
            <div
                class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 animate-spin" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-blue-900 dark:text-blue-100 text-lg mb-2">Campaign is being sent...
                        </h3>
                        <p class="text-blue-700 dark:text-blue-300 mb-3">
                            Progress: {{ $emailCampaign->sent_count }} / {{ $emailCampaign->total_recipients }}
                            ({{ $emailCampaign->total_recipients > 0 ? round(($emailCampaign->sent_count / $emailCampaign->total_recipients) * 100) : 0 }}%)
                        </p>
                        <div class="w-full bg-blue-200 dark:bg-blue-900/50 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                                style="width: {{ $emailCampaign->total_recipients > 0 ? round(($emailCampaign->sent_count / $emailCampaign->total_recipients) * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Campaign Content -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Campaign Content</h3>
                </div>
            </div>

            <div class="p-6">
                <div
                    class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 bg-gray-50 dark:bg-gray-900/50 prose prose-sm dark:prose-invert max-w-none">
                    {!! $emailCampaign->content !!}
                </div>
            </div>
        </div>

        <!-- Recent Email Logs -->
        @if ($emailCampaign->emailLogs->isNotEmpty())
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
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Recent Email Logs</h3>
                        <span
                            class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                            Last 100
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                    Recipient</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                    Sent</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                    Opened</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                    Clicks</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($emailCampaign->emailLogs as $log)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white"
                                                style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                                {{ strtoupper(substr($log->subscriber->email, 0, 1)) }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $log->subscriber->email }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $logStatusColors = [
                                                'sent' =>
                                                    'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                                                'failed' =>
                                                    'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                                                'queued' =>
                                                    'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
                                            ];
                                            $logColorClass =
                                                $logStatusColors[$log->status] ??
                                                'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $logColorClass }}">
                                            {{ ucfirst($log->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $log->sent_at ? $log->sent_at->format('M d, H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $log->opened_at ? $log->opened_at->format('M d, H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400">
                                            {{ $log->click_count }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
