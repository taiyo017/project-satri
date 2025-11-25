{{-- Enhanced Course Form with Dark Mode Support --}}

@php
    $courseSyllabuses = $course->syllabuses ?? collect();
@endphp

<div class="space-y-6">

    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-200 hover:shadow-md">
        <div
            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Basic Information</h3>
            </div>
        </div>

        <div class="p-6 space-y-5">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Category --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Category <span class="ml-1 text-red-500">*</span>
                    </label>
                    <select name="category_id"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 appearance-none cursor-pointer focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                        style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E&quot;); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1.25rem; padding-right: 2.5rem;"
                        required>
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $course->category_id ?? '') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
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

                {{-- Title --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Course Title <span class="ml-1 text-red-500">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title', $course->title ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                        placeholder="e.g., Complete Web Development Course" required>
                    @error('title')
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Slug --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Slug
                    </label>
                    <input type="text" name="slug" value="{{ old('slug', $course->slug ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200 font-mono text-sm"
                        placeholder="auto-generated-from-title">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Auto-generated from title if left blank
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

                {{-- Short Description --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Short Description
                    </label>
                    <input type="text" name="short_description"
                        value="{{ old('short_description', $course->short_description ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                        placeholder="Brief overview of the course">
                    @error('short_description')
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

            {{-- Description --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Full Description
                </label>
                <textarea name="description" rows="5"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                    placeholder="Detailed description of what students will learn...">{{ old('description', $course->description ?? '') }}</textarea>
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Price --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Price (NPR) <span class="ml-1 text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 font-semibold">Rs.</span>
                        <input type="number" name="price" step="0.01"
                            value="{{ old('price', $course->price ?? 0) }}"
                            class="w-full pl-8 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                            placeholder="99.99" required>
                    </div>
                    @error('price')
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

                {{-- Duration --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Duration
                    </label>
                    <input type="text" name="duration" value="{{ old('duration', $course->duration ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                        placeholder="e.g., 8 weeks, 40 hours">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Enter course duration (e.g., "6 weeks" or "24 hours")
                    </p>
                    @error('duration')
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

            {{-- Course Image --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Course Image
                </label>
                <div
                    class="flex items-start gap-4 p-4 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-blue-400 dark:hover:border-blue-500 transition-colors">
                    @if (isset($course) && $course->image)
                        <img src="{{ asset('storage/' . $course->image) }}"
                            class="w-32 h-32 rounded-lg object-cover border-2 border-gray-200 dark:border-gray-700 shadow-sm">
                    @endif
                    <div class="flex-1">
                        <input type="file" name="image" accept="image/*"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400 transition-colors duration-200">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            Recommended size: 1200x630px. Max file size: 2MB
                        </p>
                    </div>
                </div>
                @error('image')
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

    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-200 hover:shadow-md">
        <div
            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
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

                {{-- Meta Title --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Title</label>
                    <input type="text" name="meta_title"
                        value="{{ old('meta_title', $course->meta_title ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                        placeholder="SEO optimized title">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Recommended: 50-60 characters</p>
                </div>

                {{-- Meta Keywords --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Keywords</label>
                    <input type="text" name="meta_keywords"
                        value="{{ old('meta_keywords', $course->meta_keywords ?? '') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                        placeholder="web development, programming, coding">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Separate with commas</p>
                </div>

            </div>

            {{-- Meta Description --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Description</label>
                <textarea name="meta_description" rows="3"
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                    placeholder="Brief description for search engines">{{ old('meta_description', $course->meta_description ?? '') }}</textarea>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Recommended: 150-160 characters</p>
            </div>

        </div>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-200 hover:shadow-md">
        <div
            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Course Syllabus</h3>
            </div>
            <button type="button" id="add-syllabus"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white rounded-lg hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all duration-200"
                style="background: linear-gradient(to right, #1363C6, #0d4a99);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Topic
            </button>
        </div>

        <div class="p-6">
            <div id="syllabus-wrapper" class="space-y-4">
                @php
                    $syllabuses = old('syllabus', $course->syllabus ?? collect());
                @endphp


                @if (count($syllabuses) === 0)
                    <div class="text-center py-8">
                        <div
                            class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center bg-gray-100 dark:bg-gray-700">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">No syllabus topics yet. Click "Add Topic"
                            to get started.</p>
                    </div>
                @endif

                @foreach ($syllabuses as $i => $syllabus)
                    @php
                        $title = is_array($syllabus) ? $syllabus['title'] ?? '' : $syllabus->title ?? '';
                        $content = is_array($syllabus) ? $syllabus['content'] ?? '' : $syllabus->content ?? '';
                        $filePath = is_array($syllabus) ? $syllabus['file_path'] ?? null : $syllabus->file_path ?? null;
                    @endphp

                    <div
                        class="syllabus-item border-2 border-gray-200 dark:border-gray-700 rounded-lg p-5 bg-gray-50 dark:bg-gray-700/30 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-200">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold text-white"
                                    style="background: linear-gradient(to right, #1363C6, #0d4a99);">
                                    {{ $i + 1 }}
                                </div>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Topic
                                    {{ $i + 1 }}</span>
                            </div>
                            <button type="button"
                                class="remove-syllabus p-1.5 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                title="Remove Topic">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <input type="text" name="syllabus[{{ $i }}][title]"
                                    placeholder="Topic title (e.g., Introduction to HTML)"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"
                                    value="{{ $title }}">
                            </div>

                            <div>
                                <textarea name="syllabus[{{ $i }}][content]" placeholder="Topic content and learning objectives..."
                                    rows="3"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200">{{ $content }}</textarea>
                            </div>

                            <div class="flex flex-col gap-2">
                                <!-- File input -->
                                <div>
                                    <input type="file" name="syllabus[{{ $i }}][file_path]"
                                        accept=".pdf,.doc,.docx,.ppt,.pptx"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 dark:file:bg-purple-900/30 dark:file:text-purple-400 transition-colors duration-200">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        Optional: Attach study materials (PDF, DOC, PPT)
                                    </p>
                                </div>

                                <!-- File preview if exists -->
                                @if ($filePath)
                                    @php
                                        $fileName = basename($filePath);
                                        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                                    @endphp
                                    <div
                                        class="flex items-center justify-between p-3 bg-gray-100 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <!-- File type icon -->
                                            <div
                                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-lg font-bold">
                                                {{ strtoupper($fileExt) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span
                                                    class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate max-w-xs">{{ $fileName }}</span>
                                                <span
                                                    class="text-xs text-gray-500 dark:text-gray-400">{{ $fileExt }}
                                                    file</span>
                                            </div>
                                        </div>
                                        <a href="{{ asset('storage/' . $filePath) }}" target="_blank"
                                            class="px-3 py-1.5 text-xs font-medium text-white bg-blue-600 dark:bg-blue-500 rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors">
                                            View / Download
                                        </a>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
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
                        @checked(old('status', $course->status ?? true))>
                    <div
                        class="toggle-box relative w-11 h-6 bg-gray-300 dark:bg-gray-600 rounded-full transition-colors duration-200 flex-shrink-0">
                        <div
                            class="toggle-circle absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-sm transition-transform duration-200">
                        </div>
                    </div>
                    <span class="flex flex-col text-gray-700 dark:text-gray-200">
                        <span class="font-medium">Active Status</span>
                        <span class="text-xs opacity-75">Make course visible</span>
                    </span>
                </label>

            </div>
        </div>
    </div>

    {{-- Submit Buttons --}}
    <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('courses.index') }}"
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
        let counter = {{ count($syllabuses) }};

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

        // Auto-generate slug from title
        const titleInput = document.querySelector('input[name="title"]');
        const slugInput = document.querySelector('input[name="slug"]');

        if (titleInput && slugInput && !slugInput.value) {
            titleInput.addEventListener('input', function() {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/--+/g, '-')
                    .trim();
                slugInput.value = slug;
            });
        }

        // Add syllabus functionality
        document.getElementById('add-syllabus').addEventListener('click', function() {
            const wrapper = document.getElementById('syllabus-wrapper');

            // Remove empty state if it exists
            const emptyState = wrapper.querySelector('.text-center');
            if (emptyState) {
                emptyState.remove();
            }

            const div = document.createElement('div');
            div.classList.add('syllabus-item', 'border-2', 'border-gray-200', 'dark:border-gray-700',
                'rounded-lg', 'p-5', 'bg-gray-50', 'dark:bg-gray-700/30', 'hover:border-blue-300',
                'dark:hover:border-blue-600', 'transition-all', 'duration-200');

            div.innerHTML = `
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold text-white" 
                            style="background: linear-gradient(to right, #1363C6, #0d4a99);">
                            ${counter + 1}
                        </div>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Topic ${counter + 1}</span>
                    </div>
                    <button type="button" class="remove-syllabus p-1.5 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Remove Topic">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
                <div class="space-y-3">
                    <div>
                        <input type="text" name="syllabus[${counter}][title]" placeholder="Topic title (e.g., Introduction to HTML)" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200">
                    </div>
                    <div>
                        <textarea name="syllabus[${counter}][content]" placeholder="Topic content and learning objectives..." rows="3" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-colors duration-200"></textarea>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex-1">
                            <input type="file" name="syllabus[${counter}][file_path]" accept=".pdf,.doc,.docx,.ppt,.pptx" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 dark:file:bg-purple-900/30 dark:file:text-purple-400 transition-colors duration-200">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Optional: Attach study materials (PDF, DOC, PPT)</p>
                        </div>
                    </div>
                </div>
            `;

            wrapper.appendChild(div);
            counter++;

            // Reattach remove event listeners
            attachRemoveListeners();
        });

        // Remove syllabus functionality
        function attachRemoveListeners() {
            document.querySelectorAll('.remove-syllabus').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Are you sure you want to remove this topic?')) {
                        this.closest('.syllabus-item').remove();
                        updateTopicNumbers();

                        // Show empty state if no topics left
                        const wrapper = document.getElementById('syllabus-wrapper');
                        if (wrapper.children.length === 0) {
                            wrapper.innerHTML = `
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center bg-gray-100 dark:bg-gray-700">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">No syllabus topics yet. Click "Add Topic" to get started.</p>
                                </div>
                            `;
                        }
                    }
                });
            });
        }

        // Update topic numbers after removal
        function updateTopicNumbers() {
            document.querySelectorAll('.syllabus-item').forEach((item, index) => {
                const badge = item.querySelector('.w-8.h-8');
                const label = item.querySelector('.text-sm.font-semibold');
                if (badge) badge.textContent = index + 1;
                if (label) label.textContent = `Topic ${index + 1}`;
            });
        }

        // Initial attachment of remove listeners
        attachRemoveListeners();
    });
</script>
