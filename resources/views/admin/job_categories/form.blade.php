<div class="space-y-6">
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-200 hover:shadow-md">
        <div
            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Category Information</h3>
            </div>
        </div>

        <div class="p-6 space-y-5">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Category Name <span class="ml-1 text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                    placeholder="e.g., Full-time, Part-time, Internship" required>
                @error('name')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Slug --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Slug
                </label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200 font-mono text-sm"
                    placeholder="auto-generated-from-name">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Optional. Will be auto-generated from category name if left blank
                </p>
                @error('slug')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Description
                </label>
                <textarea name="description" rows="4"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                    placeholder="Brief description of this job category">{{ old('description', $category->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>
    </div>

    {{-- Submit Buttons --}}
    <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('job-categories.index') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Cancel
        </a>
        <button type="submit"
            class="inline-flex items-center gap-2 px-6 py-3 text-white font-semibold rounded-lg hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all duration-200"
            style="background: linear-gradient(to right, #1363C6, #0d4a99);">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ $button }}
        </button>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-generate slug from name
        const nameInput = document.querySelector('input[name="name"]');
        const slugInput = document.querySelector('input[name="slug"]');

        if (nameInput && slugInput && !slugInput.value) {
            nameInput.addEventListener('input', function() {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/--+/g, '-')
                    .trim();
                slugInput.value = slug;
            });
        }
    });
</script>
