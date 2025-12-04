@props(['section', 'galleries', 'fullPage' => null])

@php
    $currentSlug = request()->route()?->parameter('slug') ?? '';
    if (is_null($fullPage)) {
        $fullPage = $currentSlug === 'gallery';
    }

    $fields = $section->fields->pluck('field_value', 'field_key')->toArray();
    $title = $fields['title'] ?? '';
    $subtitle = $fields['subtitle'] ?? '';
    $content = $fields['content'] ?? '';
    $buttons = isset($fields['buttons']) ? json_decode($fields['buttons'], true) : [];

    // Fetch galleries depending on context
    if ($fullPage) {
        $displayGalleries = $galleries;
    } else {
        $displayGalleries = \App\Models\Gallery::where('is_active', true)->latest()->take(12)->get();
    }

    $totalGalleriesCount = \App\Models\Gallery::where('is_active', true)->count();
@endphp

<section
    class="relative py-8 lg:py-12 px-6 sm:px-10 lg:px-14 bg-gradient-to-b from-gray-50 to-white dark:from-gray-950 dark:to-gray-900 overflow-hidden">

    {{-- Decorative background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-10 w-96 h-96 bg-[#1363C6]/5 rounded-full blur-3xl animate-gallery-bg-1"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-[#1363C6]/5 rounded-full blur-3xl animate-gallery-bg-2">
        </div>
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-r from-[#1363C6]/3 to-purple-500/3 rounded-full blur-3xl animate-gallery-bg-3">
        </div>
    </div>

    <div class="max-w-7xl mx-auto relative">

        {{-- Section Header --}}
        @if ($title || $subtitle || $content)
            <div class="text-center max-w-3xl mx-auto mb-4">
                @if ($subtitle)
                    <span
                        class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm font-semibold tracking-wide
                        bg-[#1363C6]/10 text-[#1363C6] dark:bg-[#1363C6]/20 dark:text-[#4a8dd8]
                        border border-[#1363C6]/20 dark:border-[#1363C6]/30 shadow-sm shadow-[#1363C6]/10 animate-gallery-subtitle">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $subtitle }}
                    </span>
                @endif
            </div>

            @if ($content)
                <div class="max-w-7xl mx-auto mb-4 animate-gallery-content">
                    <div class="text-[16px] leading-relaxed text-gray-600 dark:text-gray-400 text-justify">
                        {!! $content !!}
                    </div>
                </div>
            @endif

            <div class="text-center max-w-3xl mx-auto mb-8">
                @if ($title)
                    <h2
                        class="text-[40px] font-extrabold text-gray-900 dark:text-white mt-6 mb-4 leading-tight animate-gallery-title">
                        {{ $title }}
                    </h2>
                @endif
            </div>


        @endif

        {{-- Galleries Grid --}}
        @if ($displayGalleries->count())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-12">
                @foreach ($displayGalleries as $index => $gallery)
                    <div class="gallery-item group relative bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-800 hover:border-[#1363C6]/40 dark:hover:border-[#1363C6]/50 transition-all duration-500 hover:shadow-2xl hover:shadow-[#1363C6]/20 hover:-translate-y-1 cursor-pointer animate-gallery-item"
                        data-gallery-index="{{ $index }}">

                        {{-- Gallery Image --}}
                        <div
                            class="relative h-64 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900">
                            @if ($gallery->image)
                                <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}"
                                    class="gallery-image w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    loading="lazy">

                                {{-- Overlay with Preview Icon --}}
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <div
                                        class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                        <div
                                            class="bg-white/20 backdrop-blur-sm rounded-full p-4 border-2 border-white/50">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                            </svg>
                                        </div>
                                        <p class="text-white font-semibold mt-3 text-center">View Gallery</p>
                                    </div>
                                </div>

                                {{-- Photo Count Badge (if applicable) --}}
                                <div
                                    class="absolute top-4 right-4 bg-black/60 backdrop-blur-sm text-white px-3 py-1.5 rounded-full text-sm font-semibold flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $gallery->images_count ?? 1 }}</span>
                                </div>
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Gallery Content --}}
                        <div class="p-5">
                            <h3
                                class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] transition-colors">
                                {{ $gallery->title }}
                            </h3>
                            @if ($gallery->description)
                                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400 line-clamp-2">
                                    {{ $gallery->description }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Custom Buttons (Homepage Only) --}}
            @if (!$fullPage)
                <div class="text-center mt-12 animate-gallery-load-more">
                    <button id="loadMoreBtn"
                        class="group inline-flex items-center gap-3 px-8 py-3.5 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] text-white font-semibold rounded-xl hover:shadow-xl hover:shadow-[#1363C6]/30 transition-all duration-300 hover:scale-105">
                        <span>Load More Galleries</span>
                        <svg class="w-5 h-5 group-hover:translate-y-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                </div>
            @endif
            @if ($fullPage && method_exists($galleries, 'links'))
                <div class="mt-12 flex justify-center">
                    <div class="inline-block">
                        {{ $galleries->links() }}
                    </div>
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="text-center py-20 animate-gallery-empty">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 rounded-2xl mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No Galleries Yet</h3>
                <p class="text-lg text-gray-600 dark:text-gray-400">Check back soon for exciting galleries!</p>
            </div>
        @endif

    </div>
</section>

{{-- Lightbox Modal --}}
<div id="galleryLightbox"
    class="fixed inset-0 z-50 hidden bg-black/95 backdrop-blur-sm flex items-center justify-center p-4">

    <!-- Close Button -->
    <button id="closeLightbox"
        class="absolute top-4 right-4 z-50 p-3 bg-white/20 hover:bg-white/30 rounded-full transition-all duration-300 hover:scale-110">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Previous Button -->
    <button id="prevImage"
        class="absolute left-2 sm:left-4 top-1/2 transform -translate-y-1/2 z-50 p-2 sm:p-3 bg-white/20 hover:bg-white/30 rounded-full transition-all duration-300 hover:scale-110">
        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <!-- Image Container -->
    <div class="relative w-full max-w-5xl mx-auto flex items-center justify-center px-12 sm:px-16">
        <img id="lightboxImage" src="" alt=""
            class="max-w-full max-h-[80vh] sm:max-h-[85vh] object-contain rounded-lg shadow-2xl lightbox-image-animate">

        <!-- Image Info -->
        <div
            class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4 sm:p-6 rounded-b-lg">
            <h3 id="lightboxTitle" class="text-base sm:text-lg font-semibold text-white mb-1"></h3>
            <p id="lightboxDescription" class="text-xs sm:text-sm text-gray-200"></p>
        </div>
    </div>

    <!-- Next Button -->
    <button id="nextImage"
        class="absolute right-2 sm:right-4 top-1/2 transform -translate-y-1/2 z-50 p-2 sm:p-3 bg-white/20 hover:bg-white/30 rounded-full transition-all duration-300 hover:scale-110">
        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- Counter -->
    <div
        class="absolute top-4 left-1/2 transform -translate-x-1/2 z-50 bg-white/20 backdrop-blur-sm px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-white font-semibold text-sm">
        <span id="lightboxCounter"></span>
    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

            // Set initial states
            gsap.set(
                '.animate-gallery-subtitle, .animate-gallery-content, .animate-gallery-title, .animate-gallery-item, .animate-gallery-load-more, .animate-gallery-empty', {
                    opacity: 0,
                    y: 40
                });

            // Background animations (subtle floating)
            gsap.to('.animate-gallery-bg-1', {
                y: 20,
                x: 15,
                duration: 9,
                repeat: -1,
                yoyo: true,
                ease: 'power1.inOut'
            });

            gsap.to('.animate-gallery-bg-2', {
                y: -20,
                x: -15,
                duration: 8,
                repeat: -1,
                yoyo: true,
                ease: 'power1.inOut'
            });

            gsap.to('.animate-gallery-bg-3', {
                scale: 1.1,
                duration: 10,
                repeat: -1,
                yoyo: true,
                ease: 'power1.inOut'
            });

            // Section Subtitle Badge
            gsap.to('.animate-gallery-subtitle', {
                opacity: 1,
                y: 0,
                duration: 0.7,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.animate-gallery-subtitle',
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                }
            });

            // Section Content
            gsap.to('.animate-gallery-content', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 0.1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.animate-gallery-content',
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                }
            });

            // Section Title
            gsap.to('.animate-gallery-title', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 0.2,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.animate-gallery-title',
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                }
            });

            // Gallery Items (stagger animation)
            document.querySelectorAll('.animate-gallery-item').forEach((item, index) => {
                gsap.to(item, {
                    opacity: 1,
                    y: 0,
                    duration: 0.7,
                    delay: index * 0.08,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: item,
                        start: 'top 85%',
                        toggleActions: 'play none none none'
                    }
                });
            });

            // Load More Button
            gsap.to('.animate-gallery-load-more', {
                opacity: 1,
                y: 0,
                duration: 0.7,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.animate-gallery-load-more',
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            });

            // Empty State
            gsap.to('.animate-gallery-empty', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.animate-gallery-empty',
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                }
            });

            // Lightbox image animation
            const lightboxImageObserver = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'src' && mutation.target.src) {
                        gsap.fromTo('.lightbox-image-animate', {
                            opacity: 0,
                            scale: 0.9
                        }, {
                            opacity: 1,
                            scale: 1,
                            duration: 0.4,
                            ease: 'power2.out'
                        });
                    }
                });
            });

            const lightboxImage = document.getElementById('lightboxImage');
            if (lightboxImage) {
                lightboxImageObserver.observe(lightboxImage, {
                    attributes: true
                });
            }
        });
    </script>
@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const galleries = @json($displayGalleries->items()) || [];
            if (galleries.length === 0) return;

            const lightbox = document.getElementById('galleryLightbox');
            const lightboxImage = document.getElementById('lightboxImage');
            const lightboxTitle = document.getElementById('lightboxTitle');
            const lightboxDescription = document.getElementById('lightboxDescription');
            const lightboxCounter = document.getElementById('lightboxCounter');
            const closeLightbox = document.getElementById('closeLightbox');
            const prevImage = document.getElementById('prevImage');
            const nextImage = document.getElementById('nextImage');

            let currentIndex = 0;

            // Open lightbox
            document.querySelectorAll('.gallery-item').forEach((item, index) => {
                item.addEventListener('click', () => {
                    currentIndex = index;
                    openLightbox();
                });
            });

            function openLightbox() {
                const gallery = galleries[currentIndex];

                // Preload image for smoother experience
                const img = new Image();
                img.src = "{{ asset('storage') }}/" + gallery.image;
                img.onload = () => {
                    lightboxImage.src = img.src;
                    lightboxTitle.textContent = gallery.title || '';
                    lightboxDescription.textContent = gallery.description || '';
                    lightboxCounter.textContent = `${currentIndex + 1} / ${galleries.length}`;
                    lightbox.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                };
            }

            function closeLightboxFunc() {
                lightbox.classList.add('hidden');
                document.body.style.overflow = 'auto';
                lightboxImage.src = ''; // Clear previous image
            }

            closeLightbox.addEventListener('click', closeLightboxFunc);

            prevImage.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + galleries.length) % galleries.length;
                openLightbox();
            });

            nextImage.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % galleries.length;
                openLightbox();
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (!lightbox.classList.contains('hidden')) {
                    if (e.key === 'Escape') closeLightboxFunc();
                    if (e.key === 'ArrowLeft') prevImage.click();
                    if (e.key === 'ArrowRight') nextImage.click();
                }
            });

            // Click outside image to close
            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) closeLightboxFunc();
            });

            // Touch swipe support for mobile
            let touchStartX = 0;
            let touchEndX = 0;

            lightbox.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            });

            lightbox.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });

            function handleSwipe() {
                const swipeThreshold = 50;
                if (touchEndX < touchStartX - swipeThreshold) {
                    // Swipe left - next image
                    nextImage.click();
                }
                if (touchEndX > touchStartX + swipeThreshold) {
                    // Swipe right - previous image
                    prevImage.click();
                }
            }
        });
    </script>
@endpush
