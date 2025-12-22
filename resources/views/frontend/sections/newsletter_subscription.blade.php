@php
    // Get field values from section fields
    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();

    $title = $fields['title'] ?? 'Stay Updated';
    $subtitle = $fields['subtitle'] ?? 'Subscribe to our newsletter';
    $description = $fields['description'] ?? '';
    $backgroundColor = $fields['background_color'] ?? '#f3f4f6';
    $showTopics = isset($fields['show_topics']) ? filter_var($fields['show_topics'], FILTER_VALIDATE_BOOLEAN) : true;
    $buttonText = $fields['button_text'] ?? 'Subscribe Now';
    $successMessage = $fields['success_message'] ?? 'Thank you for subscribing!';
    $image = $fields['image'] ?? null;
    $layout = $section->layout ?? 'subscription_inline';

    // Get active subscription topics
    $topics = \App\Models\SubscriptionTopic::active()->get();
    $sectionId = 'newsletter-section-' . uniqid();
@endphp

@if ($layout === 'subscription_inline')
    {{-- Inline Layout - Compact horizontal form --}}
    <section class="py-16 bg-gray-50 dark:bg-gray-900" id="{{ $sectionId }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="newsletter-heading text-3xl font-bold text-gray-900 dark:text-white mb-2 opacity-0">
                    {{ $title }}</h2>
                @if ($subtitle)
                    <p class="newsletter-subtitle text-lg text-gray-600 dark:text-gray-300 opacity-0">{{ $subtitle }}
                    </p>
                @endif
                @if ($description)
                    <div
                        class="newsletter-description mt-4 text-gray-600 dark:text-gray-400 max-w-2xl mx-auto opacity-0">
                        {!! $description !!}
                    </div>
                @endif
            </div>

            <div class="max-w-3xl mx-auto newsletter-form opacity-0">
                <form action="{{ route('subscription.subscribe') }}" method="POST" class="space-y-4"
                    id="subscription-form-inline">
                    @csrf

                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="email" name="email" placeholder="Enter your email address" required
                            class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">

                        <button type="submit"
                            class="px-8 py-3 bg-blue-600 dark:bg-blue-700 text-white font-semibold rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition duration-200 whitespace-nowrap">
                            {{ $buttonText }}
                        </button>
                    </div>

                    @if ($showTopics && $topics->isNotEmpty())
                        <div class="flex flex-wrap gap-3 justify-center">
                            @foreach ($topics as $topic)
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="topics[]" value="{{ $topic->id }}"
                                        {{ $loop->first ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded">
                                    <span
                                        class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $topic->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        @foreach ($topics as $topic)
                            <input type="hidden" name="topics[]" value="{{ $topic->id }}">
                        @endforeach
                    @endif

                    <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                        By subscribing, you agree to receive email updates. You can unsubscribe at any time.
                    </p>
                </form>

                @if (session('success'))
                    <div
                        class="mt-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg text-center">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </section>
@elseif($layout === 'subscription_card')
    {{-- Card Layout - Centered card with image --}}
    <section class="py-20 bg-gray-50 dark:bg-gray-900" style="background-color: {{ $backgroundColor }};"
        id="{{ $sectionId }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="newsletter-card bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden opacity-0">
                <div class="grid md:grid-cols-2 gap-8">
                    @if ($image)
                        <div class="hidden md:block">
                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $title }}"
                                class="w-full h-full object-cover">
                        </div>
                    @endif

                    <div class="p-8 lg:p-12 {{ $image ? '' : 'md:col-span-2' }}">
                        <div class="max-w-xl {{ $image ? '' : 'mx-auto text-center' }}">
                            <h2
                                class="newsletter-heading text-4xl font-bold text-gray-900 dark:text-white mb-4 opacity-0">
                                {{ $title }}</h2>
                            @if ($subtitle)
                                <p class="newsletter-subtitle text-xl text-gray-600 dark:text-gray-300 mb-6 opacity-0">
                                    {{ $subtitle }}</p>
                            @endif
                            @if ($description)
                                <div class="newsletter-description text-gray-600 dark:text-gray-400 mb-8 opacity-0">
                                    {!! $description !!}
                                </div>
                            @endif

                            <form action="{{ route('subscription.subscribe') }}" method="POST"
                                class="space-y-4 newsletter-form opacity-0" id="subscription-form-card">
                                @csrf

                                <div>
                                    <input type="email" name="email" placeholder="Your email address" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                </div>

                                <div>
                                    <input type="text" name="name" placeholder="Your name (optional)"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                </div>

                                @if ($showTopics && $topics->isNotEmpty())
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Select your interests:
                                        </label>
                                        @foreach ($topics as $topic)
                                            <label
                                                class="flex items-start p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                                <input type="checkbox" name="topics[]" value="{{ $topic->id }}"
                                                    {{ $loop->first ? 'checked' : '' }}
                                                    class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded">
                                                <div class="ml-3">
                                                    <div class="font-medium text-gray-900 dark:text-white">
                                                        {{ $topic->name }}</div>
                                                    @if ($topic->description)
                                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                                            {{ $topic->description }}</div>
                                                    @endif
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    @foreach ($topics as $topic)
                                        <input type="hidden" name="topics[]" value="{{ $topic->id }}">
                                    @endforeach
                                @endif

                                <button type="submit"
                                    class="w-full px-6 py-3 bg-blue-600 dark:bg-blue-700 text-white font-semibold rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition duration-200">
                                    {{ $buttonText }}
                                </button>

                                <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                                    By subscribing, you agree to receive email updates. You can unsubscribe at any time.
                                </p>
                            </form>

                            @if (session('success'))
                                <div
                                    class="mt-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@elseif($layout === 'subscription_fullwidth')
    {{-- Full Width Layout - Banner style --}}
    <section class="relative py-20 overflow-hidden"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" id="{{ $sectionId }}">
        <div class="absolute inset-0 bg-black opacity-10 dark:opacity-20"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white mb-10">
                <h2 class="newsletter-heading text-4xl md:text-5xl font-bold mb-4 opacity-0">{{ $title }}</h2>
                @if ($subtitle)
                    <p class="newsletter-subtitle text-xl md:text-2xl mb-6 opacity-90 opacity-0">{{ $subtitle }}
                    </p>
                @endif
                @if ($description)
                    <div class="newsletter-description text-lg opacity-80 max-w-3xl mx-auto opacity-0">
                        {!! $description !!}
                    </div>
                @endif
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="newsletter-card bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 lg:p-12 opacity-0">
                    <form action="{{ route('subscription.subscribe') }}" method="POST" class="space-y-6"
                        id="subscription-form-fullwidth">
                        @csrf

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email
                                    Address *</label>
                                <input type="email" name="email" placeholder="your@email.com" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name
                                    (Optional)</label>
                                <input type="text" name="name" placeholder="Your name"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                            </div>
                        </div>

                        @if ($showTopics && $topics->isNotEmpty())
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    What would you like to receive updates about? *
                                </label>
                                <div class="grid sm:grid-cols-2 gap-3">
                                    @foreach ($topics as $topic)
                                        <label
                                            class="flex items-start p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-gray-700 cursor-pointer transition duration-200">
                                            <input type="checkbox" name="topics[]" value="{{ $topic->id }}"
                                                {{ $loop->first ? 'checked' : '' }}
                                                class="mt-1 h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded">
                                            <div class="ml-3">
                                                <div class="font-semibold text-gray-900 dark:text-white">
                                                    {{ $topic->name }}</div>
                                                @if ($topic->description)
                                                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                        {{ $topic->description }}</div>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            @foreach ($topics as $topic)
                                <input type="hidden" name="topics[]" value="{{ $topic->id }}">
                            @endforeach
                        @endif

                        <div class="flex items-center justify-between pt-4">
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                We respect your privacy. Unsubscribe anytime.
                            </p>
                            <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-lg hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition duration-200 shadow-lg">
                                {{ $buttonText }}
                            </button>
                        </div>
                    </form>

                    @if (session('success'))
                        <div
                            class="mt-6 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg text-center">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

            const sectionId = '#{{ $sectionId }}';

            // Animate heading
            gsap.fromTo(`${sectionId} .newsletter-heading`, {
                opacity: 0,
                y: -30
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .newsletter-heading`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate subtitle
            gsap.fromTo(`${sectionId} .newsletter-subtitle`, {
                opacity: 0,
                y: -20
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 0.2,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .newsletter-subtitle`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate description
            gsap.fromTo(`${sectionId} .newsletter-description`, {
                opacity: 0,
                y: 20
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 0.3,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .newsletter-description`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate form
            gsap.fromTo(`${sectionId} .newsletter-form`, {
                opacity: 0,
                y: 30
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 0.4,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .newsletter-form`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Animate card
            gsap.fromTo(`${sectionId} .newsletter-card`, {
                opacity: 0,
                scale: 0.95
            }, {
                opacity: 1,
                scale: 1,
                duration: 0.8,
                delay: 0.4,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: `${sectionId} .newsletter-card`,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Handle form submission with better UX
            document.querySelectorAll('[id^="subscription-form"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const button = this.querySelector('button[type="submit"]');
                    const originalText = button.textContent;
                    button.disabled = true;
                    button.textContent = 'Subscribing...';

                    // Re-enable after 3 seconds in case of error
                    setTimeout(() => {
                        button.disabled = false;
                        button.textContent = originalText;
                    }, 3000);
                });
            });
        });
    </script>
@endpush
