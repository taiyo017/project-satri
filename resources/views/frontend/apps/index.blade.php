@extends('frontend.layouts.app')

@section('title', 'App Store - Download Center')

@section('content')
{{-- Hero Section --}}
<section class="relative bg-gradient-to-br from-[#1363C6] via-[#115CB8] to-[#0D4A8F] dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 overflow-hidden py-16 md:py-20">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(255,255,255,.15) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.15) 1px, transparent 1px); background-size: 60px 60px;"></div>
    </div>

    {{-- Gradient Orbs --}}
    <div class="absolute top-10 right-10 w-96 h-96 bg-[#4CAFF9] rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute bottom-10 left-10 w-80 h-80 bg-[#4CAFF9] rounded-full opacity-20 blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-10 md:px-16 lg:px-20 text-center">
        {{-- Badge --}}
        <div class="scroll-reveal inline-block mb-4">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/15 backdrop-blur-md shadow-lg shadow-[#1363C6]/20">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                </svg>
                <span class="text-white font-semibold uppercase tracking-wider text-xs">Download Center</span>
            </div>
        </div>

        {{-- Title --}}
        <h1 class="scroll-reveal font-bold text-white text-3xl md:text-4xl lg:text-5xl leading-tight mb-4">
            App Store
        </h1>

        {{-- Description --}}
        <p class="scroll-reveal text-white/90 text-base md:text-lg leading-relaxed max-w-2xl mx-auto mb-8">
            Download our apps for your device and get started today
        </p>

        {{-- Search Bar --}}
        <div class="scroll-reveal max-w-2xl mx-auto">
            <form method="GET" action="{{ route('frontend.apps.index') }}" class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search for apps..."
                    class="w-full px-6 py-4 pl-14 pr-32 rounded-full bg-white/95 dark:bg-gray-800/95 backdrop-blur-md text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-white/30 transition-all shadow-2xl">
                <svg class="w-5 h-5 text-gray-400 absolute left-5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <button type="submit"
                    class="absolute right-2 top-1/2 -translate-y-1/2 px-6 py-2.5 bg-[#1363C6] hover:bg-[#0d4a94] text-white font-semibold rounded-full transition-all duration-300 hover:shadow-lg text-sm">
                    Search
                </button>
            </form>
        </div>
    </div>
</section>

{{-- Main Content --}}
<section class="py-8 lg:py-12 px-6 sm:px-8 lg:px-12 bg-gradient-to-b from-gray-50 to-white dark:from-gray-950 dark:to-gray-900">
    <div class="max-w-7xl mx-auto">
        
        {{-- Category Filter --}}
        @if ($categories->count() > 0)
            <div class="mb-8" x-data="{ activeCategory: {{ request('category') ?? 'null' }} }">
                <h2 class="text-[20px] font-bold tracking-wider uppercase text-[#1363C6] dark:text-[#4a8dd8] mb-4">
                    Browse by Category
                </h2>
                
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('frontend.apps.index') }}"
                        @click="activeCategory = null"
                        :class="activeCategory === null ? 'bg-[#1363C6] text-white shadow-lg shadow-[#1363C6]/30' : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 border border-gray-200 dark:border-gray-800'"
                        class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 hover:scale-105">
                        All Apps
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('frontend.apps.index', ['category' => $category->id]) }}"
                            @click="activeCategory = {{ $category->id }}"
                            :class="activeCategory === {{ $category->id }} ? 'text-white shadow-lg' : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 border border-gray-200 dark:border-gray-800'"
                            :style="activeCategory === {{ $category->id }} ? 'background-color: {{ $category->color }}' : ''"
                            class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 hover:scale-105">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Results Header --}}
        <div class="mb-6">
            <h2 class="text-[24px] md:text-[32px] font-extrabold text-gray-900 dark:text-white mb-2">
                @if (request('search'))
                    Search Results
                @elseif (request('category'))
                    {{ $categories->find(request('category'))->name ?? 'Apps' }}
                @else
                    All Apps
                @endif
            </h2>
            <p class="text-[16px] text-gray-600 dark:text-gray-400">
                {{ $apps->total() }} {{ Str::plural('app', $apps->total()) }} available
            </p>
        </div>

        {{-- Apps Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($apps as $app)
                <div class="group">
                    <a href="{{ route('frontend.apps.show', $app->slug) }}"
                        class="block bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden hover:shadow-2xl hover:shadow-[#1363C6]/10 dark:hover:shadow-[#1363C6]/20 transition-all duration-300 hover:-translate-y-2">
                        <div class="p-6">
                            {{-- App Icon --}}
                            <div class="mb-4 flex items-start justify-between">
                                @if ($app->icon)
                                    <img src="{{ asset('storage/' . $app->icon) }}" alt="{{ $app->name }}"
                                        class="w-20 h-20 rounded-2xl object-cover border-2 border-gray-100 dark:border-gray-800 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                @else
                                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg"
                                        style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.2) 100%);">
                                        <svg class="w-10 h-10 text-[#1363C6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                @if ($app->is_featured)
                                    <div class="flex items-center gap-1 px-2 py-1 rounded-lg bg-gradient-to-r from-yellow-400 to-orange-400 text-white text-xs font-bold shadow-lg">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- App Info --}}
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-[#1363C6] dark:group-hover:text-[#4a8dd8] transition-colors line-clamp-1">
                                {{ $app->name }}
                            </h3>

                            @if ($app->category)
                                <span class="inline-block px-3 py-1 rounded-lg text-xs font-semibold mb-3"
                                    style="background-color: {{ $app->category->color }}20; color: {{ $app->category->color }};">
                                    {{ $app->category->name }}
                                </span>
                            @endif

                            @if ($app->short_description)
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2 leading-relaxed">
                                    {{ $app->short_description }}
                                </p>
                            @endif

                            {{-- Stats --}}
                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 pt-4 border-t border-gray-100 dark:border-gray-800">
                                @if ($app->latestVersion)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        v{{ $app->latestVersion->version_number }}
                                    </span>
                                @endif
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    {{ number_format($app->average_rating, 1) }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    {{ number_format($app->download_count) }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6"
                        style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.2) 100%);">
                        <svg class="w-10 h-10 text-[#1363C6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No apps available</h3>
                    <p class="text-gray-600 dark:text-gray-400">Check back later for new apps</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($apps->hasPages())
            <div class="mt-12">
                {{ $apps->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
