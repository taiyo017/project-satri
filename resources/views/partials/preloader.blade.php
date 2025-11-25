{{-- resources/views/components/preloader.blade.php --}}
<div x-data="preloader()" x-show="loading" x-transition:leave="transition ease-in duration-500"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-gradient-to-br from-[#1363C6] to-[#0d4a94]">

    {{-- Logo --}}
    <div class="mb-8 animate-float">
        @if ($setting?->logo_path ?? false)
            <img src="{{ asset('storage/' . $setting->logo_path) }}" alt="Logo"
                class="h-20 w-20 object-contain drop-shadow-2xl">
        @else
            <div class="h-20 w-20 bg-white rounded-2xl flex items-center justify-center shadow-2xl">
                <span class="text-3xl font-bold text-[#1363C6]">
                    {{ substr(config('app.name', 'App'), 0, 2) }}
                </span>
            </div>
        @endif
    </div>

    {{-- Spinner --}}
    <div class="relative w-24 h-24 mb-8">
        <div class="absolute inset-0 border-4 border-white/20 border-t-white rounded-full animate-spin"></div>
        <div class="absolute inset-2 border-4 border-white/10 border-r-white/60 rounded-full animate-spin-slow"></div>
    </div>

    {{-- Progress Bar --}}
    <div class="w-64 h-1.5 bg-white/10 rounded-full overflow-hidden mb-6 shadow-lg">
        <div class="h-full bg-white rounded-full transition-all duration-300 shadow-glow"
            :style="`width: ${progress}%`"></div>
    </div>

    {{-- Loading Text --}}
    <div class="text-white text-lg font-semibold tracking-widest uppercase mb-3 animate-pulse">
        Loading<span class="inline-flex ml-1 gap-1">
            <span class="w-1.5 h-1.5 bg-white rounded-full animate-bounce" style="animation-delay: 0s"></span>
            <span class="w-1.5 h-1.5 bg-white rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
            <span class="w-1.5 h-1.5 bg-white rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
        </span>
    </div>

    {{-- Percentage --}}
    <div class="text-white/70 text-sm font-mono" x-text="`${Math.floor(progress)}%`"></div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('preloader', () => ({
            loading: true,
            progress: 0,
            interval: null,

            init() {
                this.startProgress();

                // Complete when page loads
                if (document.readyState === 'complete') {
                    this.complete();
                } else {
                    window.addEventListener('load', () => this.complete());
                }

                // Fallback: force complete after 5 seconds
                setTimeout(() => {
                    if (this.loading) this.complete();
                }, 5000);
            },

            startProgress() {
                this.interval = setInterval(() => {
                    if (this.progress < 90) {
                        this.progress += Math.random() * 15;
                        if (this.progress > 90) this.progress = 90;
                    }
                }, 150);
            },

            complete() {
                clearInterval(this.interval);
                this.progress = 100;

                setTimeout(() => {
                    this.loading = false;
                    document.body.classList.add('page-loaded');
                }, 300);
            }
        }));
    });
</script>

<style>
    /* Custom animations */
    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-12px);
        }
    }

    .animate-float {
        animation: float 2s ease-in-out infinite;
    }

    .animate-spin-slow {
        animation: spin 2s linear infinite reverse;
    }

    .shadow-glow {
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.6);
    }

    /* Hide content until loaded */
    body:not(.page-loaded) .main-content {
        opacity: 0;
    }

    body.page-loaded .main-content {
        opacity: 1;
        transition: opacity 0.5s ease;
    }
</style>
