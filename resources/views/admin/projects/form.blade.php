<div class="space-y-6" x-data="projectForm()">

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
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Project Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title"
                            value="{{ old('title', $project->title ?? '') }}" x-model="title" @input="generateSlug"
                            class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow"
                            placeholder="Enter project title" required>
                        @error('title')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            URL Slug <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="slug" name="slug"
                                value="{{ old('slug', $project->slug ?? '') }}" x-model="slug"
                                class="w-full px-4 py-2.5 pr-28 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow"
                                placeholder="project-url-slug" required>
                            <button type="button" @click="generateSlug"
                                class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-1.5 text-xs font-semibold text-white rounded-lg transition-all duration-200 hover:scale-105"
                                style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                Generate
                            </button>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                            Unique URL identifier (e.g., e-commerce-platform)
                        </p>
                        @error('slug')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Client --}}
                        <div>
                            <label for="client"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Client Name
                            </label>
                            <input type="text" id="client" name="client"
                                value="{{ old('client', $project->client ?? '') }}"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow"
                                placeholder="e.g., Acme Corporation">
                            @error('client')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Category --}}
                        <div>
                            <label for="category"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Category
                            </label>
                            <input type="text" id="category" name="category"
                                value="{{ old('category', $project->category ?? '') }}"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow"
                                placeholder="e.g., Web Design, Mobile App">
                            @error('category')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Project URL --}}
                        <div>
                            <label for="project_url"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Project URL
                            </label>
                            <input type="url" id="project_url" name="project_url"
                                value="{{ old('project_url', $project->project_url ?? '') }}"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow"
                                placeholder="https://example.com">
                            @error('project_url')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tech Stack --}}
                        <div>
                            <label for="tech_stack"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tech Stack
                            </label>
                            <input type="text" id="tech_stack" name="tech_stack"
                                value="{{ old('tech_stack', $project->tech_stack ?? '') }}"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow"
                                placeholder="Laravel, Vue.js, Tailwind CSS">
                            <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                                Comma-separated technologies
                            </p>
                            @error('tech_stack')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Project Description
                        </label>
                        <textarea id="description" name="description" rows="8"
                            class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow resize-y"
                            placeholder="Describe the project, its goals, challenges, and outcomes...">{{ old('description', $project->description ?? '') }}</textarea>
                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                            Supports HTML and Markdown formatting
                        </p>
                        @error('description')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
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
                            <label for="meta_title"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Meta Title
                            </label>
                            <input type="text" id="meta_title" name="meta_title"
                                value="{{ old('meta_title', $project->meta_title ?? '') }}" maxlength="60"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow"
                                placeholder="SEO optimized title (50-60 characters)">
                            @error('meta_title')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="meta_description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Meta Description
                            </label>
                            <textarea id="meta_description" name="meta_description" rows="3" maxlength="160"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow resize-none"
                                placeholder="Brief description for search engines (120-160 characters)">{{ old('meta_description', $project->meta_description ?? '') }}</textarea>
                            @error('meta_description')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="meta_keywords"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Meta Keywords
                            </label>
                            <input type="text" id="meta_keywords" name="meta_keywords"
                                value="{{ old('meta_keywords', $project->meta_keywords ?? '') }}"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow"
                                placeholder="keyword1, keyword2, keyword3">
                            @error('meta_keywords')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Open Graph Section --}}
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4
                            class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" style="color: #1363C6;" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                            Open Graph (Facebook, LinkedIn)
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="og_title"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    OG Title
                                </label>
                                <input type="text" id="og_title" name="og_title"
                                    value="{{ old('og_title', $project->og_title ?? '') }}"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow"
                                    placeholder="Social media title">
                                @error('og_title')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="og_image"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    OG Image
                                </label>
                                <input type="file" id="og_image" name="og_image" accept="image/*"
                                    class="block w-full text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-200 hover:file:bg-gray-200 dark:hover:file:bg-gray-600 file:cursor-pointer file:transition-colors">
                                @if (isset($project) && $project->og_image)
                                    <img src="{{ asset('storage/' . $project->og_image) }}"
                                        class="mt-2 h-20 rounded-lg border-2 border-gray-200 dark:border-gray-700 object-cover">
                                @endif
                                @error('og_image')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="og_description"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    OG Description
                                </label>
                                <textarea id="og_description" name="og_description" rows="2"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow resize-none"
                                    placeholder="Description for social media sharing">{{ old('og_description', $project->og_description ?? '') }}</textarea>
                                @error('og_description')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Twitter Card Section --}}
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4
                            class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" style="color: #1363C6;" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                            Twitter Card
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="twitter_title"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Twitter Title
                                </label>
                                <input type="text" id="twitter_title" name="twitter_title"
                                    value="{{ old('twitter_title', $project->twitter_title ?? '') }}"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow"
                                    placeholder="Twitter card title">
                                @error('twitter_title')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="twitter_image"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Twitter Image
                                </label>
                                <input type="file" id="twitter_image" name="twitter_image" accept="image/*"
                                    class="block w-full text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-200 hover:file:bg-gray-200 dark:hover:file:bg-gray-600 file:cursor-pointer file:transition-colors">
                                @if (isset($project) && $project->twitter_image)
                                    <img src="{{ asset('storage/' . $project->twitter_image) }}"
                                        class="mt-2 h-20 rounded-lg border-2 border-gray-200 dark:border-gray-700 object-cover">
                                @endif
                                @error('twitter_image')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="twitter_description"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Twitter Description
                                </label>
                                <textarea id="twitter_description" name="twitter_description" rows="2"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow resize-none"
                                    placeholder="Description for Twitter sharing">{{ old('twitter_description', $project->twitter_description ?? '') }}</textarea>
                                @error('twitter_description')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Status & Settings --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 space-y-4">
                    {{-- Submit Button --}}
                    <x-primary-button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-6 py-3 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200"
                        style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        {{ $button }}
                    </x-primary-button>
                </div>
            </div>

            {{-- Main Project Image --}}
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
                        Project Image
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flex flex-col items-center">
                        <div class="mb-4 w-full">
                            @if (isset($project) && $project->image)
                                <img src="{{ asset('storage/' . $project->image) }}" id="existing-image"
                                    class="w-full h-48 object-cover rounded-xl border-2 border-gray-200 dark:border-gray-700"
                                    alt="Current Project Image">
                            @else
                                <div id="image-placeholder"
                                    class="w-full h-48 flex items-center justify-center bg-gray-100 dark:bg-gray-900 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 transition-colors hover:border-blue-500 dark:hover:border-blue-500">
                                    <div class="text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-2"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">No image selected</span>
                                    </div>
                                </div>
                            @endif
                            <img id="image-preview"
                                class="hidden w-full h-48 object-cover rounded-xl border-2 border-gray-200 dark:border-gray-700"
                                alt="Image Preview">
                        </div>

                        <div class="w-full">
                            <label for="image"
                                class="cursor-pointer w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-semibold rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <span>Choose Image</span>
                            </label>
                            <input type="file" id="image" name="image" class="hidden" accept="image/*"
                                onchange="previewImage(this)">
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 text-center">
                                JPG, PNG, WebP up to 10MB • Recommended: 1200x800px
                            </p>
                            @error('image')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
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
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-100 mb-3">Quick Tips</h4>
                        <ul class="text-xs text-gray-600 dark:text-gray-400 space-y-2">
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" style="color: #1363C6;" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Use high-quality images to showcase your work
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" style="color: #1363C6;" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Include tech stack to highlight your skills
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" style="color: #1363C6;" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Add project URL to let visitors explore live work
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" style="color: #1363C6;" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Mark best projects as featured for visibility
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function projectForm() {
        return {
            title: '{{ old('title', $project->title ?? '') }}',
            slug: '{{ old('slug', $project->slug ?? '') }}',
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
        const existingImage = document.getElementById('existing-image');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
                if (existingImage) existingImage.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
