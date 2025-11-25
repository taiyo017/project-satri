@props([
    'show' => 'showDeleteModal',
    'title' => 'Delete Item?',
    'message' => 'This action cannot be undone. Are you sure you want to proceed?',
    'confirmText' => 'Delete',
    'cancelText' => 'Cancel',
])

<div x-show="{{ $show }}" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/60 dark:bg-black/80 backdrop-blur-sm transition-opacity"
        @click="{{ $show }} = false"></div>

    <!-- Modal -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-8 transform transition-all border-2 border-red-200 dark:border-red-800"
            @click.away="{{ $show }} = false">
            <!-- Icon -->
            <div
                class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-5 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600 dark:text-red-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <!-- Content -->
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 text-center mb-3">{{ $title }}</h3>
            <p class="text-gray-600 dark:text-gray-400 text-center mb-8 leading-relaxed">
                {{ $message }}
            </p>

            <!-- Actions -->
            <div class="flex gap-3">
                <button type="button" @click="{{ $show }} = false"
                    class="flex-1 px-4 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-xl transition-colors">
                    {{ $cancelText }}
                </button>
                <button type="button"
                    {{ $attributes->merge(['class' => 'flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white font-semibold rounded-xl transition-colors shadow-lg shadow-red-500/30 dark:shadow-red-900/30']) }}>
                    {{ $confirmText }}
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
