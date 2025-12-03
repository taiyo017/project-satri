<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
@php
    $setting = \App\Models\Setting::first();
    $siteName = $setting->site_name ?? 'Satri Technologies';
    $pageTitle = isset($title) ? "$title | $siteName" : $siteName;
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- Primary Meta Tags --}}
    <title>{{ $pageTitle }}</title>
    <meta name="title" content="{{ $pageTitle }}">
    <meta name="description"
        content="{{ $metaDescription ?? ($setting->meta_description ?? 'Professional technology solutions and services') }}">
    <meta name="keywords"
        content="{{ $metaKeywords ?? ($setting->meta_keywords ?? 'technology, software, solutions') }}">
    <meta name="author" content="{{ $siteName }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png"
        href="{{ $setting->favicon_path ? asset('storage/' . $setting->favicon_path) : asset('images/default-favicon.png') }}">
    <link rel="apple-touch-icon"
        href="{{ $setting->favicon_path ? asset('storage/' . $setting->favicon_path) : asset('images/default-favicon.png') }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription ?? ($setting->meta_description ?? '') }}">
    <meta property="og:image"
        content="{{ $ogImage ?? ($setting->og_image ? asset('storage/' . $setting->og_image) : asset('images/og-default.jpg')) }}">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $pageTitle }}">
    <meta property="twitter:description" content="{{ $metaDescription ?? ($setting->meta_description ?? '') }}">
    <meta property="twitter:image"
        content="{{ $ogImage ?? ($setting->og_image ? asset('storage/' . $setting->og_image) : asset('images/og-default.jpg')) }}">

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Preconnect for Performance --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- CSS --}}
    @vite(['resources/css/app.css'])

    {{-- Theme Color --}}
    <meta name="theme-color" content="#1363C6">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* Particle Canvas */
        #particles-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        /* Gradient Mesh Background */
        .gradient-mesh-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background:
                radial-gradient(at 27% 37%, rgba(19, 99, 198, 0.12) 0px, transparent 50%),
                radial-gradient(at 97% 21%, rgba(76, 175, 249, 0.10) 0px, transparent 50%),
                radial-gradient(at 52% 99%, rgba(19, 99, 198, 0.08) 0px, transparent 50%),
                radial-gradient(at 10% 29%, rgba(76, 175, 249, 0.12) 0px, transparent 50%),
                radial-gradient(at 90% 75%, rgba(19, 99, 198, 0.10) 0px, transparent 50%);
            animation: mesh-movement 20s ease infinite;
        }

        .dark .gradient-mesh-bg {
            background:
                radial-gradient(at 27% 37%, rgba(19, 99, 198, 0.08) 0px, transparent 50%),
                radial-gradient(at 97% 21%, rgba(76, 175, 249, 0.06) 0px, transparent 50%),
                radial-gradient(at 52% 99%, rgba(19, 99, 198, 0.05) 0px, transparent 50%),
                radial-gradient(at 10% 29%, rgba(76, 175, 249, 0.08) 0px, transparent 50%);
        }

        @keyframes mesh-movement {

            0%,
            100% {
                filter: hue-rotate(0deg) brightness(1);
                transform: scale(1);
            }

            50% {
                filter: hue-rotate(10deg) brightness(1.08);
                transform: scale(1.03);
            }
        }

        /* Scroll Reveal - Instant reveal on scroll */
        .scroll-reveal {
            opacity: 1;
            transform: translateY(0);
        }

        .scroll-reveal.animate-on-scroll {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.4s ease-out, transform 0.4s ease-out;
        }

        .scroll-reveal.animate-on-scroll.revealed {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
    @stack('styles')
</head>

<body x-data="{ darkMode: false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode') || 'false');
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode }"
    class="antialiased transition-colors duration-500 overflow-x-hidden">

    @include('partials.preloader')

    {{-- Fixed Background Elements --}}
    <div class="gradient-mesh-bg opacity-50 dark:opacity-30"></div>
    <canvas id="particles-canvas" class="opacity-50 dark:opacity-30"></canvas>

    {{-- Main Site Wrapper --}}
    <div class="relative z-10 flex flex-col min-h-screen">

        {{-- Header --}}
        <header class="sticky top-0 z-50 w-full">
            @include('frontend.partials.navbar')
        </header>

        {{-- Main Content --}}
        <main id="main-content" class="flex-1 w-full">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="fixed top-20 right-4 z-50 max-w-md animate-[fadeInUp_0.6s_ease-out]">
                    <div class="p-4 bg-green-600 text-white rounded-xl shadow-lg shadow-green-600/30" role="alert">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-sm">{{ session('success') }}</p>
                            </div>
                            <button onclick="this.parentElement.parentElement.parentElement.remove()"
                                class="ml-3 text-white/80 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="fixed top-20 right-4 z-50 max-w-md animate-[fadeInUp_0.6s_ease-out]">
                    <div class="p-4 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-xl shadow-lg shadow-red-600/30"
                        role="alert">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-sm">{{ session('error') }}</p>
                            </div>
                            <button onclick="this.parentElement.parentElement.parentElement.remove()"
                                class="ml-3 text-white/80 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Page Content --}}
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="w-full mt-auto">
            @include('frontend.partials.footer')
        </footer>
    </div>

    {{-- Back to Top Button --}}
    <button id="back-to-top"
        class="fixed bottom-8 right-8 z-40 p-2 bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-2xl shadow-lg shadow-blue-600/30 opacity-0 invisible transition-all duration-300 hover:scale-110 hover:shadow-xl hover:shadow-blue-600/40 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 group"
        aria-label="Back to top">
        <svg class="w-4 h-4 transform group-hover:-translate-y-1 transition-transform" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    {{-- JavaScript --}}
    @vite(['resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    @stack('scripts')

    <script>
        // Optimized Particle System with RequestAnimationFrame
        (function() {
            const canvas = document.getElementById('particles-canvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d', {
                alpha: true
            });
            let particles = [];
            let animationFrameId;
            const mouse = {
                x: null,
                y: null,
                radius: 150
            };

            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
                initParticles();
            }

            window.addEventListener('resize', resizeCanvas);
            window.addEventListener('mousemove', (e) => {
                mouse.x = e.x;
                mouse.y = e.y;
            });
            window.addEventListener('mouseout', () => {
                mouse.x = null;
                mouse.y = null;
            });

            class Particle {
                constructor(x, y) {
                    this.x = x;
                    this.y = y;
                    this.size = Math.random() * 2.5 + 0.8;
                    this.baseX = x;
                    this.baseY = y;
                    this.density = Math.random() * 30 + 1;
                    const opacity = Math.random() * 0.4 + 0.2;
                    this.color = Math.random() < 0.6 ?
                        `rgba(19, 99, 198, ${opacity})` :
                        `rgba(76, 175, 249, ${opacity})`;
                }

                draw() {
                    ctx.fillStyle = this.color;
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }

                update() {
                    if (mouse.x !== null) {
                        const dx = mouse.x - this.x;
                        const dy = mouse.y - this.y;
                        const distance = Math.sqrt(dx * dx + dy * dy);

                        if (distance < mouse.radius) {
                            const force = (mouse.radius - distance) / mouse.radius;
                            const directionX = (dx / distance) * force * this.density;
                            const directionY = (dy / distance) * force * this.density;
                            this.x -= directionX;
                            this.y -= directionY;
                            return;
                        }
                    }

                    if (this.x !== this.baseX) this.x -= (this.x - this.baseX) / 10;
                    if (this.y !== this.baseY) this.y -= (this.y - this.baseY) / 10;
                }
            }

            function initParticles() {
                particles = [];
                const numberOfParticles = Math.floor((canvas.width * canvas.height) / 15000);
                for (let i = 0; i < numberOfParticles; i++) {
                    particles.push(new Particle(
                        Math.random() * canvas.width,
                        Math.random() * canvas.height
                    ));
                }
            }

            function connectParticles() {
                const maxDistance = (canvas.width / 7) * (canvas.height / 7);
                for (let a = 0; a < particles.length; a++) {
                    for (let b = a + 1; b < particles.length; b++) {
                        const dx = particles[a].x - particles[b].x;
                        const dy = particles[a].y - particles[b].y;
                        const distance = dx * dx + dy * dy;

                        if (distance < maxDistance) {
                            const opacity = 1 - (distance / 20000);
                            ctx.strokeStyle = `rgba(19, 99, 198, ${opacity * 0.35})`;
                            ctx.lineWidth = 1;
                            ctx.beginPath();
                            ctx.moveTo(particles[a].x, particles[a].y);
                            ctx.lineTo(particles[b].x, particles[b].y);
                            ctx.stroke();
                        }
                    }
                }
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(particle => {
                    particle.draw();
                    particle.update();
                });
                connectParticles();
                animationFrameId = requestAnimationFrame(animate);
            }

            resizeCanvas();
            animate();
        })();

        // Optimized Back to Top Button
        (function() {
            const backToTopBtn = document.getElementById('back-to-top');
            if (!backToTopBtn) return;

            let ticking = false;

            function updateButtonVisibility() {
                if (window.pageYOffset > 400) {
                    backToTopBtn.classList.remove('opacity-0', 'invisible');
                    backToTopBtn.classList.add('opacity-100', 'visible');
                } else {
                    backToTopBtn.classList.add('opacity-0', 'invisible');
                    backToTopBtn.classList.remove('opacity-100', 'visible');
                }
                ticking = false;
            }

            window.addEventListener('scroll', () => {
                if (!ticking) {
                    window.requestAnimationFrame(updateButtonVisibility);
                    ticking = true;
                }
            }, {
                passive: true
            });

            backToTopBtn.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        })();

        // Auto-dismiss Flash Messages
        setTimeout(() => {
            document.querySelectorAll('[role="alert"]').forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(100%)';
                setTimeout(() => alert.parentElement?.remove(), 500);
            });
        }, 5000);

        // Optimized Scroll Reveal with Immediate Rendering
        (function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.01,
                rootMargin: '100px 0px'
            });

            // Observe elements immediately when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => {
                    document.querySelectorAll('.scroll-reveal').forEach(el => {
                        el.classList.add('animate-on-scroll');
                        observer.observe(el);
                    });
                });
            } else {
                document.querySelectorAll('.scroll-reveal').forEach(el => {
                    el.classList.add('animate-on-scroll');
                    observer.observe(el);
                });
            }
        })();
    </script>
</body>

</html>
