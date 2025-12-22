<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Services Management') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 sm:mt-1">
                    Manage your services and offerings
                </p>
            </div>

            <!-- Create Button -->
            <a href="{{ route('services.create') }}"
                class="inline-flex items-center gap-1.5 sm:gap-2 px-4 sm:px-5 py-2 sm:py-2.5 text-white text-xs sm:text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] whitespace-nowrap"
                style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="hidden sm:inline">{{ __('Add New Service') }}</span>
                <span class="sm:hidden">{{ __('Add') }}</span>
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-4">
                <x-alert type="success" :message="session('success')" dismissible="true" />
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4">
                <x-alert type="error" :message="session('error')" dismissible="true" />
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Services</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ $services->total() }}</p>
                    </div>
                    <div class="p-2.5 rounded-lg" style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Active</p>
                        <p class="text-xl font-bold text-green-600 dark:text-green-400 mt-1">
                            {{ $services->where('status', 'active')->count() }}</p>
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
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Inactive</p>
                        <p class="text-xl font-bold text-gray-600 dark:text-gray-400 mt-1">
                            {{ $services->where('status', 'inactive')->count() }}</p>
                    </div>
                    <div class="p-2.5 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden"
            x-data="{
                showDeleteModal: false,
                serviceToDelete: null,
                confirmDelete(serviceId) {
                    this.serviceToDelete = serviceId;
                    this.showDeleteModal = true;
                },
                executeDelete() {
                    if (this.serviceToDelete) {
                        document.getElementById('delete-service-' + this.serviceToDelete).submit();
                    }
                }
            }">

            <!-- Table Header with Search -->
            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    <div class="flex items-center gap-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Services</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            ({{ $services->count() }} of {{ $services->total() }})
                        </p>
                    </div>
                    </div>

                    <!-- Search & Filter -->
                    <form method="GET" action="{{ route('services.index') }}" class="flex items-center gap-3">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search services..."
                                class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors text-sm w-64">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <select name="status"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors text-sm"
                            onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                                Inactive</option>
                        </select>

                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 text-white font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Search
                        </button>

                        @if (request('search') || request('status'))
                            <a href="{{ route('services.index') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Clear
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
                                Service Details
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Status
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Featured
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Last Updated
                            </th>
                            <th
                                class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($services as $service)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">

                                <!-- Service Details -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <!-- Icon or Image -->
                                        @if (isset($service->icon) && $service->icon)
                                            <img src="{{ asset('storage/' . $service->icon) }}"
                                                alt="{{ $service->title }}"
                                                class="w-10 h-10 rounded-lg object-cover border-2 border-gray-200 dark:border-gray-700 flex-shrink-0">
                                        @else
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                                                style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%);">
                                                <svg class="w-5 h-5" style="color: #1363C6;" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif

                                        <!-- Title & Description -->
                                        <div class="flex flex-col min-w-0">
                                            <span class="font-semibold text-gray-900 dark:text-white text-sm truncate">
                                                {{ Str::limit($service->title, 50) }}
                                            </span>
                                            @if (isset($service->slug))
                                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                    /{{ $service->slug }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    @if ($service->status === 'active')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-medium">
                                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <!-- Featured -->
                                <td class="px-6 py-4">
                                    @if ($service->is_featured)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-medium">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            Featured
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 text-sm">—</span>
                                    @endif
                                </td>

                                <!-- Last Updated -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $service->updated_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ $service->updated_at->format('h:i A') }}
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">

                                        <!-- View (if applicable) -->
                                        @if (isset($service->slug) && $service->status === 'active')
                                            <a href="{{ url('/services/' . $service->slug) }}" target="_blank"
                                                class="p-2 rounded-lg text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
                                                title="View Service">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        @endif

                                        <!-- Edit -->
                                        <a href="{{ route('services.edit', $service) }}"
                                            class="p-2 rounded-lg text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors"
                                            title="Edit Service">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <!-- Delete -->
                                        <button type="button" @click="confirmDelete({{ $service->id }})"
                                            class="p-2 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                            title="Delete Service">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                        <!-- Hidden Delete Form -->
                                        <form id="delete-service-{{ $service->id }}"
                                            action="{{ route('services.destroy', $service) }}" method="POST"
                                            class="hidden">
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
                                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No
                                            services found</h3>
                                        <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by creating your
                                            first service</p>
                                        <a href="{{ route('services.create') }}"
                                            class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Create First Service
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($services->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    {{ $services->links() }}
                </div>
            @endif

            <!-- Delete Modal -->
            <x-delete-modal show="showDeleteModal" title="Delete Service?"
                message="Are you sure you want to delete this service? This action cannot be undone."
                @click="executeDelete(); showDeleteModal = false" />
        </div>
    </div>

</x-app-layout>
