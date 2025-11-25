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
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-******" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- CSS --}}
    @vite(['resources/css/app.css'])

    {{-- Additional Styles --}}

    {{-- Theme Color --}}
    <meta name="theme-color" content="#1363C6">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        :root {
            --primary: #1363C6;
            --primary-dark: #0D4A8F;
            --primary-light: #4CAFF9;
            --primary-rgb: 19, 99, 198;
        }

        body {
            font-size: 16px;
            line-height: 26px;
            letter-spacing: -0.01em;
            overflow-x: hidden;
        }

        /* Interactive Particle Background */
        #particles-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            opacity: 0.5;
        }

        .dark #particles-canvas {
            opacity: 0.3;
        }

        /* Animated Gradient Mesh Background */
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

        /* Content wrapper with proper z-index */
        .content-layer {
            position: relative;
            z-index: 1;
        }

        /* Typography Scale with Proper Spacing */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        /* Page Title: 40px, line-height 48px, margin-top 32px, margin-bottom 24px */
        h1 {
            font-size: 40px;
            line-height: 48px;
            margin-top: 32px;
            margin-bottom: 24px;
        }

        /* Subtitle: 20px, line-height 28px, margin 16px top/bottom */
        h2 {
            font-size: 20px;
            line-height: 28px;
            margin-top: 16px;
            margin-bottom: 16px;
            font-weight: 600;
        }

        /* Body Text: 16px, line-height 26px, margin-bottom 16px */
        p,
        .body-text {
            font-size: 16px;
            line-height: 26px;
            margin-bottom: 16px;
        }

        /* Nav Links: 15px, line-height 22px, padding 10px 16px */
        .nav-link {
            font-size: 15px;
            line-height: 22px;
            padding: 10px 16px;
            font-weight: 500;
        }

        /* Button Text: 14px, line-height 20px, padding 10px 18px */
        .btn-text {
            font-size: 14px;
            line-height: 20px;
            padding: 10px 18px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 32px;
                line-height: 40px;
                margin-top: 24px;
                margin-bottom: 16px;
            }

            h2 {
                font-size: 18px;
                line-height: 26px;
            }
        }

        .gradient-primary {
            background: linear-gradient(135deg, #1363C6 0%, #4CAFF9 100%);
        }

        .gradient-hero {
            background: linear-gradient(135deg, #1363C6 0%, #2BC4F3 100%);
        }

        /* Enhanced Glass Effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(19, 99, 198, 0.15);
            box-shadow:
                0 4px 16px rgba(19, 99, 198, 0.08),
                0 2px 8px rgba(19, 99, 198, 0.06);
        }

        .dark .glass-effect {
            background: rgba(17, 24, 39, 0.75);
            border: 1px solid rgba(76, 175, 249, 0.15);
        }

        /* Enhanced Shadows with Primary Color Blend */
        .smooth-shadow {
            box-shadow:
                0 2px 8px -2px rgba(19, 99, 198, 0.12),
                0 4px 16px -4px rgba(19, 99, 198, 0.08),
                0 1px 3px rgba(19, 99, 198, 0.1);
        }

        .smooth-shadow-lg {
            box-shadow:
                0 4px 16px -4px rgba(19, 99, 198, 0.14),
                0 8px 32px -8px rgba(19, 99, 198, 0.12),
                0 16px 48px -12px rgba(19, 99, 198, 0.08);
        }

        .smooth-shadow-xl {
            box-shadow:
                0 8px 24px -6px rgba(19, 99, 198, 0.18),
                0 16px 48px -12px rgba(19, 99, 198, 0.14),
                0 24px 64px -16px rgba(19, 99, 198, 0.1);
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Enhanced Interactive Cards with Primary Shadow */
        .interactive-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            background: white;
            border-radius: 20px;
            border: 1px solid rgba(19, 99, 198, 0.08);
            box-shadow:
                0 2px 8px rgba(19, 99, 198, 0.06),
                0 4px 16px rgba(19, 99, 198, 0.04),
                0 1px 3px rgba(19, 99, 198, 0.08);
        }

        .interactive-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 2px;
            background: linear-gradient(135deg, #1363C6, #4CAFF9);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.4s;
        }

        .interactive-card:hover {
            transform: translateY(-8px) scale(1.01);
            border-color: rgba(19, 99, 198, 0.2);
            box-shadow:
                0 8px 24px rgba(19, 99, 198, 0.16),
                0 16px 48px rgba(19, 99, 198, 0.12),
                0 4px 12px rgba(19, 99, 198, 0.14);
        }

        .interactive-card:hover::before {
            opacity: 1;
        }

        .dark .interactive-card {
            background: rgba(17, 24, 39, 0.9);
            border: 1px solid rgba(76, 175, 249, 0.15);
        }

        /* Glow effect for buttons */
        .btn-glow {
            position: relative;
            overflow: hidden;
        }

        .btn-glow::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-glow:hover::before {
            width: 300px;
            height: 300px;
        }

        .text-balance {
            text-wrap: balance;
        }

        .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Pulse animation for CTA */
        @keyframes pulse-ring {
            0% {
                transform: scale(0.9);
                opacity: 1;
            }

            100% {
                transform: scale(1.3);
                opacity: 0;
            }
        }

        .pulse-ring {
            animation: pulse-ring 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Button Enhancements with Primary Gradient Shadow */
        .btn-primary-enhanced {
            background: linear-gradient(135deg, #1363C6 0%, #4CAFF9 100%);
            box-shadow:
                0 4px 14px rgba(19, 99, 198, 0.3),
                0 2px 8px rgba(19, 99, 198, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary-enhanced:hover {
            transform: translateY(-2px);
            box-shadow:
                0 8px 24px rgba(19, 99, 198, 0.4),
                0 4px 12px rgba(19, 99, 198, 0.3);
        }
    </style>
    @stack('styles')
</head>

<body x-data="{
    darkMode: false,
}" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }"
    class="antialiased transition-colors duration-500">

    @include('partials.preloader')

    <div class="gradient-mesh-bg"></div>

    {{-- Interactive Particle Canvas --}}
    <canvas id="particles-canvas"></canvas>

    <div class="content-layer flex flex-col min-h-screen">

        <header class="sticky top-0 z-50 w-full">
            @include('frontend.partials.navbar')
        </header>

        <main id="main-content" class="flex-grow w-full">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="fixed top-20 right-4 z-50 max-w-md animate-fade-in-up">
                    <div class="p-4 bg-green-600 text-white rounded-xl smooth-shadow-lg" role="alert">
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
                            <button onclick="this.parentElement.parentElement.remove()"
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
                <div class="fixed top-20 right-4 z-50 max-w-md animate-fade-in-up">
                    <div class="p-4 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-xl smooth-shadow-lg"
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
                            <button onclick="this.parentElement.parentElement.remove()"
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
        class="fixed bottom-8 right-8 z-40 btn-text gradient-primary text-white rounded-2xl smooth-shadow-lg opacity-0 invisible transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 group btn-glow"
        aria-label="Back to top" style="padding: 16px;">
        <svg class="w-6 h-6 transform group-hover:-translate-y-1 transition-transform" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    {{-- JavaScript --}}
    @vite(['resources/js/app.js'])

    {{-- Additional Scripts --}}
    @stack('scripts')

    <script>
        // Interactive Particle System with Primary Color Theme
        const canvas = document.getElementById('particles-canvas');
        const ctx = canvas.getContext('2d');

        let particles = [];
        let mouse = {
            x: null,
            y: null,
            radius: 150
        };

        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            initParticles();
        });

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
                this.baseX = this.x;
                this.baseY = this.y;
                this.density = Math.random() * 30 + 1;

                // Primary color themed particles
                const opacity = Math.random() * 0.4 + 0.2;
                const colorVariant = Math.random();
                if (colorVariant < 0.6) {
                    this.color = `rgba(19, 99, 198, ${opacity})`; // Primary blue
                } else {
                    this.color = `rgba(76, 175, 249, ${opacity})`; // Light blue
                }
            }

            draw() {
                ctx.fillStyle = this.color;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.closePath();
                ctx.fill();
            }

            update() {
                let dx = mouse.x - this.x;
                let dy = mouse.y - this.y;
                let distance = Math.sqrt(dx * dx + dy * dy);
                let forceDirectionX = dx / distance;
                let forceDirectionY = dy / distance;
                let maxDistance = mouse.radius;
                let force = (maxDistance - distance) / maxDistance;
                let directionX = forceDirectionX * force * this.density;
                let directionY = forceDirectionY * force * this.density;

                if (distance < mouse.radius) {
                    this.x -= directionX;
                    this.y -= directionY;
                } else {
                    if (this.x !== this.baseX) {
                        let dx = this.x - this.baseX;
                        this.x -= dx / 10;
                    }
                    if (this.y !== this.baseY) {
                        let dy = this.y - this.baseY;
                        this.y -= dy / 10;
                    }
                }
            }
        }

        function initParticles() {
            particles = [];
            let numberOfParticles = (canvas.width * canvas.height) / 15000;
            for (let i = 0; i < numberOfParticles; i++) {
                let x = Math.random() * canvas.width;
                let y = Math.random() * canvas.height;
                particles.push(new Particle(x, y));
            }
        }

        function connectParticles() {
            for (let a = 0; a < particles.length; a++) {
                for (let b = a; b < particles.length; b++) {
                    let distance = ((particles[a].x - particles[b].x) * (particles[a].x - particles[b].x)) +
                        ((particles[a].y - particles[b].y) * (particles[a].y - particles[b].y));

                    if (distance < (canvas.width / 7) * (canvas.height / 7)) {
                        const opacity = 1 - (distance / 20000);

                        // Primary color gradient lines
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

        function animateParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            for (let i = 0; i < particles.length; i++) {
                particles[i].draw();
                particles[i].update();
            }
            connectParticles();
            requestAnimationFrame(animateParticles);
        }

        initParticles();
        animateParticles();

        // Back to top button
        const backToTopBtn = document.getElementById('back-to-top');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 400) {
                backToTopBtn.classList.remove('opacity-0', 'invisible');
                backToTopBtn.classList.add('opacity-100', 'visible');
            } else {
                backToTopBtn.classList.add('opacity-0', 'invisible');
                backToTopBtn.classList.remove('opacity-100', 'visible');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Auto-dismiss alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(100%)';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Scroll reveal animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.scroll-reveal').forEach(el => {
                observer.observe(el);
            });
        });
    </script>

</body>

</html>
