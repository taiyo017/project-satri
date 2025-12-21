@props(['allTestimonialsJson', 'sectionId'])

<div id="testimonialModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/80 backdrop-blur-sm">

    {{-- Modal Container --}}
    <div class="relative w-full max-w-4xl max-h-[90vh] modal-content">

        {{-- Close Button - TOP RIGHT --}}
        <button id="closeTestimonialModal"
            class="absolute -top-4 -right-4 z-50 w-10 h-10 flex items-center justify-center
            bg-white dark:bg-gray-800 rounded-full shadow-lg
            text-gray-700 dark:text-gray-300 hover:text-red-500 dark:hover:text-red-400
            hover:scale-110 hover:rotate-90 transition-all duration-300
            border-2 border-gray-200 dark:border-gray-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Modal Content Card --}}
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl overflow-hidden">
            <div class="flex flex-col md:flex-row max-h-[85vh]">

                {{-- Left: Photo & Rating Section --}}
                <div
                    class="md:w-2/5 bg-gradient-to-br from-[#1363C6]/10 via-[#1363C6]/5 to-transparent 
                    dark:from-[#1363C6]/20 dark:via-[#1363C6]/10 dark:to-transparent 
                    p-8 flex flex-col items-center justify-center relative">

                    {{-- Decorative circles --}}
                    <div class="absolute top-4 right-4 w-24 h-24 bg-[#1363C6]/10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-4 left-4 w-32 h-32 bg-[#0d4a94]/10 rounded-full blur-2xl"></div>

                    {{-- Quote Icon Background --}}
                    <div class="absolute top-8 left-8 opacity-5">
                        <svg class="w-32 h-32 text-[#1363C6]" fill="currentColor" viewBox="0 0 32 32">
                            <path
                                d="M10 8c-3.3 0-6 2.7-6 6s2.7 6 6 6c.3 0 .5 0 .8-.1L8 24h4.4l1.6-2.7c1.6-1.1 2.7-3 2.7-5.1 0-3.3-2.7-6-6-6zm12 0c-3.3 0-6 2.7-6 6s2.7 6 6 6c.3 0 .5 0 .8-.1L20 24h4.4l1.6-2.7c1.6-1.1 2.7-3 2.7-5.1 0-3.3-2.7-6-6-6z" />
                        </svg>
                    </div>

                    <div class="relative z-10 flex flex-col items-center w-full">
                        {{-- Photo --}}
                        <div class="relative mb-6">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-[#1363C6] to-[#0d4a94] rounded-full opacity-20 blur-xl">
                            </div>
                            <div id="modalTestimonialPhoto"
                                class="relative w-40 h-40 rounded-full shadow-2xl border-4 border-white dark:border-gray-800 
                                overflow-hidden bg-gradient-to-br from-[#1363C6] to-[#0d4a94] 
                                flex items-center justify-center">
                            </div>
                        </div>

                        {{-- Name & Position (Mobile Only) --}}
                        <div class="md:hidden text-center mb-6 w-full">
                            <h2 id="modalTestimonialNameMobile" class="text-2xl font-extrabold text-gray-900 dark:text-white mb-2">
                            </h2>
                            <p id="modalTestimonialPositionMobile"
                                class="text-sm text-[#1363C6] dark:text-[#4a8dd8] font-semibold"></p>
                        </div>

                        {{-- Rating Stars --}}
                        <div class="w-full">
                            <p
                                class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide text-center mb-3">
                                Rating
                            </p>
                            <div id="modalTestimonialRating" class="flex items-center justify-center gap-1"></div>
                        </div>

                        {{-- Featured Badge --}}
                        <div id="modalTestimonialFeatured" class="mt-4 hidden">
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-sm font-bold rounded-full">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                Featured
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Right: Info Section --}}
                <div class="md:w-3/5 p-8 flex flex-col overflow-hidden">
                    {{-- Name & Position (Desktop) --}}
                    <div class="hidden md:block mb-6">
                        <h2 id="modalTestimonialName" class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2"></h2>
                        <p id="modalTestimonialPosition" class="text-lg text-[#1363C6] dark:text-[#4a8dd8] font-semibold"></p>
                        <div class="w-16 h-0.5 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] rounded-full mt-2"></div>
                    </div>

                    {{-- Message Section (Scrollable) --}}
                    <div class="flex-1 overflow-y-auto pr-2">
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 mb-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-[#1363C6]/10 dark:bg-[#1363C6]/20 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-[#1363C6] dark:text-[#4a8dd8]" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Testimonial</h3>
                            </div>
                            <div id="modalTestimonialMessage"
                                class="text-[15px] leading-[26px] text-gray-600 dark:text-gray-400 space-y-3 italic">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const testimonials = {!! $allTestimonialsJson !!};
            const modal = document.getElementById('testimonialModal');
            const closeBtn = document.getElementById('closeTestimonialModal');

            // Open modal when clicking on testimonial cards
            document.querySelectorAll('#{{ $sectionId }} .testimonial-card, #{{ $sectionId }} .testimonial-card-marquee').forEach(card => {
                card.addEventListener('click', () => {
                    const testimonialId = card.dataset.testimonialId;
                    const testimonial = testimonials.find(t => t.id == testimonialId);

                    if (testimonial) {
                        // Set name and position
                        document.getElementById('modalTestimonialName').textContent = testimonial.name || '';
                        document.getElementById('modalTestimonialNameMobile').textContent = testimonial.name || '';
                        
                        const position = [testimonial.position, testimonial.company].filter(Boolean).join(' at ');
                        document.getElementById('modalTestimonialPosition').textContent = position;
                        document.getElementById('modalTestimonialPositionMobile').textContent = position;
                        
                        // Set message
                        document.getElementById('modalTestimonialMessage').textContent = `"${testimonial.message}"`;

                        // Set photo
                        const photoDiv = document.getElementById('modalTestimonialPhoto');
                        if (testimonial.photo) {
                            photoDiv.innerHTML =
                                `<img src="/storage/${testimonial.photo}" alt="${testimonial.name}" class="w-full h-full object-cover" loading="lazy" decoding="async">`;
                        } else {
                            photoDiv.innerHTML =
                                `<span class="text-4xl font-bold text-white">${(testimonial.name || 'U').charAt(0)}</span>`;
                        }

                        // Set rating stars
                        const ratingDiv = document.getElementById('modalTestimonialRating');
                        ratingDiv.innerHTML = '';
                        for (let i = 1; i <= 5; i++) {
                            const starClass = i <= testimonial.rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-700';
                            ratingDiv.innerHTML += `
                                <svg class="w-6 h-6 ${starClass}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            `;
                        }

                        // Show/hide featured badge
                        const featuredBadge = document.getElementById('modalTestimonialFeatured');
                        if (testimonial.is_featured) {
                            featuredBadge.classList.remove('hidden');
                        } else {
                            featuredBadge.classList.add('hidden');
                        }

                        // Show modal with animation
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.style.overflow = 'hidden';

                        gsap.fromTo('.modal-content', {
                            opacity: 0,
                            scale: 0.9,
                            y: 30
                        }, {
                            opacity: 1,
                            scale: 1,
                            y: 0,
                            duration: 0.4,
                            ease: 'power3.out'
                        });
                    }
                });
            });

            // Close modal
            function closeModal() {
                gsap.to('.modal-content', {
                    opacity: 0,
                    scale: 0.9,
                    y: 30,
                    duration: 0.3,
                    ease: 'power2.in',
                    onComplete: () => {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        document.body.style.overflow = 'auto';
                    }
                });
            }

            closeBtn.addEventListener('click', closeModal);

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // ESC key to close
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>
@endpush
