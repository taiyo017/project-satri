@props(['allMessagesJson', 'sectionId'])

<div id="internMessageModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/80 backdrop-blur-sm">

    {{-- Modal Container --}}
    <div class="relative w-full max-w-4xl max-h-[90vh] modal-content">

        {{-- Close Button - TOP RIGHT --}}
        <button id="closeInternMessageModal"
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

                {{-- Left: Photo Section --}}
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
                            <div id="modalInternPhoto"
                                class="relative w-40 h-40 rounded-full shadow-2xl border-4 border-white dark:border-gray-800 
                                overflow-hidden bg-gradient-to-br from-[#1363C6] to-[#0d4a94] 
                                flex items-center justify-center">
                            </div>
                        </div>

                        {{-- Name & Designation (Mobile Only) --}}
                        <div class="md:hidden text-center mb-6 w-full">
                            <h2 id="modalInternNameMobile" class="text-2xl font-extrabold text-gray-900 dark:text-white mb-2">
                            </h2>
                            <p id="modalInternDesignationMobile"
                                class="text-sm text-[#1363C6] dark:text-[#4a8dd8] font-semibold"></p>
                        </div>

                        {{-- Social Links --}}
                        <div class="w-full mt-4">
                            <p
                                class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide text-center mb-3">
                                Connect
                            </p>
                            <div id="modalInternSocialLinks" class="flex items-center justify-center gap-2 flex-wrap"></div>
                        </div>

                        {{-- Bio Badge --}}
                        <div id="modalInternBioSection" class="mt-6 w-full hidden">
                            <p
                                class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide text-center mb-2">
                                About
                            </p>
                            <div id="modalInternBio"
                                class="text-xs text-gray-600 dark:text-gray-400 text-center leading-relaxed px-2">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Info Section --}}
                <div class="md:w-3/5 p-8 flex flex-col overflow-hidden">
                    {{-- Name & Designation (Desktop) --}}
                    <div class="hidden md:block mb-6">
                        <h2 id="modalInternName" class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2"></h2>
                        <p id="modalInternDesignation" class="text-lg text-[#1363C6] dark:text-[#4a8dd8] font-semibold"></p>
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
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Message</h3>
                            </div>
                            <div id="modalInternMessage"
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
            const internMessages = @json($allMessagesJson);
            const modal = document.getElementById('internMessageModal');
            const closeBtn = document.getElementById('closeInternMessageModal');

            // Platform icon mapping
            const platformIcons = {
                facebook: 'fab fa-facebook-f',
                twitter: 'fab fa-twitter',
                linkedin: 'fab fa-linkedin-in',
                instagram: 'fab fa-instagram',
                github: 'fab fa-github',
                youtube: 'fab fa-youtube'
            };

            // Open modal when clicking on message cards
            document.querySelectorAll('#{{ $sectionId }} .message-card, #{{ $sectionId }} .message-card-marquee').forEach(card => {
                card.addEventListener('click', () => {
                    const memberId = card.dataset.memberId;
                    const member = internMessages.find(m => m.id == memberId);

                    if (member) {
                        // Set name and designation
                        document.getElementById('modalInternName').textContent = member.name || '';
                        document.getElementById('modalInternNameMobile').textContent = member.name || '';
                        document.getElementById('modalInternDesignation').textContent = member.designation || '';
                        document.getElementById('modalInternDesignationMobile').textContent = member.designation || '';
                        
                        // Set message
                        document.getElementById('modalInternMessage').textContent = `"${member.message}"`;

                        // Set photo
                        const photoDiv = document.getElementById('modalInternPhoto');
                        if (member.photo) {
                            photoDiv.innerHTML =
                                `<img src="/storage/${member.photo}" alt="${member.name}" class="w-full h-full object-cover" loading="lazy" decoding="async">`;
                        } else {
                            photoDiv.innerHTML =
                                `<span class="text-4xl font-bold text-white">${(member.name || 'U').charAt(0)}</span>`;
                        }

                        // Set social links
                        const socialDiv = document.getElementById('modalInternSocialLinks');
                        socialDiv.innerHTML = '';
                        if (member.social_links && member.social_links.length > 0) {
                            member.social_links.forEach(link => {
                                const iconClass = platformIcons[link.platform.toLowerCase()] || 'fas fa-link';
                                socialDiv.innerHTML += `
                                    <a href="${link.url}" target="_blank" rel="noopener" 
                                        onclick="event.stopPropagation()" 
                                        class="w-10 h-10 flex items-center justify-center rounded-lg 
                                        bg-[#1363C6]/10 dark:bg-[#1363C6]/20 text-[#1363C6] dark:text-[#4a8dd8] 
                                        hover:bg-[#1363C6] hover:text-white hover:scale-110 
                                        transition-all duration-300" 
                                        title="${link.platform}">
                                        <i class="${iconClass} text-base"></i>
                                    </a>
                                `;
                            });
                        } else {
                            socialDiv.innerHTML = '<p class="text-xs text-gray-500 dark:text-gray-400">No social links</p>';
                        }

                        // Set bio if available
                        const bioSection = document.getElementById('modalInternBioSection');
                        const bioDiv = document.getElementById('modalInternBio');
                        if (member.bio && member.bio.trim() !== '') {
                            bioDiv.textContent = member.bio;
                            bioSection.classList.remove('hidden');
                        } else {
                            bioSection.classList.add('hidden');
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
