@props(['allServicesJson', 'sectionId'])

<div id="serviceModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/80 backdrop-blur-sm">

    {{-- Modal Container --}}
    <div class="relative w-full max-w-4xl max-h-[90vh] modal-content">

        {{-- Close Button - TOP RIGHT --}}
        <button id="closeServiceModal"
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

                {{-- Left: Image/Icon Section --}}
                <div
                    class="md:w-2/5 bg-gradient-to-br from-[#1363C6]/10 via-[#1363C6]/5 to-transparent 
                    dark:from-[#1363C6]/20 dark:via-[#1363C6]/10 dark:to-transparent 
                    p-8 flex flex-col items-center justify-center relative">

                    {{-- Decorative circles --}}
                    <div class="absolute top-4 right-4 w-24 h-24 bg-[#1363C6]/10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-4 left-4 w-32 h-32 bg-[#0d4a94]/10 rounded-full blur-2xl"></div>

                    {{-- Service Icon Background --}}
                    <div class="absolute top-8 left-8 opacity-5">
                        <svg class="w-32 h-32 text-[#1363C6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <div class="relative z-10 flex flex-col items-center w-full">
                        {{-- Image/Icon --}}
                        <div class="relative mb-6">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-[#1363C6] to-[#0d4a94] rounded-2xl opacity-20 blur-xl">
                            </div>
                            <div id="modalServiceImage"
                                class="relative w-48 h-48 rounded-2xl shadow-2xl border-4 border-white dark:border-gray-800 
                                overflow-hidden bg-gradient-to-br from-[#1363C6]/10 to-[#0d4a94]/10 
                                flex items-center justify-center">
                            </div>
                        </div>

                        {{-- Title (Mobile Only) --}}
                        <div class="md:hidden text-center mb-6 w-full">
                            <h2 id="modalServiceTitleMobile" class="text-2xl font-extrabold text-gray-900 dark:text-white mb-2">
                            </h2>
                        </div>

                        {{-- Featured Badge --}}
                        <div id="modalServiceFeatured" class="mt-4 hidden">
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
                    {{-- Title (Desktop) --}}
                    <div class="hidden md:block mb-6">
                        <h2 id="modalServiceTitle" class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2"></h2>
                        <div class="w-16 h-0.5 bg-gradient-to-r from-[#1363C6] to-[#0d4a94] rounded-full mt-2"></div>
                    </div>

                    {{-- Description Section (Scrollable) --}}
                    <div class="flex-1 overflow-y-auto pr-2">
                        <div class="space-y-4">
                            {{-- Short Description --}}
                            <div id="modalServiceShortDesc" class="text-lg text-gray-700 dark:text-gray-300 font-medium"></div>
                            
                            {{-- Full Description --}}
                            <div class="flex items-center gap-2 mb-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div
                                    class="w-8 h-8 rounded-lg bg-[#1363C6]/10 dark:bg-[#1363C6]/20 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-[#1363C6] dark:text-[#4a8dd8]" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Details</h3>
                            </div>
                            <div id="modalServiceDescription"
                                class="text-[15px] leading-[26px] text-gray-600 dark:text-gray-400 space-y-3">
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
            const services = {!! $allServicesJson !!};
            const modal = document.getElementById('serviceModal');
            const closeBtn = document.getElementById('closeServiceModal');

            // Open modal when clicking on service cards
            document.querySelectorAll('#{{ $sectionId }} .service-card, #{{ $sectionId }} .service-slide').forEach(card => {
                card.addEventListener('click', () => {
                    const serviceId = card.dataset.serviceId;
                    const service = services.find(s => s.id == serviceId);

                    if (service) {
                        // Set title
                        document.getElementById('modalServiceTitle').textContent = service.title || '';
                        document.getElementById('modalServiceTitleMobile').textContent = service.title || '';
                        
                        // Set short description
                        document.getElementById('modalServiceShortDesc').textContent = service.short_description || '';
                        
                        // Set full description
                        document.getElementById('modalServiceDescription').innerHTML = service.description || 'No detailed description available.';

                        // Set image/icon
                        const imageDiv = document.getElementById('modalServiceImage');
                        if (service.image) {
                            imageDiv.innerHTML =
                                `<img src="/storage/${service.image}" alt="${service.title}" class="w-full h-full object-cover" loading="lazy" decoding="async">`;
                        } else if (service.icon) {
                            imageDiv.innerHTML =
                                `<i class="${service.icon} text-6xl text-[#1363C6]"></i>`;
                        } else {
                            imageDiv.innerHTML =
                                `<svg class="w-24 h-24 text-[#1363C6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>`;
                        }

                        // Show/hide featured badge
                        const featuredBadge = document.getElementById('modalServiceFeatured');
                        if (service.is_featured) {
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
