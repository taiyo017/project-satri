<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Create New Service') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 sm:mt-1">
                    Add a new service to showcase on your website
                </p>
            </div>
            <a href="{{ route('services.index') }}"
                class="inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="hidden sm:inline">{{ __('Back to Services') }}</span>
                <span class="sm:hidden">{{ __('Back') }}</span>
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Flash Messages --}}
        @foreach (['success', 'error'] as $msg)
            @if (session($msg))
                <div class="mb-4">
                    <x-alert type="{{ $msg }}" :message="session($msg)" dismissible="true" />
                </div>
            @endif
        @endforeach

        {{-- Error Messages --}}
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
                        <h3 class="text-red-800 dark:text-red-300 font-semibold mb-2">Please fix the following
                            errors:</h3>
                        <ul class="list-disc list-inside space-y-1 text-red-700 dark:text-red-400 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data"
            x-data="serviceForm()">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content Area --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Basic Information --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                    {{ __('Basic Information') }}
                                </h3>
                            </div>
                        </div>
                        <div class="p-6 space-y-5">

                            {{-- Title --}}
                            <div>
                                <x-input-label for="title" class="text-gray-700 dark:text-gray-300">
                                    Service Title <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="title" type="text" name="title" class="mt-2 block w-full"
                                    :value="old('title')" x-model="title" @input="generateSlug"
                                    placeholder="Enter service title" required />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            {{-- Slug --}}
                            <div>
                                <x-input-label for="slug" class="text-gray-700 dark:text-gray-300">
                                    URL Slug <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="relative mt-2">
                                    <x-text-input id="slug" type="text" name="slug"
                                        class="block w-full pr-28" :value="old('slug')" x-model="slug"
                                        placeholder="service-url-slug" required />
                                    <button type="button" @click="generateSlug"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-1.5 text-xs font-semibold text-white rounded-lg transition-all duration-200 hover:scale-105"
                                        style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                        Generate
                                    </button>
                                </div>
                                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                                    Unique URL identifier (e.g., web-development)
                                </p>
                                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                            </div>

                            {{-- Short Description --}}
                            <div>
                                <x-input-label for="short_description" :value="__('Short Description')"
                                    class="text-gray-700 dark:text-gray-300" />
                                <textarea id="short_description" name="short_description" rows="3"
                                    class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm resize-none"
                                    placeholder="A brief summary that will appear in listings">{{ old('short_description') }}</textarea>
                                <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
                            </div>

                            {{-- Description --}}
                            <div>
                                <x-input-label for="description" :value="__('Full Description')"
                                    class="text-gray-700 dark:text-gray-300" />
                                <textarea id="description" name="description" rows="12"
                                    class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm resize-y"
                                    placeholder="Provide detailed information about this service">{{ old('description') }}</textarea>
                                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                                    Supports HTML and Markdown formatting
                                </p>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            {{-- Icon --}}
                            <div>
                                <x-input-label for="icon" :value="__('Icon (optional)')"
                                    class="text-gray-700 dark:text-gray-300" />
                                <x-text-input id="icon" name="icon" type="text" class="mt-2 block w-full"
                                    :value="old('icon')" placeholder="e.g., fa-solid fa-code, lucide-laptop" />
                                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                                    FontAwesome or Lucide icon class name
                                </p>
                                <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">

                    {{-- Publishing Options --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Publishing</h3>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <x-input-label for="status" :value="__('Status')"
                                    class="text-gray-700 dark:text-gray-300" />
                                <select id="status" name="status"
                                    class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm">
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>
                                        Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                                        Published
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            {{-- Featured Toggle --}}
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                <div>
                                    <label for="is_featured" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Featured Service
                                    </label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        Show in featured sections
                                    </p>
                                </div>
                                <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                    {{ old('is_featured') ? 'checked' : '' }}
                                    class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            </div>

                            <div class="pt-4 space-y-3">
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 text-white font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('Create Service') }}
                                </button>

                                <a href="{{ route('services.index') }}"
                                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Featured Image --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Featured Image</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-col items-center">
                                <div class="mb-4 w-full">
                                    <div id="image-placeholder"
                                        class="w-full h-48 flex items-center justify-center bg-gray-100 dark:bg-gray-900 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 transition-colors hover:border-blue-500 dark:hover:border-blue-500">
                                        <div class="text-center">
                                            <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-2"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-gray-500 dark:text-gray-400 text-sm">No image
                                                selected</span>
                                        </div>
                                    </div>
                                    <img id="image-preview"
                                        class="hidden w-full h-48 object-cover rounded-xl border-2 border-gray-200 dark:border-gray-700"
                                        alt="Featured Image Preview">
                                </div>

                                <div class="w-full">
                                    <label for="image"
                                        class="cursor-pointer w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-semibold rounded-lg transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        <span>Choose Image</span>
                                    </label>
                                    <input type="file" id="image" name="image" class="hidden"
                                        accept="image/*" onchange="previewImage(this)">
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 text-center">
                                        JPG, PNG, WebP up to 5MB
                                    </p>
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Tips --}}
                    <div class="rounded-xl border p-6"
                        style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.05) 0%, rgba(13, 74, 153, 0.1) 100%); border-color: rgba(19, 99, 198, 0.2);">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center"
                                style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-100 mb-3">Quick
                                    Tips</h4>
                                <ul class="text-xs text-gray-600 dark:text-gray-400 space-y-2">
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" style="color: #1363C6;"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Use clear, descriptive titles for better visibility
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" style="color: #1363C6;"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Add high-quality images to attract attention
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" style="color: #1363C6;"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Keep descriptions concise and informative
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function serviceForm() {
                return {
                    title: '',
                    slug: '',
                    generateSlug() {
                        this.slug = this.title
                            .toLowerCase()
                            .replace(/[^a-z0-9]+/g, '-')
                            .replace(/^-+|-+$/g, '');
                    }
                }
            }

            function previewImage(input) {
                const preview = document.getElementById('image-preview');
                const placeholder = document.getElementById('image-placeholder');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush

</x-app-layout>
