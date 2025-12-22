<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Subscription Topics') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 sm:mt-1">
                    Manage email subscription topics and categories
                </p>
            </div>

            <!-- Create Button -->
            <a href="{{ route('admin.subscription-topics.create') }}"
                class="inline-flex items-center gap-1.5 sm:gap-2 px-4 sm:px-5 py-2 sm:py-2.5 text-white text-xs sm:text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] whitespace-nowrap"
                style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="hidden sm:inline">{{ __('Create Topic') }}</span>
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

            <!-- Total Topics -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Topics</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ $topics->count() }}</p>
                    </div>
                    <div class="p-2.5 rounded-lg"
                        style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Topics -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Active Topics</p>
                        <p class="text-xl font-bold text-green-600 dark:text-green-400 mt-1">
                            {{ $topics->where('is_active', true)->count() }}
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

            <!-- Total Subscribers -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Subscribers</p>
                        <p class="text-xl font-bold text-purple-600 dark:text-purple-400 mt-1">
                            {{ $topics->sum(fn($t) => $t->subscribers()->count()) }}
                        </p>
                    </div>
                    <div class="p-2.5 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Inactive Topics -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Inactive</p>
                        <p class="text-xl font-bold text-red-600 dark:text-red-400 mt-1">
                            {{ $topics->where('is_active', false)->count() }}
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

        <!-- Topics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
            x-data="{
                showDeleteModal: false,
                topicToDelete: null,
                topicName: '',
                confirmDelete(topicId, topicName) {
                    this.topicToDelete = topicId;
                    this.topicName = topicName;
                    this.showDeleteModal = true;
                },
                executeDelete() {
                    if (this.topicToDelete) {
                        document.getElementById('delete-topic-' + this.topicToDelete).submit();
                    }
                }
            }">

            @forelse ($topics as $topic)
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-all duration-200 group">

                    <!-- Topic Header -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700"
                        style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.05) 0%, rgba(13, 74, 153, 0.05) 100%);">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0"
                                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate">
                                        {{ $topic->name }}
                                    </h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ $topic->slug }}
                                    </p>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            @if ($topic->is_active)
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Active
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs font-medium">
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

                    <!-- Topic Body -->
                    <div class="p-6">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                            {{ $topic->description ?? 'No description provided.' }}
                        </p>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ $topic->subscribers()->count() }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Subscribers</p>
                            </div>
                            <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ $topic->campaigns()->count() }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Campaigns</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.subscription-topics.edit', $topic) }}"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>

                            <button type="button"
                                @click="confirmDelete({{ $topic->id }}, '{{ $topic->name }}')"
                                class="p-2 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                title="Delete Topic">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>

                            <!-- Hidden Delete Form -->
                            <form id="delete-topic-{{ $topic->id }}"
                                action="{{ route('admin.subscription-topics.destroy', $topic) }}" method="POST"
                                class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-16 text-center">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4"
                            style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%);">
                            <svg class="w-8 h-8" style="color: #1363C6;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No topics found</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by creating your first
                            subscription topic</p>
                        <a href="{{ route('admin.subscription-topics.create') }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Create First Topic
                        </a>
                    </div>
                </div>
            @endforelse

        </div>

        <!-- Delete Modal -->
        <x-delete-modal show="showDeleteModal" title="Delete Subscription Topic"
            x-bind:message="'Are you sure you want to delete &quot;' + topicName +
                '&quot;? This action cannot be undone and will affect all subscribers to this topic.'"
            @click="executeDelete(); showDeleteModal = false" />
    </div>
</x-app-layout>
