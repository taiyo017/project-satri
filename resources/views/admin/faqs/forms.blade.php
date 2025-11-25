{{-- Enhanced FAQ Form with Dark Mode Support --}}

{{-- Inline Styles (will be processed) --}}
@push('styles')
    <style>
        /* ============================================ */
        /* CARD COMPONENTS */
        /* ============================================ */
        .card {
            @apply bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-200;
        }

        .card:hover {
            @apply shadow-md;
        }

        .card-header {
            @apply px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50 flex items-center justify-between;
        }

        .card-title {
            @apply text-lg font-semibold text-gray-800 dark:text-gray-100;
        }

        .card-content {
            @apply p-6;
        }

        /* ============================================ */
        /* FORM ELEMENTS */
        /* ============================================ */
        .form-group {
            @apply space-y-2;
        }

        .form-label {
            @apply block text-sm font-medium text-gray-700 dark:text-gray-300;
        }

        .form-label.required::after {
            content: "*";
            @apply ml-1 text-red-500;
        }

        .form-input,
        .form-select,
        .form-textarea {
            @apply w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200;
        }

        .form-input:hover,
        .form-select:hover,
        .form-textarea:hover {
            @apply border-gray-400 dark:border-gray-500;
        }

        .form-select {
            @apply appearance-none cursor-pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.25rem;
            padding-right: 2.5rem;
        }

        .dark .form-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%9CA3AF'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        }

        .form-error {
            @apply text-red-600 dark:text-red-400 text-xs mt-1 flex items-center gap-1;
        }

        .form-helper {
            @apply text-xs text-gray-500 dark:text-gray-400 mt-1;
        }

        /* ============================================ */
        /* TOGGLE SWITCHES */
        /* ============================================ */
        .toggle-label {
            @apply relative flex items-center gap-3 cursor-pointer select-none p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200;
        }

        .toggle-input {
            @apply sr-only;
        }

        .toggle-switch {
            @apply relative w-11 h-6 bg-gray-300 dark:bg-gray-600 rounded-full transition-colors duration-200 flex-shrink-0;
        }

        .toggle-switch::after {
            content: "";
            @apply absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-sm transition-transform duration-200;
        }

        .toggle-input:checked+.toggle-switch {
            background: linear-gradient(to right, #1363C6, #0d4a99);
        }

        .toggle-input:checked+.toggle-switch::after {
            @apply transform translate-x-5;
        }

        .toggle-text {
            @apply flex flex-col text-gray-700 dark:text-gray-200;
        }

        /* ============================================ */
        /* BUTTONS */
        /* ============================================ */
        .btn-primary {
            @apply inline-flex items-center gap-2 px-6 py-3 text-white font-semibold rounded-lg hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all duration-200;
            background: linear-gradient(to right, #1363C6, #0d4a99);
        }

        .btn-secondary {
            @apply inline-flex items-center gap-2 px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200;
        }

        /* ============================================ */
        /* BADGES */
        /* ============================================ */
        .badge-secondary {
            @apply px-3 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300;
        }

        .text-primary {
            color: #1363C6;
        }
    </style>
@endpush

<div class="space-y-6">

    {{-- ============================= --}}
    {{-- BASIC INFORMATION --}}
    {{-- ============================= --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-200 hover:shadow-md">
        <div
            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Basic Information</h3>
            </div>
        </div>

        <div class="p-6 space-y-5">

            {{-- Question --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Question <span class="ml-1 text-red-500">*</span>
                </label>
                <input type="text" name="question" value="{{ old('question', $faq->question ?? '') }}"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                    placeholder="Enter the FAQ question" required>
                @error('question')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Category Dropdown --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Category <span class="ml-1 text-red-500">*</span>
                </label>
                <select name="category"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 appearance-none cursor-pointer focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                    style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E&quot;); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1.25rem; padding-right: 2.5rem;"
                    required>
                    <option value="">Select a category</option>
                    <option value="general" @selected(old('category', $faq->category ?? '') === 'general')>General</option>
                    <option value="technical" @selected(old('category', $faq->category ?? '') === 'technical')>Technical</option>
                    <option value="billing" @selected(old('category', $faq->category ?? '') === 'billing')>Billing & Payment</option>
                    <option value="account" @selected(old('category', $faq->category ?? '') === 'account')>Account Management</option>
                    <option value="support" @selected(old('category', $faq->category ?? '') === 'support')>Support</option>
                    <option value="features" @selected(old('category', $faq->category ?? '') === 'features')>Features</option>
                    <option value="security" @selected(old('category', $faq->category ?? '') === 'security')>Security & Privacy</option>
                    <option value="other" @selected(old('category', $faq->category ?? '') === 'other')>Other</option>
                </select>
                @error('category')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Answer --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Answer <span class="ml-1 text-red-500">*</span>
                </label>
                <textarea name="answer" rows="6"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                    placeholder="Provide a detailed answer to the question" required>{{ old('answer', $faq->answer ?? '') }}</textarea>
                @error('answer')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">You can use markdown for formatting</p>
            </div>

        </div>
    </div>

    {{-- ============================= --}}
    {{-- SEO META INFORMATION --}}
    {{-- ============================= --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-200 hover:shadow-md">
        <div
            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">SEO Information</h3>
            </div>
            <span
                class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">Optional</span>
        </div>

        <div class="p-6 space-y-5">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $faq->meta_title ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                        placeholder="SEO friendly title">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Keywords</label>
                    <input type="text" name="meta_keywords"
                        value="{{ old('meta_keywords', $faq->meta_keywords ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                        placeholder="keyword1, keyword2, keyword3">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Description</label>
                <textarea name="meta_description" rows="3"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                    placeholder="Brief description for search engines (150-160 characters)">{{ old('meta_description', $faq->meta_description ?? '') }}</textarea>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Recommended length: 150-160 characters</p>
            </div>

        </div>
    </div>

    {{-- ============================= --}}
    {{-- SETTINGS --}}
    {{-- ============================= --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-200 hover:shadow-md">
        <div
            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Settings</h3>
            </div>
        </div>

        <div class="p-6">
            <div class="flex flex-wrap gap-6">

                <label
                    class="relative flex items-center gap-3 cursor-pointer select-none p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200">
                    <input type="checkbox" name="status" value="1" class="sr-only toggle-checkbox"
                        @checked(old('status', $faq->status ?? true))>
                    <div
                        class="toggle-box relative w-11 h-6 bg-gray-300 dark:bg-gray-600 rounded-full transition-colors duration-200 flex-shrink-0">
                        <div
                            class="toggle-circle absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-sm transition-transform duration-200">
                        </div>
                    </div>
                    <span class="flex flex-col text-gray-700 dark:text-gray-200">
                        <span class="font-medium">Active Status</span>
                        <span class="text-xs opacity-75">Make FAQ visible</span>
                    </span>
                </label>

            </div>
        </div>
    </div>

    {{-- Submit Button --}}
    <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('faqs.index') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
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
        // Toggle switch functionality
        document.querySelectorAll('.toggle-checkbox').forEach(checkbox => {
            const updateToggle = () => {
                const toggleBox = checkbox.nextElementSibling;
                const toggleCircle = toggleBox.querySelector('.toggle-circle');

                if (checkbox.checked) {
                    toggleBox.style.background = 'linear-gradient(to right, #1363C6, #0d4a99)';
                    toggleCircle.style.transform = 'translateX(1.25rem)';
                } else {
                    toggleBox.style.background = '';
                    toggleCircle.style.transform = '';
                }
            };

            updateToggle();
            checkbox.addEventListener('change', updateToggle);
        });
    });
</script>
