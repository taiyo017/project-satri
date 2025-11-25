<!-- Trash Modal Component - Place in resources/views/components/trash-modal.blade.php -->
<div id="trashModal"
    class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden z-50 items-center justify-center p-4 transition-all duration-300">

    <div
        class="bg-white dark:bg-gray-800 w-full max-w-5xl rounded-2xl shadow-2xl relative animate-scale-in max-h-[90vh] flex flex-col">

        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Trash Bin</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <span id="trashCount">0</span> items in trash
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <!-- Empty Trash Button -->
                <button onclick="emptyTrash()" id="emptyTrashBtn"
                    class="hidden px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-all duration-200 items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Empty Trash
                </button>

                <!-- Close Button -->
                <button onclick="closeTrashModal()"
                    class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div id="trashContent" class="flex-1 overflow-y-auto p-6">
            <!-- Loading State -->
            <div id="loadingState" class="flex items-center justify-center py-20">
                <div class="text-center">
                    <div
                        class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-200 border-t-blue-600 mb-4">
                    </div>
                    <p class="text-gray-500 dark:text-gray-400">Loading trash items...</p>
                </div>
            </div>

            <!-- Items Grid -->
            <div id="trashItemsGrid" class="hidden grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Items will be injected here -->
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden text-center py-20">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Trash is Empty</h3>
                <p class="text-gray-500 dark:text-gray-400">No deleted items to display</p>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        let trashItems = [];

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function openTrashModal() {
            const modal = document.getElementById('trashModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            fetchTrashItems();
        }

        function closeTrashModal() {
            const modal = document.getElementById('trashModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function fetchTrashItems() {
            showLoadingState();

            fetch("{{ route('galleries.trash.index') }}", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.ok ? res.json() : Promise.reject(res))
                .then(data => {
                    if (data.success) {
                        trashItems = data.data || [];
                        renderTrashItems();
                    } else {
                        throw new Error(data.message || 'Failed to fetch trash items');
                    }
                })
                .catch(async err => {
                    let msg = 'Failed to fetch trash items';
                    if (err.text) msg = await err.text();
                    showErrorState(msg);
                    console.error(err);
                });
        }

        function renderTrashItems() {
            const grid = document.getElementById('trashItemsGrid');
            const emptyState = document.getElementById('emptyState');
            const loadingState = document.getElementById('loadingState');
            const trashCount = document.getElementById('trashCount');
            const emptyTrashBtn = document.getElementById('emptyTrashBtn');

            loadingState.classList.add('hidden');

            if (trashItems.length === 0) {
                grid.classList.add('hidden');
                emptyState.classList.remove('hidden');
                emptyTrashBtn.classList.add('hidden');
                trashCount.textContent = '0';
                return;
            }

            grid.classList.remove('hidden');
            emptyState.classList.add('hidden');
            emptyTrashBtn.classList.remove('hidden');
            trashCount.textContent = trashItems.length;

            grid.innerHTML = trashItems.map(item => {
                const imgUrl = item.image ? `{{ asset('storage') }}/${item.image}` : '/placeholder.jpg';
                return `
        <div class="group bg-gray-50 dark:bg-gray-900 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 hover:shadow-lg">
            <div class="aspect-square relative overflow-hidden bg-gray-100 dark:bg-gray-800">
                <img src="${imgUrl}" alt="${escapeHtml(item.title || 'Deleted Image')}" 
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                    onerror="this.src='/placeholder.jpg'">
            </div>
            <div class="p-4 space-y-3">
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white truncate">${escapeHtml(item.title || 'Untitled')}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Deleted ${formatDate(item.deleted_at)}
                    </p>
                </div>
                <div class="flex gap-2">
                    <button onclick="restoreItem(${item.id})" 
                        class="flex-1 px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg">
                        Restore
                    </button>
                    <button onclick="forceDeleteItem(${item.id}, '${escapeHtml(item.title || 'this item')}')" 
                        class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg">
                        Delete
                    </button>
                </div>
            </div>
        </div>`;
            }).join('');
        }

        function restoreItem(id) {
            if (!confirm('Restore this item?')) return;
            performAction(`{{ url('galleries') }}/${id}/restore`, 'POST', 'Item restored successfully!');
        }

        function forceDeleteItem(id, title) {
            if (!confirm(`Permanently delete "${title}"? This cannot be undone!`)) return;
            performAction(`{{ url('galleries') }}/${id}/force-delete`, 'DELETE', 'Item permanently deleted!');
        }

        function emptyTrash() {
            if (!confirm(`Permanently delete all ${trashItems.length} items?`)) return;
            performAction("{{ route('galleries.trash.empty') }}", 'DELETE', 'Trash emptied successfully!');
        }

        function performAction(url, method, successMessage) {
            const formData = new FormData();
            formData.append('_token', csrfToken);
            if (method !== 'POST') formData.append('_method', method);

            showLoadingState();

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message || successMessage, 'success');
                        fetchTrashItems();
                    } else {
                        throw new Error(data.message || 'Operation failed');
                    }
                })
                .catch(err => {
                    console.error(err);
                    showNotification(err.message || 'An error occurred', 'error');
                    fetchTrashItems();
                });
        }

        function showLoadingState() {
            document.getElementById('loadingState').classList.remove('hidden');
            document.getElementById('trashItemsGrid').classList.add('hidden');
            document.getElementById('emptyState').classList.add('hidden');
        }

        function showErrorState(message) {
            const loadingState = document.getElementById('loadingState');
            loadingState.innerHTML = `
    <div class="text-center py-10">
        <p class="text-red-600 font-medium mb-4">${escapeHtml(message)}</p>
        <button onclick="fetchTrashItems()" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Try Again</button>
    </div>`;
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diff = now - date;
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            if (days === 0) return 'today';
            if (days === 1) return 'yesterday';
            if (days < 7) return `${days} days ago`;
            if (days < 30) return `${Math.floor(days/7)} weeks ago`;
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className =
                `fixed top-4 right-4 z-[70] px-6 py-4 rounded-lg shadow-xl animate-slide-in ${type==='success' ? 'bg-green-600 text-white':'bg-red-600 text-white'}`;
            notification.innerHTML = escapeHtml(message);
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && !document.getElementById('trashModal').classList.contains('hidden')) {
                closeTrashModal();
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        @keyframes slide-in {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in {
            animation: slide-in 0.3s ease-out;
            transition: all 0.3s ease-out;
        }
    </style>
@endpush
