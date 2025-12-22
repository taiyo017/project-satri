<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Subscribers Management') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 sm:mt-1">
                    Manage email subscribers and their preferences
                </p>
            </div>

            <!-- Export Button -->
            <a href="{{ route('admin.subscribers.export', request()->query()) }}"
                class="inline-flex items-center gap-1.5 sm:gap-2 px-4 sm:px-5 py-2 sm:py-2.5 text-white text-xs sm:text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] whitespace-nowrap bg-gradient-to-br from-green-600 to-green-700 hover:from-green-700 hover:to-green-800">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="hidden sm:inline">{{ __('Export to Excel') }}</span>
                <span class="sm:hidden">{{ __('Export') }}</span>
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

            <!-- Total Subscribers -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Subscribers</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ $subscribers->total() }}</p>
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

            <!-- Verified -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Verified</p>
                        <p class="text-xl font-bold text-green-600 dark:text-green-400 mt-1">
                            {{ $subscribers->where('status', 'verified')->count() }}
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

            <!-- Pending -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Pending</p>
                        <p class="text-xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">
                            {{ $subscribers->where('status', 'pending')->count() }}
                        </p>
                    </div>
                    <div class="p-2.5 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Unsubscribed -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Unsubscribed</p>
                        <p class="text-xl font-bold text-red-600 dark:text-red-400 mt-1">
                            {{ $subscribers->where('status', 'unsubscribed')->count() }}
                        </p>
                    </div>
                    <div class="p-2.5 bg-red-100 dark:bg-red-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        <!-- Subscribers Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden"
            x-data="{
                showDeleteModal: false,
                subscriberToDelete: null,
                subscriberEmail: '',
                confirmDelete(subscriberId, subscriberEmail) {
                    this.subscriberToDelete = subscriberId;
                    this.subscriberEmail = subscriberEmail;
                    this.showDeleteModal = true;
                },
                executeDelete() {
                    if (this.subscriberToDelete) {
                        document.getElementById('delete-subscriber-' + this.subscriberToDelete).submit();
                    }
                }
            }">

            <!-- Table Header with Search -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Subscribers</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                ({{ $subscribers->count() }} of {{ $subscribers->total() }})
                            </p>
                        </div>
                    </div>

                    <!-- Search & Filter Form -->
                    <form method="GET" action="{{ route('admin.subscribers.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by email or name..."
                                class="pl-10 pr-4 py-2 w-full border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors text-sm">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <select name="status"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors text-sm">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="unsubscribed" {{ request('status') === 'unsubscribed' ? 'selected' : '' }}>Unsubscribed</option>
                            <option value="bounced" {{ request('status') === 'bounced' ? 'selected' : '' }}>Bounced</option>
                        </select>

                        <select name="topic"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors text-sm">
                            <option value="">All Topics</option>
                            @foreach ($topics as $topic)
                                <option value="{{ $topic->id }}" {{ request('topic') == $topic->id ? 'selected' : '' }}>
                                    {{ $topic->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="date_filter"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors text-sm">
                            <option value="">All Time</option>
                            <option value="today" {{ request('date_filter') === 'today' ? 'selected' : '' }}>Today</option>
                            <option value="week" {{ request('date_filter') === 'week' ? 'selected' : '' }}>This Week</option>
                            <option value="month" {{ request('date_filter') === 'month' ? 'selected' : '' }}>This Month</option>
                        </select>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 text-white font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] whitespace-nowrap"
                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span class="hidden sm:inline">Search</span>
                        </button>

                        @if (request('search') || request('status') || request('topic') || request('date_filter'))
                            <a href="{{ route('admin.subscribers.index') }}"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span class="hidden sm:inline">Clear</span>
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Subscriber
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Status
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Topics
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Verified
                            </th>
                            <th
                                class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($subscribers as $subscriber)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">

                                <!-- Subscriber Info -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white flex-shrink-0"
                                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                            {{ strtoupper(substr($subscriber->email, 0, 1)) }}
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <span class="font-semibold text-gray-900 dark:text-white text-sm">
                                                {{ $subscriber->email }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'verified' =>
                                                'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                                            'pending' =>
                                                'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
                                            'unsubscribed' =>
                                                'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                                            'bounced' =>
                                                'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300',
                                        ];
                                        $colorClass =
                                            $statusColors[$subscriber->status] ??
                                            'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium {{ $colorClass }}">
                                        @if ($subscriber->status === 'verified')
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @elseif($subscriber->status === 'pending')
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                        {{ ucfirst($subscriber->status) }}
                                    </span>
                                </td>

                                <!-- Topics -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($subscriber->topics as $topic)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                                                {{ $topic->name }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-400">No topics</span>
                                        @endforelse
                                    </div>
                                </td>

                                <!-- Verified Date -->
                                <td class="px-6 py-4">
                                    @if ($subscriber->verified_at)
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $subscriber->verified_at->format('M d, Y') }}
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $subscriber->verified_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 text-sm">Not verified</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">

                                        <!-- View -->
                                        <a href="{{ route('admin.subscribers.show', $subscriber) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors text-xs font-medium"
                                            title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        <!-- Delete -->
                                        <button type="button"
                                            @click="confirmDelete({{ $subscriber->id }}, '{{ $subscriber->email }}')"
                                            class="p-2 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                            title="Delete Subscriber">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                        <!-- Hidden Delete Form -->
                                        <form id="delete-subscriber-{{ $subscriber->id }}"
                                            action="{{ route('admin.subscribers.destroy', $subscriber) }}"
                                            method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4"
                                            style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%);">
                                            <svg class="w-8 h-8" style="color: #1363C6;" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No
                                            subscribers found</h3>
                                        <p class="text-gray-500 dark:text-gray-400">Subscribers will appear here once
                                            they sign up</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($subscribers->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    {{ $subscribers->links() }}
                </div>
            @endif

            <!-- Delete Modal -->
            <x-delete-modal show="showDeleteModal" title="Delete Subscriber"
                x-bind:message="'Are you sure you want to delete &quot;' + subscriberEmail +
                    '&quot;? This action cannot be undone and will remove all associated data.'"
                @click="executeDelete(); showDeleteModal = false" />
        </div>
    </div>
</x-app-layout>
