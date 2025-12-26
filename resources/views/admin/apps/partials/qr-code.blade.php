<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">QR Code</h3>
        @if (!$app->qrCode)
            <form action="{{ route('apps.qr.generate', $app) }}" method="POST">
                @csrf
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                    <i class="fas fa-qrcode"></i>
                    Generate QR Code
                </button>
            </form>
        @endif
    </div>

    @if ($app->qrCode)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 text-center">
                @if ($app->qrCode->qr_code_path)
                    <img src="{{ $app->qrCode->getQrCodeUrl() }}" alt="QR Code"
                        class="w-64 h-64 mx-auto mb-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg">
                @else
                    <div class="w-64 h-64 mx-auto mb-4 flex items-center justify-center bg-gray-100 dark:bg-gray-900 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                        <p class="text-gray-500 dark:text-gray-400">QR Code will be generated</p>
                    </div>
                @endif

                <div class="flex items-center justify-center gap-2">
                    @if ($app->qrCode->qr_code_path)
                        <a href="{{ $app->qrCode->getQrCodeUrl() }}" download
                            class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                            <i class="fas fa-download"></i>
                            Download QR Code
                        </a>
                    @endif

                    <form action="{{ route('apps.qr.regenerate', $app) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                            <i class="fas fa-sync-alt"></i>
                            Regenerate
                        </button>
                    </form>
                </div>
            </div>

            <div class="space-y-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">QR Code Statistics</h4>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Scans:</span>
                            <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $app->qrCode->scan_count }}</span>
                        </div>

                        @if ($app->qrCode->last_scanned_at)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Last Scanned:</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $app->qrCode->last_scanned_at->diffForHumans() }}
                                </span>
                            </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Status:</span>
                            @if ($app->qrCode->is_active)
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-medium">
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Scan URL</h4>
                    <div class="flex items-center gap-2">
                        <input type="text" readonly value="{{ $app->qrCode->getScanUrl() }}"
                            class="flex-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-300">
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $app->qrCode->getScanUrl() }}')"
                            class="p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                            title="Copy URL">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Users scanning this QR code will be redirected to this URL
                    </p>
                </div>

                <div class="rounded-xl border p-4"
                    style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.05) 0%, rgba(13, 74, 153, 0.1) 100%); border-color: rgba(19, 99, 198, 0.2);">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center"
                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="text-sm font-semibold text-gray-800 dark:text-gray-100 mb-1">How it works</h5>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                When users scan this QR code, they'll be automatically redirected to the appropriate download link based on their device (Android, iOS, or Desktop).
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4"
                style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%);">
                <svg class="w-8 h-8" style="color: #1363C6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No QR Code yet</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-4">Generate a QR code for easy app distribution</p>
        </div>
    @endif
</div>
