<div x-data="preloader()" x-show="loading" x-transition:leave="transition ease-in duration-500"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-gradient-to-br from-[#1363C6] to-[#0d4a94]">

    <div class="relative w-24 h-24">
        <!-- Spinning ring -->
        <div class="absolute inset-0 border-4 border-white/20 border-t-white rounded-full animate-spin"></div>

        <!-- Logo -->
        <div class="absolute inset-0 flex items-center justify-center">
            @if ($setting?->logo_path ?? false)
                <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-xl p-2">
                    <img src="{{ asset('storage/' . $setting->logo_path) }}" alt="Logo"
                        class="w-full h-full object-contain">
                </div>
            @else
                <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-xl">
                    <span class="text-xl font-bold text-[#1363C6]">{{ substr(config('app.name', 'App'), 0, 2) }}</span>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('preloader', () => ({
            loading: true,
            init() {
                if (document.readyState === 'complete') {
                    this.complete();
                } else {
                    window.addEventListener('load', () => this.complete());
                }
                setTimeout(() => {
                    if (this.loading) this.complete();
                }, 5000);
            },
            complete() {
                setTimeout(() => {
                    this.loading = false;
                }, 300);
            }
        }));
    });
</script>
