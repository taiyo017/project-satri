<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Edit Testimonial') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Update testimonial information
                </p>
            </div>
            <a href="{{ route('testimonials.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to Testimonials') }}
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

        <form action="{{ route('testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content Area --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Customer Information --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('Customer Information') }}
                            </h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Name -->
                                <div>
                                    <x-input-label for="name" class="text-gray-700 dark:text-gray-300">
                                        Name <span class="text-red-500">*</span>
                                    </x-input-label>
                                    <x-text-input id="name" type="text" name="name" class="mt-2 block w-full"
                                        :value="old('name', $testimonial->name)" placeholder="John Doe" required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Position -->
                                <div>
                                    <x-input-label for="position" class="text-gray-700 dark:text-gray-300">
                                        Position
                                    </x-input-label>
                                    <x-text-input id="position" type="text" name="position" class="mt-2 block w-full"
                                        :value="old('position', $testimonial->position)" placeholder="CEO" />
                                    <x-input-error :messages="$errors->get('position')" class="mt-2" />
                                </div>

                                <!-- Company -->
                                <div class="md:col-span-2">
                                    <x-input-label for="company" class="text-gray-700 dark:text-gray-300">
                                        Company
                                    </x-input-label>
                                    <x-text-input id="company" type="text" name="company" class="mt-2 block w-full"
                                        :value="old('company', $testimonial->company)" placeholder="Company Name" />
                                    <x-input-error :messages="$errors->get('company')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Testimonial Content --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                {{ __('Testimonial Content') }}
                            </h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <!-- Message -->
                            <div>
                                <x-input-label for="message" class="text-gray-700 dark:text-gray-300">
                                    Message <span class="text-red-500">*</span>
                                </x-input-label>
                                <textarea id="message" name="message" rows="6" required
                                    class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm resize-y"
                                    placeholder="Write the testimonial message...">{{ old('message', $testimonial->message) }}</textarea>
                                <x-input-error :messages="$errors->get('message')" class="mt-2" />
                            </div>

                            <!-- Rating -->
                            <div>
                                <x-input-label for="rating" class="text-gray-700 dark:text-gray-300">
                                    Rating <span class="text-red-500">*</span>
                                </x-input-label>
                                <select id="rating" name="rating" required
                                    class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm">
                                    <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Stars)</option>
                                    <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Stars)</option>
                                    <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 Stars)</option>
                                    <option value="2" {{ old('rating', $testimonial->rating) == 2 ? 'selected' : '' }}>⭐⭐ (2 Stars)</option>
                                    <option value="1" {{ old('rating', $testimonial->rating) == 1 ? 'selected' : '' }}>⭐ (1 Star)</option>
                                </select>
                                <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- SEO Meta Tags --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50 flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                {{ __('SEO Meta Tags') }}
                            </h3>
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">Optional</span>
                        </div>
                        <div class="p-6 space-y-5">
                            <!-- Meta Title -->
                            <div>
                                <x-input-label for="meta_title" :value="__('Meta Title')" class="text-gray-700 dark:text-gray-300" />
                                <x-text-input id="meta_title" type="text" name="meta_title" class="mt-2 block w-full"
                                    :value="old('meta_title', $testimonial->meta_title)" placeholder="SEO Meta Title" />
                                <x-input-error :messages="$errors->get('meta_title')" class="mt-2" />
                            </div>

                            <!-- Meta Description -->
                            <div>
                                <x-input-label for="meta_description" :value="__('Meta Description')" class="text-gray-700 dark:text-gray-300" />
                                <textarea id="meta_description" name="meta_description" rows="3"
                                    class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm resize-none"
                                    placeholder="SEO Meta Description">{{ old('meta_description', $testimonial->meta_description) }}</textarea>
                                <x-input-error :messages="$errors->get('meta_description')" class="mt-2" />
                            </div>

                            <!-- Meta Keywords -->
                            <div>
                                <x-input-label for="meta_keywords" :value="__('Meta Keywords')" class="text-gray-700 dark:text-gray-300" />
                                <x-text-input id="meta_keywords" type="text" name="meta_keywords" class="mt-2 block w-full"
                                    :value="old('meta_keywords', $testimonial->meta_keywords)" placeholder="keyword1, keyword2, keyword3" />
                                <x-input-error :messages="$errors->get('meta_keywords')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">

                    {{-- Publishing Options --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Publishing
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <x-input-label for="status" :value="__('Status')" class="text-gray-700 dark:text-gray-300" />
                                <select id="status" name="status" required
                                    class="mt-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm">
                                    <option value="active" {{ old('status', $testimonial->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $testimonial->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $testimonial->is_featured) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="is_featured" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    Mark as featured testimonial
                                </label>
                            </div>

                            <div class="pt-4 space-y-3">
                                <x-primary-button type="submit" class="w-full justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('Update Testimonial') }}
                                </x-primary-button>

                                <x-secondary-button type="button"
                                    onclick="window.location='{{ route('testimonials.index') }}'"
                                    class="w-full justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Cancel
                                </x-secondary-button>
                            </div>
                        </div>
                    </div>

                    {{-- Photo Upload --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Customer Photo
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-col items-center">
                                <div class="mb-4 w-full">
                                    @if($testimonial->photo)
                                        <img id="image-preview" src="{{ asset('storage/' . $testimonial->photo) }}" alt="{{ $testimonial->name }}"
                                            class="w-full h-48 object-cover rounded-xl border-2 border-gray-200 dark:border-gray-700">
                                        <div id="image-placeholder" class="hidden w-full h-48 flex items-center justify-center bg-gray-100 dark:bg-gray-900 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 transition-colors hover:border-blue-500 dark:hover:border-blue-500">
                                            <div class="text-center">
                                                <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-2"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span class="text-gray-500 dark:text-gray-400 text-sm">No photo selected</span>
                                            </div>
                                        </div>
                                    @else
                                        <div id="image-placeholder"
                                            class="w-full h-48 flex items-center justify-center bg-gray-100 dark:bg-gray-900 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 transition-colors hover:border-blue-500 dark:hover:border-blue-500">
                                            <div class="text-center">
                                                <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-2"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span class="text-gray-500 dark:text-gray-400 text-sm">No photo selected</span>
                                            </div>
                                        </div>
                                        <img id="image-preview"
                                            class="hidden w-full h-48 object-cover rounded-xl border-2 border-gray-200 dark:border-gray-700"
                                            alt="Photo Preview">
                                    @endif
                                </div>

                                <div class="w-full">
                                    <label for="photo"
                                        class="cursor-pointer w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-semibold rounded-lg transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        <span>Choose New Photo</span>
                                    </label>
                                    <input type="file" id="photo" name="photo" class="hidden"
                                        accept="image/*" onchange="previewImage(this)">
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 text-center">
                                        JPG, PNG, WebP up to 2MB. Leave empty to keep current photo.
                                    </p>
                                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            const placeholder = document.getElementById('image-placeholder');
            const preview = document.getElementById('image-preview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    placeholder.classList.add('hidden');
                    preview.classList.remove('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</x-app-layout>
