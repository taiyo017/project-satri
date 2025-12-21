<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Testimonials Management') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Manage customer testimonials and reviews
                </p>
            </div>

            <!-- Create Button -->
            <a href="{{ route('testimonials.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-[0.98]"
                style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Add New Testimonial') }}
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
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Testimonials</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $testimonials->total() }}</p>
                    </div>
                    <div class="p-3 rounded-xl" style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">
                            {{ $testimonials->where('status', 'active')->count() }}</p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Featured</p>
                        <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">
                            {{ $testimonials->where('is_featured', true)->count() }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Inactive</p>
                        <p class="text-2xl font-bold text-gray-600 dark:text-gray-400 mt-1">
                            {{ $testimonials->where('status', 'inactive')->count() }}</p>
                    </div>
                    <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-xl">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden"
            x-data="{
                showDeleteModal: false,
                testimonialToDelete: null,
                confirmDelete(testimonialId) {
                    this.testimonialToDelete = testimonialId;
                    this.showDeleteModal = true;
                },
                executeDelete() {
                    if (this.testimonialToDelete) {
                        document.getElementById('delete-testimonial-' + this.testimonialToDelete).submit();
                    }
                }
            }">

            <!-- Table Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Testimonials</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Showing {{ $testimonials->count() }} of {{ $testimonials->total() }} results
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
                                Customer
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Message
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Rating
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Status
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Date
                            </th>
                            <th
                                class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($testimonials as $testimonial)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">

                                <!-- Customer -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        @if ($testimonial->photo)
                                            <img src="{{ asset('storage/' . $testimonial->photo) }}"
                                                alt="{{ $testimonial->name }}"
                                                class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700">
                                        @else
                                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold"
                                                style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                                {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div class="flex flex-col min-w-0">
                                            <span class="font-semibold text-gray-900 dark:text-white text-base">
                                                {{ $testimonial->name }}
                                            </span>
                                            @if ($testimonial->position || $testimonial->company)
                                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $testimonial->position }}{{ $testimonial->position && $testimonial->company ? ' at ' : '' }}{{ $testimonial->company }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Message -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                        {{ Str::limit($testimonial->message, 100) }}
                                    </p>
                                </td>

                                <!-- Rating -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $testimonial->rating)
                                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-2">
                                        @if ($testimonial->status === 'active')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium w-fit">
                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-medium w-fit">
                                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                                Inactive
                                            </span>
                                        @endif

                                        @if ($testimonial->is_featured)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-medium w-fit">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Date -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $testimonial->created_at->format('M d, Y') }}
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">

                                        <!-- View -->
                                        <a href="{{ route('testimonials.show', $testimonial) }}"
                                            class="p-2 rounded-lg text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
                                            title="View Testimonial">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('testimonials.edit', $testimonial) }}"
                                            class="p-2 rounded-lg text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors"
                                            title="Edit Testimonial">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <!-- Delete -->
                                        <button type="button" @click="confirmDelete({{ $testimonial->id }})"
                                            class="p-2 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                            title="Delete Testimonial">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                        <!-- Hidden Delete Form -->
                                        <form id="delete-testimonial-{{ $testimonial->id }}"
                                            action="{{ route('testimonials.destroy', $testimonial) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>

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
                                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No
                                            testimonials found</h3>
                                        <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by creating your
                                            first testimonial</p>
                                        <a href="{{ route('testimonials.create') }}"
                                            class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Create First Testimonial
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($testimonials->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    {{ $testimonials->links() }}
                </div>
            @endif

            <!-- Delete Modal -->
            <x-delete-modal show="showDeleteModal" title="Delete Testimonial?"
                message="Are you sure you want to delete this testimonial? This action cannot be undone."
                @click="executeDelete(); showDeleteModal = false" />
        </div>
    </div>

</x-app-layout>
