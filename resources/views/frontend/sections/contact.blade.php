@props(['section'])

@php
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();
    $heading = $fields['heading'] ?? 'Contact Us';
    $subheading = $fields['subheading'] ?? 'We would love to hear from you.';
    $content =
        $fields['content'] ??
        'Feel free to reach out to us with any questions, comments, or inquiries you may have. Our team is here to assist you and provide the information you need.';
@endphp

<section
    class="relative py-20 lg:py-28 px-6 sm:px-10 lg:px-14 bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-950 overflow-hidden">

    {{-- Decorative background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-[#1363C6]/5 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-4xl mx-auto relative">

        {{-- Section Header --}}
        <div class="text-center mb-16">
            @if ($subheading)
                <span
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm tracking-wide font-semibold
                    bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8]
                    border border-[#1363C6]/20 dark:border-[#1363C6]/30
                    shadow-sm shadow-[#1363C6]/10">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                    {{ strtoupper($subheading) }}
                </span>
            @endif

            <h2 class="text-[40px] font-extrabold text-gray-900 dark:text-white mt-6 mb-4 leading-tight">
                {{ $heading }}
            </h2>

            @if ($content)
                <div class="text-[16px] leading-relaxed text-gray-600 dark:text-gray-400">{!! $content !!}
                </div>
            @endif
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="flex-1">
                        <h4 class="text-[15px] font-semibold text-red-800 dark:text-red-300 mb-1">Please fix the
                            following errors:</h4>
                        <ul class="list-disc ml-4 text-[15px] text-red-700 dark:text-red-400 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Contact Form --}}
        <form action="{{ route('contact.submit') }}" method="POST"
            class="bg-white dark:bg-gray-900 rounded-xl p-8 border border-gray-100 dark:border-gray-800 shadow-lg">
            @csrf

            <div class="space-y-6">
                {{-- Name & Email Row --}}
                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Name Field --}}
                    <div>
                        <label for="name"
                            class="block text-[15px] font-semibold text-gray-900 dark:text-white mb-2">
                            Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" placeholder="John Doe"
                            value="{{ old('name') }}" required
                            class="w-full px-4 py-3 rounded-lg 
                            border border-gray-200 dark:border-gray-700 
                            bg-white dark:bg-gray-800 
                            text-gray-900 dark:text-white
                            text-[15px]
                            focus:ring-2 focus:ring-[#1363C6]/20 focus:border-[#1363C6] 
                            transition-all duration-200
                            placeholder:text-gray-400">
                    </div>

                    {{-- Email Field --}}
                    <div>
                        <label for="email"
                            class="block text-[15px] font-semibold text-gray-900 dark:text-white mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" placeholder="john@example.com"
                            value="{{ old('email') }}" required
                            class="w-full px-4 py-3 rounded-lg 
                            border border-gray-200 dark:border-gray-700 
                            bg-white dark:bg-gray-800 
                            text-gray-900 dark:text-white
                            text-[15px]
                            focus:ring-2 focus:ring-[#1363C6]/20 focus:border-[#1363C6] 
                            transition-all duration-200
                            placeholder:text-gray-400">
                    </div>
                </div>

                {{-- Subject Field --}}
                <div>
                    <label for="subject" class="block text-[15px] font-semibold text-gray-900 dark:text-white mb-2">
                        Subject <span class="text-gray-400 text-[13px] font-normal">(Optional)</span>
                    </label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                        placeholder="What is this regarding?"
                        class="w-full px-4 py-3 rounded-lg 
                        border border-gray-200 dark:border-gray-700 
                        bg-white dark:bg-gray-800 
                        text-gray-900 dark:text-white
                        text-[15px]
                        focus:ring-2 focus:ring-[#1363C6]/20 focus:border-[#1363C6] 
                        transition-all duration-200
                        placeholder:text-gray-400">
                </div>

                {{-- Message Field --}}
                <div>
                    <label for="message" class="block text-[15px] font-semibold text-gray-900 dark:text-white mb-2">
                        Message <span class="text-red-500">*</span>
                    </label>
                    <textarea id="message" name="message" placeholder="Write your message here..." rows="6" required
                        class="w-full px-4 py-3 rounded-lg 
                        border border-gray-200 dark:border-gray-700 
                        bg-white dark:bg-gray-800 
                        text-gray-900 dark:text-white
                        text-[15px] leading-[24px]
                        focus:ring-2 focus:ring-[#1363C6]/20 focus:border-[#1363C6] 
                        transition-all duration-200
                        placeholder:text-gray-400
                        resize-none">{{ old('message') }}</textarea>
                </div>

                {{-- Submit Button --}}
                <div class="pt-2">
                    <button type="submit"
                        class="w-full px-6 py-3 
                        bg-gradient-to-r from-[#1363C6] to-[#0d4a94] 
                        text-white font-semibold text-[15px] rounded-lg 
                        hover:shadow-lg hover:shadow-[#1363C6]/30 
                        transition-all duration-300
                        inline-flex items-center justify-center gap-2 group">
                        <span>Send Message</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
        </form>

        {{-- Additional Info (Optional) --}}
        <div class="mt-8 text-center">
            <p class="text-[15px] text-gray-600 dark:text-gray-400">
                We'll get back to you within <span class="font-semibold text-[#1363C6] dark:text-[#4a8dd8]">24
                    hours</span>
            </p>
        </div>

    </div>
</section>
