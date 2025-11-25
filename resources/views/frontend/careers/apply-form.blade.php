{{-- Enhanced Career Application Form --}}
<form action="{{ route('careers.apply', $career->id) }}" method="POST" enctype="multipart/form-data"
    class="max-w-3xl mx-auto">
    @csrf

    <div class="space-y-6">

        {{-- Application Header --}}
        <div
            class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800 rounded-2xl p-8 text-white shadow-lg">
            <div class="flex items-start gap-4">
                <div
                    class="flex-shrink-0 w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold mb-2">Apply for {{ $career->title }}</h2>
                    <p class="text-blue-100 text-sm leading-relaxed">
                        Fill out the form below to submit your application. Fields marked with
                        <span class="text-red-300 font-semibold">*</span> are required.
                    </p>
                </div>
            </div>
        </div>

        {{-- Personal Information Section --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Personal Information</h3>
                </div>
            </div>

            <div class="p-6 space-y-5">

                {{-- Full Name --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Full Name
                            <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-all duration-200"
                        placeholder="John Doe" required>
                    @error('name')
                        <p class="text-red-600 dark:text-red-400 text-sm flex items-center gap-1.5 mt-1">
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

                    {{-- Email --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Email Address
                                <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-all duration-200"
                            placeholder="john@example.com" required>
                        @error('email')
                            <p class="text-red-600 dark:text-red-400 text-sm flex items-center gap-1.5 mt-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                Phone Number
                                <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 dark:focus:border-blue-500 transition-all duration-200"
                            placeholder="+977 0000000000" required>
                        @error('phone')
                            <p class="text-red-600 dark:text-red-400 text-sm flex items-center gap-1.5 mt-1">
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
        </div>

        {{-- Documents Section --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/50">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Documents</h3>
                </div>
            </div>

            <div class="p-6 space-y-5">

                {{-- Resume Upload --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            Resume / CV
                            <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <div
                        class="relative group border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-200 bg-gray-50 dark:bg-gray-700/30">
                        <input type="file" name="resume" id="resume-upload"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".pdf,.doc,.docx"
                            required>
                        <div class="pointer-events-none">
                            <div
                                class="w-12 h-12 mx-auto mb-3 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Click to upload or drag and drop
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                PDF, DOC, or DOCX (Max 5MB)
                            </p>
                        </div>
                    </div>
                    <div id="resume-filename" class="hidden">
                        <div
                            class="flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm text-blue-700 dark:text-blue-300 font-medium flex-1"
                                id="resume-name"></span>
                            <button type="button" id="resume-remove"
                                class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('resume')
                        <p class="text-red-600 dark:text-red-400 text-sm flex items-center gap-1.5 mt-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Cover Letter Upload (Optional) --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Cover Letter
                            <span class="ml-auto text-xs text-gray-500 dark:text-gray-400 font-normal">Optional</span>
                        </span>
                    </label>
                    <div
                        class="relative group border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-200 bg-gray-50 dark:bg-gray-700/30">
                        <input type="file" name="cover_letter" id="cover-upload"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".pdf,.doc,.docx">
                        <div class="pointer-events-none">
                            <div
                                class="w-12 h-12 mx-auto mb-3 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Click to upload or drag and drop
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                PDF, DOC, or DOCX (Max 5MB)
                            </p>
                        </div>
                    </div>
                    <div id="cover-filename" class="hidden">
                        <div
                            class="flex items-center gap-3 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm text-green-700 dark:text-green-300 font-medium flex-1"
                                id="cover-name"></span>
                            <button type="button" id="cover-remove"
                                class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('cover_letter')
                        <p class="text-red-600 dark:text-red-400 text-sm flex items-center gap-1.5 mt-1">
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

        {{-- Submit Button --}}
        <div class="flex items-center justify-end gap-4 pt-2">
            <a href="{{ route('careers.show', $career->id) }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Go Back
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Submit Application
            </button>
        </div>

    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Resume file upload handler
        const resumeUpload = document.getElementById('resume-upload');
        const resumeFilename = document.getElementById('resume-filename');
        const resumeName = document.getElementById('resume-name');
        const resumeRemove = document.getElementById('resume-remove');

        resumeUpload.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                resumeName.textContent = this.files[0].name;
                resumeFilename.classList.remove('hidden');
            }
        });

        resumeRemove.addEventListener('click', function() {
            resumeUpload.value = '';
            resumeFilename.classList.add('hidden');
        });

        // Cover letter file upload handler
        const coverUpload = document.getElementById('cover-upload');
        const coverFilename = document.getElementById('cover-filename');
        const coverName = document.getElementById('cover-name');
        const coverRemove = document.getElementById('cover-remove');

        coverUpload.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                coverName.textContent = this.files[0].name;
                coverFilename.classList.remove('hidden');
            }
        });

        coverRemove.addEventListener('click', function() {
            coverUpload.value = '';
            coverFilename.classList.add('hidden');
        });

        // Form validation feedback
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span>Submitting...</span>
            `;
        });
    });
</script>
