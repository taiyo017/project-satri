<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Create New Service') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Add a new service to showcase on your website
                </p>
            </div>
            <a href="{{ route('services.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to Services') }}
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
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
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ __('Basic Information') }}
                            </h3>
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

                    {{-- SEO & Social Media Settings --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50 flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                {{ __('SEO & Social Media') }}
                            </h3>
                            <span
                                class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">Optional</span>
                        </div>
                        <div class="p-6 space-y-6">

                            {{-- Meta Fields --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="md:col-span-2">
                                    <x-input-label for="meta_title" :value="__('Meta Title')"
                                        class="text-gray-700 dark:text-gray-300" />
                                    <x-text-input id="meta_title" type="text" name="meta_title"
                                        class="mt-2 block w-full" :value="old('meta_title')" maxlength="60"
                                        placeholder="SEO optimized title (50-60 characters)" />
                                    <x-input-error :messages="$errors->get('meta_title')" class="mt-2" />
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="meta_description" :value="__('Meta Description')"
                                        class="text-gray-700 dark:text-gray-300" />
                                    <textarea id="meta_description" name="meta_description" rows="3" maxlength="160"
                                        class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm resize-none"
                                        placeholder="Brief description for search engines (120-160 characters)">{{ old('meta_description') }}</textarea>
                                    <x-input-error :messages="$errors->get('meta_description')" class="mt-2" />
                                </div>
                            </div>

                            {{-- Open Graph Section --}}
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <h4
                                    class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                                    <svg class="w-4 h-4" style="color: #1363C6;" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                    Open Graph (Facebook, LinkedIn)
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <x-input-label for="og_title" :value="__('OG Title')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <x-text-input id="og_title" type="text" name="og_title"
                                            class="mt-2 block w-full" :value="old('og_title')"
                                            placeholder="Social media title" />
                                        <x-input-error :messages="$errors->get('og_title')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="og_image" :value="__('OG Image')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <input type="file" id="og_image" name="og_image" accept="image/*"
                                            class="mt-2 block w-full text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-200 hover:file:bg-gray-200 dark:hover:file:bg-gray-600 file:cursor-pointer file:transition-colors" />
                                        <x-input-error :messages="$errors->get('og_image')" class="mt-2" />
                                    </div>

                                    <div class="md:col-span-2">
                                        <x-input-label for="og_description" :value="__('OG Description')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <textarea id="og_description" name="og_description" rows="2"
                                            class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm resize-none"
                                            placeholder="Description for social media sharing">{{ old('og_description') }}</textarea>
                                        <x-input-error :messages="$errors->get('og_description')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            {{-- Twitter Card Section --}}
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <h4
                                    class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                                    <svg class="w-4 h-4" style="color: #1363C6;" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                    </svg>
                                    Twitter Card
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <x-input-label for="twitter_title" :value="__('Twitter Title')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <x-text-input id="twitter_title" type="text" name="twitter_title"
                                            class="mt-2 block w-full" :value="old('twitter_title')"
                                            placeholder="Twitter card title" />
                                        <x-input-error :messages="$errors->get('twitter_title')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="twitter_image" :value="__('Twitter Image')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <input type="file" id="twitter_image" name="twitter_image"
                                            accept="image/*"
                                            class="mt-2 block w-full text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-200 hover:file:bg-gray-200 dark:hover:file:bg-gray-600 file:cursor-pointer file:transition-colors" />
                                        <x-input-error :messages="$errors->get('twitter_image')" class="mt-2" />
                                    </div>

                                    <div class="md:col-span-2">
                                        <x-input-label for="twitter_description" :value="__('Twitter Description')"
                                            class="text-gray-700 dark:text-gray-300" />
                                        <textarea id="twitter_description" name="twitter_description" rows="2"
                                            class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm resize-none"
                                            placeholder="Description for Twitter sharing">{{ old('twitter_description') }}</textarea>
                                        <x-input-error :messages="$errors->get('twitter_description')" class="mt-2" />
                                    </div>
                                </div>
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
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Publishing
                            </h3>
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

                            <div class="pt-4 space-y-3">
                                <x-primary-button type="submit" class="w-full justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('Create Service') }}
                                </x-primary-button>

                                <x-secondary-button type="button"
                                    onclick="window.location='{{ route('services.index') }}'"
                                    class="w-full justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Cancel
                                </x-secondary-button>
                            </div>
                        </div>
                    </div>

                    {{-- Featured Image --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Featured Image
                            </h3>
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
                                        Add keywords to help with SEO ranking
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" style="color: #1363C6;"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Upload high-quality images for better engagement
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" style="color: #1363C6;"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Use featured option to highlight important services
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>

    <script>
        function serviceForm() {
            return {
                title: '{{ old('title') }}',
                slug: '{{ old('slug') }}',
                generateSlug() {
                    if (this.title) {
                        this.slug = this.title
                            .toLowerCase()
                            .replace(/[^\w\s-]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-')
                            .trim();
                    }
                }
            }
        }

        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const placeholder = document.getElementById('image-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
