<div class="space-y-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div
            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Job Details</h3>
            </div>
        </div>

        <div class="p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Title --}}
                <div>
                    <x-input-label for="title" value="Job Title" required />
                    <x-text-input id="title" name="title" type="text" :value="old('title', $career->title ?? '')"
                        class="mt-1 block w-full" placeholder="e.g. Senior Software Engineer" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                {{-- Slug --}}
                <div>
                    <x-input-label for="slug" value="Slug" required />
                    <x-text-input id="slug" name="slug" type="text" :value="old('slug', $career->slug ?? '')"
                        class="mt-1 block w-full" placeholder="senior-software-engineer" required />
                    <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">URL-friendly version of the title</p>
                </div>

                {{-- Location --}}
                <div>
                    <x-input-label for="location" value="Location" />
                    <x-text-input id="location" name="location" type="text" :value="old('location', $career->location ?? '')"
                        class="mt-1 block w-full" placeholder="e.g. Kathmandu, Remote, Hybrid" />
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                </div>

                {{-- Job Type --}}
                <div>
                    <x-input-label for="job_type" value="Job Type" required />
                    <select id="job_type" name="job_type"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required>
                        @php
                            $types = ['full-time', 'part-time', 'internship', 'contract'];
                            $selected = old('job_type', $career->job_type ?? 'full-time');
                        @endphp
                        @foreach ($types as $type)
                            <option value="{{ $type }}" @selected($selected === $type)>
                                {{ ucfirst(str_replace('-', ' ', $type)) }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('job_type')" class="mt-2" />
                </div>

                {{-- Deadline --}}
                <div>
                    <x-input-label for="deadline" value="Application Deadline" />
                    <x-text-input id="deadline" name="deadline" type="date" :value="old('deadline', isset($career->deadline) ? $career->deadline->format('Y-m-d') : '')"
                        class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave empty for no deadline</p>
                </div>

            </div>

            {{-- Description --}}
            <div>
                <x-input-label for="description" value="Job Description" />
                <textarea id="description" name="description" rows="6"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    placeholder="Describe the role, responsibilities, and requirements...">{{ old('description', $career->description ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            {{-- Status Checkbox --}}
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="is_open" name="is_open" type="checkbox" value="1" @checked(old('is_open', $career->is_open ?? true))
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div class="ml-3 text-sm">
                    <label for="is_open" class="font-medium text-gray-700 dark:text-gray-300">
                        Open for Applications
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400">When unchecked, candidates cannot apply for
                        this position</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
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

            {{-- Meta Title --}}
            <div>
                <x-input-label for="meta_title" value="Meta Title" />
                <x-text-input id="meta_title" name="meta_title" type="text" :value="old('meta_title', $career->meta_title ?? '')"
                    class="mt-1 block w-full" placeholder="SEO-optimized title for search engines" />
                <x-input-error :messages="$errors->get('meta_title')" class="mt-2" />
            </div>

            {{-- Meta Description --}}
            <div>
                <x-input-label for="meta_description" value="Meta Description" />
                <textarea id="meta_description" name="meta_description" rows="3"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    placeholder="Brief description for search engines (150-160 characters)">{{ old('meta_description', $career->meta_description ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('meta_description')" class="mt-2" />
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Recommended length: 150-160 characters</p>
            </div>

            {{-- Meta Keywords --}}
            <div>
                <x-input-label for="meta_keywords" value="Meta Keywords" />
                <x-text-input id="meta_keywords" name="meta_keywords" type="text" :value="old('meta_keywords', $career->meta_keywords ?? '')"
                    class="mt-1 block w-full" placeholder="keyword1, keyword2, keyword3" />
                <x-input-error :messages="$errors->get('meta_keywords')" class="mt-2" />
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Separate keywords with commas</p>
            </div>

        </div>
    </div>

    {{-- Submit Buttons --}}
    <div class="flex items-center justify-end gap-3 pt-2">
        <x-secondary-button onclick="window.location='{{ route('careers.index') }}'">
            Cancel
        </x-secondary-button>

        <x-primary-button>
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ $button }}
        </x-primary-button>
    </div>

</div>

{{-- Auto-generate slug from title --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        // Only auto-generate if slug is empty
        if (titleInput && slugInput && !slugInput.value) {
            titleInput.addEventListener('input', function() {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim();
                slugInput.value = slug;
            });
        }
    });
</script>
