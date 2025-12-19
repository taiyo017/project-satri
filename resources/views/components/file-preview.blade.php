@props(['mode' => 'modal'])

<div
    @if($mode === 'modal')
        x-show="showPreviewModal"
        x-cloak
        class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 p-4"
        @click.self="closePreviewModal()"
        @keydown.escape.window="closePreviewModal()"
    @else
        class="h-full flex flex-col bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden"
        x-show="previewUrl"
        x-cloak
    @endif
>

    <div
        @if($mode === 'modal')
            class="bg-white dark:bg-gray-800 w-full max-w-5xl h-[90vh] shadow-2xl flex flex-col rounded-2xl overflow-hidden"
            @click.stop
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transform transition ease-in duration-200"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-95 opacity-0"
        @else
            class="flex flex-col h-full w-full"
        @endif
    >

        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex-shrink-0">
            <div class="flex items-center gap-4 overflow-hidden">
                <!-- Icon -->
                <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 transition-colors"
                    :class="previewType === 'resume' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' :
                        'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <template x-if="previewType === 'resume'">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </template>
                        <template x-if="previewType !== 'resume'">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </template>
                    </svg>
                </div>

                <div class="min-w-0">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white truncate"
                        x-text="previewType === 'resume' ? 'Resume Preview' : 'Cover Letter'"></h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate" x-text="previewName || 'Document'"></p>
                </div>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0">
                <a :href="previewUrl" target="_blank" download
                    class="p-2 rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    title="Download">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </a>

                <a :href="previewUrl" target="_blank"
                    class="p-2 rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    title="Open in new tab">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>

                @if($mode === 'modal')
                <button type="button"
                    @click="closePreviewModal()"
                    class="p-2 rounded-lg text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                    title="Close">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                @endif
            </div>
        </div>

        <!-- Body -->
        <div class="flex-1 bg-gray-100 dark:bg-gray-900 relative overflow-hidden flex flex-col">
             <!-- Loader -->
             <div x-show="!previewLoaded && previewUrl"
                  class="absolute inset-0 flex items-center justify-center bg-white dark:bg-gray-800 z-10">
                 <div class="flex flex-col items-center gap-3">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <span class="text-sm text-gray-500">Loading preview...</span>
                 </div>
             </div>

            <template x-if="previewUrl">
                <div class="w-full h-full">
                    <!-- PDF Viewer -->
                    <template x-if="previewUrl.toLowerCase().endsWith('.pdf')">
                        <iframe
                            :src="previewUrl"
                            class="w-full h-full border-0"
                            @load="previewLoaded = true"
                        ></iframe>
                    </template>

                    <!-- Image Viewer -->
                    <template x-if="['.jpg', '.jpeg', '.png', '.gif', '.webp'].some(ext => previewUrl.toLowerCase().endsWith(ext))">
                        <div class="w-full h-full flex items-center justify-center overflow-auto p-4">
                            <img :src="previewUrl" @load="previewLoaded = true" class="max-w-full max-h-full object-contain shadow-lg rounded" alt="Document Preview">
                        </div>
                    </template>
                    
                    <!-- Office Doc Viewer (Google Docs) -->
                    <template x-if="['.doc', '.docx', '.ppt', '.pptx', '.xls', '.xlsx'].some(ext => previewUrl.toLowerCase().endsWith(ext))">
                        <iframe
                            :src="'https://docs.google.com/gview?url=' + encodeURIComponent(previewUrl) + '&embedded=true'"
                            class="w-full h-full border-0"
                            @load="previewLoaded = true"
                        ></iframe>
                    </template>

                    <!-- Fallback / Default -->
                    <template x-if="!['.pdf', '.jpg', '.jpeg', '.png', '.gif', '.webp', '.doc', '.docx', '.ppt', '.pptx', '.xls', '.xlsx'].some(ext => previewUrl.toLowerCase().endsWith(ext))">
                        <div class="flex flex-col items-center justify-center h-full text-center p-8">
                             <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Preview not supported</h3>
                            <p class="text-gray-500 mt-2 mb-6 max-w-xs">This file type cannot be previewed directly. Please download the file to view it.</p>
                            <a :href="previewUrl" download class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                                Download File
                            </a>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</div>

@if($mode === 'inline')
    <!-- Empty State for Inline Mode -->
    <div x-show="!previewUrl" x-cloak
        class="h-full flex flex-col items-center justify-center bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-8 text-center text-gray-400 dark:text-gray-500 shadow-sm">
        <div class="w-20 h-20 bg-gray-50 dark:bg-gray-800/50 rounded-full flex items-center justify-center mb-4">
             <svg class="w-10 h-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Select an Application</h3>
        <p class="text-sm text-gray-500 max-w-sm mx-auto">Click on any applicant from the list to view their resume, cover letter, and details.</p>
    </div>
@endif

<style>
    [x-cloak] { display: none !important; }
</style>
