<div x-show="showPreviewModal" x-cloak
    class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4"
    @click.self="showPreviewModal = false; previewUrl = ''; previewType = ''; previewName = ''"
    @keydown.escape.window="showPreviewModal = false; previewUrl = ''; previewType = ''; previewName = ''">

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-5xl flex flex-col" style="height: 90vh;"
        @click.stop x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90">

        <!-- Modal Header - Fixed -->
        <div
            class="flex items-center justify-between p-4 sm:p-5 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
            <div class="flex items-center gap-3">
                <!-- Icon -->
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg flex items-center justify-center flex-shrink-0"
                    :class="previewType === 'resume' ? 'bg-blue-100 dark:bg-blue-900/30' :
                        'bg-purple-100 dark:bg-purple-900/30'">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6"
                        :class="previewType === 'resume' ? 'text-blue-600 dark:text-blue-400' :
                            'text-purple-600 dark:text-purple-400'"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>

                <!-- Title -->
                <div class="min-w-0">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white truncate"
                        x-text="previewType === 'resume' ? 'Resume Preview' : 'Cover Letter Preview'"></h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 truncate" x-text="previewName"></p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 flex-shrink-0">
                <!-- Download Button -->
                <a :href="previewUrl" target="_blank" download
                    class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                    title="Download File">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </a>

                <!-- Open in New Tab Button -->
                <a :href="previewUrl" target="_blank"
                    class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                    title="Open in New Tab">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>

                <!-- Close Button -->
                <button type="button"
                    @click="showPreviewModal = false; previewUrl = ''; previewType = ''; previewName = ''"
                    class="p-2 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    title="Close (ESC)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Body - Scrollable -->
        <div class="flex-1 overflow-hidden bg-gray-100 dark:bg-gray-900 relative">


            <!-- PDF/File Preview Iframe -->
            <iframe :src="previewUrl + '#toolbar=1&navpanes=0&scrollbar=1&view=FitH'" class="w-full h-full border-0"
                @load="previewLoaded = true" x-show="showPreviewModal" title="File Preview">
            </iframe>

            <!-- Fallback for non-previewable files -->
            <div x-show="false" class="flex items-center justify-center h-full p-8">
                <div class="text-center max-w-md">
                    <svg class="w-20 h-20 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Preview Not Available
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                        This file type cannot be previewed in the browser. Please download it to view.
                    </p>
                    <a :href="previewUrl" download
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download File
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal Footer - Optional Info -->
        <div
            class="px-4 sm:px-5 py-3 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700 flex-shrink-0">
            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="hidden sm:inline">Use scroll or trackpad to navigate the document</span>
                    <span class="sm:hidden">Scroll to navigate</span>
                </span>
                <span class="hidden sm:inline">Press ESC to close</span>
            </div>
        </div>

    </div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }

    /* Custom scrollbar for better UX */
    iframe::-webkit-scrollbar {
        width: 8px;
    }

    iframe::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    iframe::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    iframe::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
