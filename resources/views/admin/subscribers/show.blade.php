<x-app-layout>
    <div class="space-y-4">
        <!-- Header with Back Button -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.subscribers.index') }}"
                    class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    title="Back to Subscribers">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-bold text-xl sm:text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                        Subscriber Details
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                        View and manage subscriber information
                    </p>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @foreach (['success', 'error'] as $msg)
            @if (session($msg))
                <x-alert type="{{ $msg }}" :message="session($msg)" dismissible="true" />
            @endif
        @endforeach

        <!-- Subscriber Info Card -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold text-white flex-shrink-0"
                        style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                        {{ strtoupper(substr($subscriber->email, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ $subscriber->email }}
                        </h3>
                        <div class="flex items-center gap-2 mt-2">
                            @php
                                $statusColors = [
                                    'verified' =>
                                        'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                                    'pending' =>
                                        'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
                                    'unsubscribed' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                                    'bounced' => 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300',
                                ];
                                $colorClass =
                                    $statusColors[$subscriber->status] ??
                                    'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                            @endphp
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-medium {{ $colorClass }}">
                                @if ($subscriber->status === 'verified')
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                                {{ ucfirst($subscriber->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Email -->
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Email Address</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white break-all">{{ $subscriber->email }}
                        </p>
                    </div>

                    <!-- Name -->
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Full Name</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $subscriber->name ?? 'N/A' }}
                        </p>
                    </div>

                    <!-- Verified At -->
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Verified At</p>
                        @if ($subscriber->verified_at)
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $subscriber->verified_at->format('M d, Y H:i') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $subscriber->verified_at->diffForHumans() }}</p>
                        @else
                            <p class="text-sm text-gray-400 dark:text-gray-500">Not verified</p>
                        @endif
                    </div>

                    <!-- Subscribed At -->
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Subscribed At</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $subscriber->created_at->format('M d, Y H:i') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $subscriber->created_at->diffForHumans() }}</p>
                    </div>

                    <!-- IP Address -->
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">IP
                            Address</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white font-mono">
                            {{ $subscriber->ip_address ?? 'N/A' }}</p>
                    </div>

                    <!-- Last Updated -->
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                            Last Updated</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $subscriber->updated_at->format('M d, Y H:i') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $subscriber->updated_at->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Update Status Form -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('admin.subscribers.update-status', $subscriber) }}"
                        class="flex flex-col sm:flex-row items-start sm:items-end gap-4">
                        @csrf
                        <div class="flex-1 w-full sm:w-auto">
                            <label for="status"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Update
                                Status</label>
                            <select name="status" id="status"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors">
                                <option value="pending" {{ $subscriber->status === 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="verified" {{ $subscriber->status === 'verified' ? 'selected' : '' }}>
                                    Verified</option>
                                <option value="unsubscribed"
                                    {{ $subscriber->status === 'unsubscribed' ? 'selected' : '' }}>Unsubscribed
                                </option>
                                <option value="bounced" {{ $subscriber->status === 'bounced' ? 'selected' : '' }}>
                                    Bounced</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-2 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg"
                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Subscribed Topics -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Subscribed Topics</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Topics this subscriber is interested in</p>
            </div>
            <div class="p-6">
                <div class="flex flex-wrap gap-2">
                    @forelse($subscriber->topics as $topic)
                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            {{ $topic->name }}
                        </span>
                    @empty
                        <div class="text-center py-8 w-full">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3"
                                style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%);">
                                <svg class="w-6 h-6" style="color: #1363C6;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">No topics subscribed</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Email History -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Email History</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Last 50 emails sent to this subscriber</p>
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
                                Type</th>
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
                        @forelse($subscriber->emailLogs as $log)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm font-medium text-gray-900 dark:text-white">{{ Str::limit($log->subject, 50) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                        {{ ucfirst($log->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'sent' =>
                                                'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                                            'failed' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                                            'queued' =>
                                                'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
                                        ];
                                        $statusColor =
                                            $statusColors[$log->status] ??
                                            'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium {{ $statusColor }}">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($log->sent_at)
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm text-gray-900 dark:text-white">{{ $log->sent_at->format('M d, Y') }}</span>
                                            <span
                                                class="text-xs text-gray-500 dark:text-gray-400">{{ $log->sent_at->format('H:i') }}</span>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($log->opened_at)
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm text-gray-900 dark:text-white">{{ $log->opened_at->format('M d, Y') }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $log->opened_at->format('H:i') }}
                                                @if ($log->open_count > 1)
                                                    <span class="ml-1">({{ $log->open_count }}x)</span>
                                                @endif
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($log->click_count > 0)
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                            </svg>
                                            {{ $log->click_count }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-400 dark:text-gray-500">0</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3"
                                            style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%);">
                                            <svg class="w-6 h-6" style="color: #1363C6;" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 dark:text-gray-400">No emails sent yet</p>
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
