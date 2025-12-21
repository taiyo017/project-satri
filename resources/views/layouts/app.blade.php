@php
    $setting = \App\Models\Setting::first();
    $siteName = $setting->site_name ?? 'Satri Technologies';
    $pageTitle = isset($title) ? "$title | $siteName" : $siteName;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $pageTitle }} | DASHBOARD</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Favicon -->
    @if (!empty($setting->favicon_path))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $setting->favicon_path) }}" />
    @endif


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Styles --}}
    <style>
        .sidebar .no-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar .no-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .sidebar .no-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .sidebar .no-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 1023px) {
            .sidebar {
                box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            }
        }

        .sidebar * {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
    @stack('styles')
</head>

<body x-data="{
    loaded: true,
    darkMode: false,
    stickyMenu: false,
    sidebarToggle: false,
    scrollTop: false
}" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }"
    class="font-sans antialiased">

    <!-- ===== Preloader Start ===== -->
    @include('partials.preloader')
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        <!-- ===== Sidebar Start ===== -->
        @include('admin.dashboard.partials.sidebar')
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900">
            <!-- Small Device Overlay Start -->
            {{-- @include('partials.overlay') --}}
            <!-- Small Device Overlay End -->

            <!-- ===== Header Start ===== -->
            @include('admin.dashboard.partials.header')
            <!-- ===== Header End ===== -->

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-gray-100 dark:bg-gray-800 shadow">
                    <div class="max-w-7xl text-xs uppercase py-6 px-2 sm:px-2 lg:px-4">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- ===== Main Content Start ===== -->
            <main class="flex-1">
                <div class="p-2 mx-auto max-w-7xl md:p-6 2xl:p-10">
                    @if (isset($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </div>
            </main>
            <!-- ===== Main Content End ===== -->
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->

    {{-- Email Verification Modal --}}
    <x-email-verification-modal />

    <script>
        function sidebarMenu() {
            return {
                activeDropdown: null,

                init() {
                    const activeItem = this.$root?.querySelector('li[data-active="1"]') || document.querySelector(
                        'li[data-active="1"]');
                    if (activeItem) {
                        this.activeDropdown = parseInt(activeItem.dataset.index, 10);
                        
                        // Auto-scroll to active item
                        this.$nextTick(() => {
                            this.scrollToActiveItem(activeItem);
                        });
                    }
                },

                scrollToActiveItem(activeItem) {
                    // Get the scrollable container (sidebar menu)
                    const scrollContainer = this.$root?.querySelector('.overflow-y-auto') || 
                                          document.querySelector('.sidebar .overflow-y-auto');
                    
                    if (!scrollContainer || !activeItem) return;

                    // Calculate positions
                    const containerRect = scrollContainer.getBoundingClientRect();
                    const itemRect = activeItem.getBoundingClientRect();
                    
                    // Calculate the offset needed to center the item
                    const offset = itemRect.top - containerRect.top - (containerRect.height / 2) + (itemRect.height / 2);
                    
                    // Smooth scroll to the active item
                    scrollContainer.scrollTo({
                        top: scrollContainer.scrollTop + offset,
                        behavior: 'smooth'
                    });
                },

                toggleDropdown(index) {
                    this.activeDropdown = (this.activeDropdown === index) ? null : index;
                },

                closeAll() {
                    this.activeDropdown = null;
                }
            };
        }
    </script>
    @stack('scripts')
</body>

</html>
