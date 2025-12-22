<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Create Subscription Topic') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Add a new email subscription topic for your subscribers
                </p>
            </div>

            <a href="{{ route('admin.subscription-topics.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Topics
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Error Summary -->
        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-red-800 dark:text-red-300 font-semibold mb-2">Please fix the following errors:
                        </h3>
                        <ul class="list-disc list-inside space-y-1 text-red-700 dark:text-red-400 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.subscription-topics.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Topic Information -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                <div
                    class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Topic Information</h3>
                    </div>
                </div>

                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Topic Name
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                    class="pl-10 w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors"
                                    placeholder="e.g. Job Postings, Course Launches">
                            </div>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                                A clear, descriptive name for this subscription topic
                            </p>
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Slug
                                <span class="text-xs font-normal text-gray-500">(Optional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                </div>
                                <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                    class="pl-10 w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors"
                                    placeholder="job-postings">
                            </div>
                            @error('slug')
                                <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                                Leave empty to auto-generate from name
                            </p>
                        </div>

                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-colors resize-none"
                            placeholder="Describe what subscribers will receive when they subscribe to this topic...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                            Help subscribers understand what content they'll receive
                        </p>
                    </div>

                    <!-- Active Status -->
                    <div
                        class="flex items-start p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center h-5">
                            <input id="is_active" name="is_active" type="checkbox" value="1" checked
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_active" class="font-semibold text-gray-700 dark:text-gray-300">
                                Active Topic
                            </label>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                When active, users can subscribe to this topic. Inactive topics won't appear in
                                subscription forms.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div
                class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border border-blue-200 dark:border-blue-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100">Preview</h3>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-sm text-blue-700 dark:text-blue-300 mb-4">
                        This is how your topic will appear to subscribers:
                    </p>
                    <div
                        class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                        <div class="flex items-start gap-3">
                            <div class="flex items-center h-5 mt-0.5">
                                <input type="checkbox" checked disabled
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 dark:text-white" id="preview-name">
                                    Topic Name
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1" id="preview-description">
                                    Topic description will appear here
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.subscription-topics.index') }}"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancel
                </a>

                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 text-white font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-[0.98]"
                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Create Topic
                </button>
            </div>
        </form>
    </div>

    <!-- Auto-generate slug and live preview -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const descriptionInput = document.getElementById('description');
            const previewName = document.getElementById('preview-name');
            const previewDescription = document.getElementById('preview-description');

            // Auto-generate slug from name
            if (nameInput && slugInput) {
                nameInput.addEventListener('input', function() {
                    // Only auto-generate if slug is empty or was auto-generated
                    if (!slugInput.dataset.manuallyEdited) {
                        const slug = this.value
                            .toLowerCase()
                            .replace(/[^\w\s-]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-')
                            .trim();
                        slugInput.value = slug;
                    }

                    // Update preview
                    previewName.textContent = this.value || 'Topic Name';
                });

                // Mark slug as manually edited if user types in it
                slugInput.addEventListener('input', function() {
                    slugInput.dataset.manuallyEdited = 'true';
                });
            }

            // Live preview for description
            if (descriptionInput && previewDescription) {
                descriptionInput.addEventListener('input', function() {
                    previewDescription.textContent = this.value || 'Topic description will appear here';
                });
            }
        });
    </script>
</x-app-layout>
