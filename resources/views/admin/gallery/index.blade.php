<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    {{ __('Gallery Management') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Manage your images and media gallery
                </p>
            </div>

            <div class="flex gap-3">
                <!-- Bulk Actions (shown when items selected) -->
                <div id="bulkActions" class="hidden items-center gap-2">
                    <span id="selectedCount" class="text-sm font-medium text-gray-700 dark:text-gray-300">0
                        selected</span>
                    <form id="bulkDeleteForm" action="{{ route('galleries.bulk-trash') }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="ids" id="bulkDeleteIds">
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-all duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Move to Trash
                        </button>
                    </form>
                    <button onclick="clearSelection()"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-all duration-200">
                        Cancel
                    </button>
                </div>

                <!-- Add Image Button -->
                <a href="{{ route('galleries.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-[0.98]"
                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('Add New Image') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 p-4">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Images</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalImages }}</p>
                    </div>
                    <div class="p-3 rounded-xl" style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Images</p>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $activeCount }}</p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Inactive Images</p>
                        <p class="text-3xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ $inactiveCount }}</p>
                    </div>
                    <div class="p-3 bg-amber-100 dark:bg-amber-900/30 rounded-xl">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <a href="javascript:void(0);" onclick="openTrashModal()"
                class="bg-gradient-to-br from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-200 hover:scale-[1.02] group cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-red-100">Trash Bin</p>
                        <p class="text-3xl font-bold text-white mt-1">{{ $trashedCount }}</p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-xl group-hover:bg-white/30 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Gallery Grid -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Gallery Images</h3>
                <button onclick="toggleSelectMode()" id="selectModeBtn"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200"
                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%); color: white;">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        Select Images
                    </span>
                </button>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4"
                id="galleryGrid">
                @forelse($images as $image)
                    <div class="gallery-item group relative bg-gray-50 dark:bg-gray-900 rounded-xl overflow-hidden border-2 border-transparent hover:border-[#1363C6] transition-all duration-200"
                        data-id="{{ $image->id }}">

                        <!-- Selection Checkbox (hidden by default) -->
                        <div class="selection-checkbox absolute top-3 left-3 z-20 hidden">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox"
                                    class="image-checkbox w-5 h-5 rounded border-2 border-gray-300 dark:border-gray-600 cursor-pointer focus:ring-2 focus:ring-[#1363C6]"
                                    style="accent-color: #1363C6;" data-id="{{ $image->id }}"
                                    onchange="updateSelection()">
                            </label>
                        </div>

                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3 z-10">
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-semibold text-white shadow-lg backdrop-blur-sm {{ $image->is_active ? 'bg-green-500/90' : 'bg-gray-500/90' }}">
                                {{ $image->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <!-- Image -->
                        <div class="aspect-square relative overflow-hidden bg-gray-100 dark:bg-gray-800 cursor-pointer"
                            onclick="openImagePreview('{{ asset('storage/' . $image->image) }}', '{{ $image->title ?? 'Gallery Image' }}', '{{ $image->created_at->format('M d, Y') }}')">
                            <img src="{{ asset('storage/' . $image->image) }}"
                                alt="{{ $image->title ?? 'Gallery Image' }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                loading="lazy">
                        </div>

                        <!-- Image Info & Actions -->
                        <div class="p-3 space-y-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                {{ $image->title ?? 'Untitled' }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="flex items-center gap-2">
                                <a href="{{ route('galleries.edit', $image->id) }}"
                                    class="flex-1 px-3 py-1.5 text-xs font-medium rounded-lg transition-all duration-200 flex items-center justify-center gap-1.5 hover:scale-[1.02]"
                                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%); color: white;">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>

                                <form action="{{ route('galleries.trash', $image->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Move this image to trash?')"
                                        class="px-3 py-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 text-red-600 dark:text-red-400 text-xs font-medium rounded-lg transition-all duration-200 flex items-center gap-1.5 hover:scale-[1.02]">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Trash
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-4"
                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No images yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">
                            Start building your gallery by adding your first image. Share your moments and memories.
                        </p>
                        <a href="{{ route('galleries.create') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 text-white font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add First Image
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if ($images->hasPages())
            <div class="flex justify-center">
                {{ $images->links() }}
            </div>
        @endif

    </div>

    <!-- Image Preview Modal -->
    <div id="imagePreviewModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 backdrop-blur-sm p-4"
        onclick="closeImagePreview()">
        <div class="relative max-w-6xl w-full animate-scale-in" onclick="event.stopPropagation()">
            <button onclick="closeImagePreview()"
                class="absolute -top-4 -right-4 w-12 h-12 bg-white dark:bg-gray-800 rounded-full shadow-lg flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300 group z-10">
                <svg class="w-6 h-6 text-gray-700 dark:text-gray-300 group-hover:rotate-90 transition-transform duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-2xl">
                <img id="previewImage" src="" alt=""
                    class="w-full max-h-[70vh] object-contain bg-gray-100 dark:bg-gray-900">
                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 id="previewTitle" class="text-xl font-bold text-gray-900 dark:text-white mb-2"></h3>
                    <p id="previewDate" class="text-sm text-gray-500 dark:text-gray-400"></p>
                </div>
            </div>
        </div>
    </div>
    <x-trash-modal type="galleries" />
    <style>
        @keyframes scale-in {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-scale-in {
            animation: scale-in 0.2s ease-out;
        }

        .select-mode .selection-checkbox {
            display: block !important;
        }

        .select-mode .gallery-item.selected {
            border-color: #1363C6 !important;
            background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%);
        }

        .gallery-item {
            transition: all 0.2s ease;
        }
    </style>

    <script>
        let selectMode = false;
        const selectedIds = new Set();

        function toggleSelectMode() {
            selectMode = !selectMode;
            const container = document.getElementById('galleryGrid');
            const btn = document.getElementById('selectModeBtn');

            if (selectMode) {
                container.classList.add('select-mode');
                btn.innerHTML = `
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel Selection
                    </span>
                `;
                btn.style.background = '#6B7280';
            } else {
                container.classList.remove('select-mode');
                btn.innerHTML = `
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        Select Images
                    </span>
                `;
                btn.style.background = 'linear-gradient(135deg, #1363C6 0%, #0d4a99 100%)';
                clearSelection();
            }
        }

        function updateSelection() {
            selectedIds.clear();
            document.querySelectorAll('.image-checkbox:checked').forEach(cb => {
                selectedIds.add(cb.dataset.id);
                cb.closest('.gallery-item').classList.add('selected');
            });

            document.querySelectorAll('.image-checkbox:not(:checked)').forEach(cb => {
                cb.closest('.gallery-item').classList.remove('selected');
            });

            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');

            if (selectedIds.size > 0) {
                bulkActions.classList.remove('hidden');
                bulkActions.classList.add('flex');
                selectedCount.textContent = `${selectedIds.size} selected`;
                document.getElementById('bulkDeleteIds').value = Array.from(selectedIds).join(',');
            } else {
                bulkActions.classList.add('hidden');
                bulkActions.classList.remove('flex');
            }
        }

        function clearSelection() {
            selectedIds.clear();
            document.querySelectorAll('.image-checkbox').forEach(cb => {
                cb.checked = false;
                cb.closest('.gallery-item').classList.remove('selected');
            });
            document.getElementById('bulkActions').classList.add('hidden');
        }

        function openImagePreview(imageSrc, title, date) {
            if (selectMode) return;

            const modal = document.getElementById('imagePreviewModal');
            const image = document.getElementById('previewImage');
            const titleEl = document.getElementById('previewTitle');
            const dateEl = document.getElementById('previewDate');

            image.src = imageSrc;
            titleEl.textContent = title;
            dateEl.textContent = `Added on ${date}`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeImagePreview() {
            const modal = document.getElementById('imagePreviewModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImagePreview();
                if (selectMode) toggleSelectMode();
            }
        });

        document.getElementById('bulkDeleteForm')?.addEventListener('submit', function(e) {
            if (!confirm(`Move ${selectedIds.size} image(s) to trash?`)) {
                e.preventDefault();
            }
        });
    </script>

</x-app-layout>
