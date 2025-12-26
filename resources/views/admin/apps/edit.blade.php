<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Edit App') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 sm:mt-1">
                    Update: {{ $app->name }}
                </p>
            </div>
            <a href="{{ route('apps.show', $app) }}"
                class="inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="hidden sm:inline">{{ __('Back to App') }}</span>
                <span class="sm:hidden">{{ __('Back') }}</span>
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <x-alert type="success" :message="session('success')" dismissible="true" />
        @endif

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

        <form action="{{ route('apps.update', $app) }}" method="POST" enctype="multipart/form-data" x-data="appForm()">
            @csrf
            @method('PUT')

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
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">App Information</h3>
                            </div>
                        </div>
                        <div class="p-6 space-y-5">
                            <div>
                                <x-input-label for="name" class="text-gray-700 dark:text-gray-300">
                                    App Name <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="name" type="text" name="name" class="mt-2 block w-full"
                                    :value="old('name', $app->name)" x-model="name" @input="generateSlug" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="slug" class="text-gray-700 dark:text-gray-300">
                                    URL Slug <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="relative mt-2">
                                    <x-text-input id="slug" type="text" name="slug" class="block w-full pr-28"
                                        :value="old('slug', $app->slug)" x-model="slug" required />
                                    <button type="button" @click="generateSlug"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-1.5 text-xs font-semibold text-white rounded-lg transition-all duration-200 hover:scale-105"
                                        style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                        Generate
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="app_category_id" :value="__('Category')" class="text-gray-700 dark:text-gray-300" />
                                <select id="app_category_id" name="app_category_id"
                                    class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('app_category_id', $app->app_category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('app_category_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="package_name" :value="__('Package Name')" class="text-gray-700 dark:text-gray-300" />
                                <x-text-input id="package_name" name="package_name" type="text" class="mt-2 block w-full"
                                    :value="old('package_name', $app->package_name)" />
                                <x-input-error :messages="$errors->get('package_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="short_description" :value="__('Short Description')" class="text-gray-700 dark:text-gray-300" />
                                <textarea id="short_description" name="short_description" rows="2"
                                    class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm resize-none">{{ old('short_description', $app->short_description) }}</textarea>
                                <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Full Description')" class="text-gray-700 dark:text-gray-300" />
                                <textarea id="description" name="description" rows="8"
                                    class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm resize-y">{{ old('description', $app->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
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
                            <div>
                                <x-input-label for="status" :value="__('Status')" class="text-gray-700 dark:text-gray-300" />
                                <select id="status" name="status"
                                    class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm">
                                    <option value="draft" {{ old('status', $app->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="active" {{ old('status', $app->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $app->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                <div>
                                    <label for="is_featured" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Featured App
                                    </label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        Show in featured section
                                    </p>
                                </div>
                                <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                    {{ old('is_featured', $app->is_featured) ? 'checked' : '' }}
                                    class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div class="pt-4 space-y-3">
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 text-white font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('Update App') }}
                                </button>

                                <a href="{{ route('apps.show', $app) }}"
                                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">App Icon</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-col items-center">
                                <div class="mb-4 w-full">
                                    @if ($app->icon)
                                        <img src="{{ asset('storage/' . $app->icon) }}" alt="{{ $app->name }}"
                                            id="icon-preview" class="w-full h-48 object-cover rounded-xl border-2 border-gray-200 dark:border-gray-700">
                                        <div id="icon-placeholder" class="hidden"></div>
                                    @else
                                        <div id="icon-placeholder"
                                            class="w-full h-48 flex items-center justify-center bg-gray-100 dark:bg-gray-900 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600">
                                            <div class="text-center">
                                                <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="text-gray-500 dark:text-gray-400 text-sm">No icon</span>
                                            </div>
                                        </div>
                                        <img id="icon-preview" class="hidden w-full h-48 object-cover rounded-xl border-2 border-gray-200 dark:border-gray-700" alt="Icon Preview">
                                    @endif
                                </div>

                                <div class="w-full">
                                    <label for="icon"
                                        class="cursor-pointer w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-semibold rounded-lg transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        <span>Change Icon</span>
                                    </label>
                                    <input type="file" id="icon" name="icon" class="hidden" accept="image/*" onchange="previewIcon(this)">
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 text-center">
                                        PNG, JPG up to 2MB
                                    </p>
                                    <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function appForm() {
                return {
                    name: '{{ old('name', $app->name) }}',
                    slug: '{{ old('slug', $app->slug) }}',
                    generateSlug() {
                        this.slug = this.name
                            .toLowerCase()
                            .replace(/[^a-z0-9]+/g, '-')
                            .replace(/^-+|-+$/g, '');
                    }
                }
            }

            function previewIcon(input) {
                const preview = document.getElementById('icon-preview');
                const placeholder = document.getElementById('icon-placeholder');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        if (placeholder) placeholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush
</x-app-layout>
