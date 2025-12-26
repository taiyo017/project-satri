<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Create App Category') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 sm:mt-1">
                    Add a new category for organizing apps
                </p>
            </div>
            <a href="{{ route('app-categories.index') }}"
                class="inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="hidden sm:inline">{{ __('Back to Categories') }}</span>
                <span class="sm:hidden">{{ __('Back') }}</span>
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-red-800 dark:text-red-300 font-semibold mb-2">Please fix the following errors:</h3>
                        <ul class="list-disc list-inside space-y-1 text-red-700 dark:text-red-400 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('app-categories.store') }}" method="POST" x-data="categoryForm()">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Category Information</h3>
                            </div>
                        </div>
                        <div class="p-6 space-y-5">
                            <div>
                                <x-input-label for="name" class="text-gray-700 dark:text-gray-300">
                                    Category Name <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="name" type="text" name="name" class="mt-2 block w-full"
                                    :value="old('name')" x-model="name" @input="generateSlug"
                                    placeholder="e.g., Productivity, Games, Education" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="slug" class="text-gray-700 dark:text-gray-300">
                                    URL Slug <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="relative mt-2">
                                    <x-text-input id="slug" type="text" name="slug" class="block w-full pr-28"
                                        :value="old('slug')" x-model="slug" placeholder="category-url-slug" required />
                                    <button type="button" @click="generateSlug"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-1.5 text-xs font-semibold text-white rounded-lg transition-all duration-200 hover:scale-105"
                                        style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                        Generate
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Description')" class="text-gray-700 dark:text-gray-300" />
                                <textarea id="description" name="description" rows="4"
                                    class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm resize-none"
                                    placeholder="Brief description of this category">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <x-input-label for="icon" :value="__('Icon Class')" class="text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="icon" name="icon" type="text" class="mt-2 block w-full"
                                        :value="old('icon')" placeholder="e.g., fa-solid fa-mobile" />
                                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                                        FontAwesome or Lucide icon class
                                    </p>
                                    <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="color" :value="__('Color')" class="text-gray-700 dark:text-gray-300" />
                                    <div class="flex gap-2 mt-2">
                                        <input type="color" id="color" name="color" value="{{ old('color', '#1363C6') }}"
                                            class="h-10 w-16 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer">
                                        <x-text-input type="text" class="flex-1" value="{{ old('color', '#1363C6') }}"
                                            placeholder="#1363C6" readonly />
                                    </div>
                                    <x-input-error :messages="$errors->get('color')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="order" :value="__('Display Order')" class="text-gray-700 dark:text-gray-300" />
                                <x-text-input id="order" name="order" type="number" class="mt-2 block w-full"
                                    :value="old('order', 0)" min="0" placeholder="0" />
                                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                                    Lower numbers appear first
                                </p>
                                <x-input-error :messages="$errors->get('order')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Settings</h3>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                <div>
                                    <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Active Status
                                    </label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        Make category visible
                                    </p>
                                </div>
                                <input type="checkbox" id="is_active" name="is_active" value="1" checked
                                    class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div class="pt-4 space-y-3">
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 text-white font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('Create Category') }}
                                </button>

                                <a href="{{ route('app-categories.index') }}"
                                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function categoryForm() {
                return {
                    name: '',
                    slug: '',
                    generateSlug() {
                        this.slug = this.name
                            .toLowerCase()
                            .replace(/[^a-z0-9]+/g, '-')
                            .replace(/^-+|-+$/g, '');
                    }
                }
            }

            document.getElementById('color').addEventListener('input', function(e) {
                this.nextElementSibling.value = e.target.value;
            });
        </script>
    @endpush
</x-app-layout>
