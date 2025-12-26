<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Versions & Files</h3>
        <button type="button" onclick="document.getElementById('add-version-form').classList.toggle('hidden')"
            class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
            <i class="fas fa-plus"></i>
            Add Version
        </button>
    </div>

    <div id="add-version-form" class="hidden bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
        <form action="{{ route('apps.versions.store', $app) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="version_number" value="Version Number *" class="text-gray-700 dark:text-gray-300" />
                    <x-text-input id="version_number" name="version_number" type="text" class="mt-1 block w-full"
                        placeholder="1.0.0" required />
                </div>
                <div>
                    <x-input-label for="version_code" value="Version Code" class="text-gray-700 dark:text-gray-300" />
                    <x-text-input id="version_code" name="version_code" type="text" class="mt-1 block w-full"
                        placeholder="100" />
                </div>
                <div>
                    <x-input-label for="status" value="Status *" class="text-gray-700 dark:text-gray-300" />
                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm">
                        <option value="active">Active</option>
                        <option value="beta">Beta</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="released_at" value="Release Date" class="text-gray-700 dark:text-gray-300" />
                    <x-text-input id="released_at" name="released_at" type="date" class="mt-1 block w-full"
                        :value="date('Y-m-d')" />
                </div>
                <div class="md:col-span-2">
                    <x-input-label for="release_notes" value="Release Notes" class="text-gray-700 dark:text-gray-300" />
                    <textarea id="release_notes" name="release_notes" rows="3"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm resize-none"
                        placeholder="What's new in this version..."></textarea>
                </div>
                <div class="md:col-span-2 flex items-center gap-2">
                    <input type="checkbox" id="is_latest" name="is_latest" value="1" checked
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                    <label for="is_latest" class="text-sm text-gray-700 dark:text-gray-300">
                        Mark as latest version
                    </label>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                    <i class="fas fa-save"></i>
                    Save Version
                </button>
                <button type="button" onclick="document.getElementById('add-version-form').classList.add('hidden')"
                    class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                    Cancel
                </button>
            </div>
        </form>
    </div>

    @forelse ($app->versions as $version)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">v{{ $version->version_number }}</h4>
                    @if ($version->is_latest)
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs font-medium">
                            Latest
                        </span>
                    @endif
                    @if ($version->status === 'beta')
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-medium">
                            Beta
                        </span>
                    @endif
                </div>
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $version->released_at ? $version->released_at->format('M d, Y') : 'Not released' }}
                </span>
            </div>

            <div class="p-6 space-y-4">
                @if ($version->release_notes)
                    <div>
                        <h5 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Release Notes:</h5>
                        <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $version->release_notes }}</p>
                    </div>
                @endif

                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h5 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Files:</h5>
                        <button type="button" onclick="document.getElementById('add-file-{{ $version->id }}').classList.toggle('hidden')"
                            class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                            + Add File
                        </button>
                    </div>

                    <div id="add-file-{{ $version->id }}" class="hidden mb-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg p-5 border border-gray-200 dark:border-gray-700">
                        <div x-data="{ distributionMethod: null }">
                            <form action="{{ route('apps.versions.files.store', [$app, $version]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Step 1: Choose Distribution Method -->
                                <div x-show="!distributionMethod" class="space-y-4">
                                    <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                                        <i class="fas fa-question-circle text-blue-600"></i>
                                        How is your app distributed?
                                    </h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <!-- Option 1: Published on Store -->
                                        <button type="button" @click="distributionMethod = 'store'"
                                            class="group relative p-5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:border-green-500 dark:hover:border-green-500 transition-all duration-200 hover:shadow-lg text-left">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0 w-12 h-12 rounded-lg flex items-center justify-center bg-green-100 dark:bg-green-900/30 group-hover:scale-110 transition-transform">
                                                    <i class="fas fa-store text-green-600 dark:text-green-400 text-xl"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="font-semibold text-gray-900 dark:text-white mb-1 flex items-center gap-2">
                                                        Published on Store
                                                        <i class="fas fa-check-circle text-green-600 text-sm"></i>
                                                    </h5>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                                                        App is live on Play Store or App Store. I'll provide the store URL.
                                                    </p>
                                                </div>
                                            </div>
                                        </button>

                                        <!-- Option 2: Self-Hosted -->
                                        <button type="button" @click="distributionMethod = 'upload'"
                                            class="group relative p-5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 hover:shadow-lg text-left">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0 w-12 h-12 rounded-lg flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 group-hover:scale-110 transition-transform">
                                                    <i class="fas fa-upload text-blue-600 dark:text-blue-400 text-xl"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="font-semibold text-gray-900 dark:text-white mb-1 flex items-center gap-2">
                                                        Self-Hosted File
                                                        <i class="fas fa-server text-blue-600 text-sm"></i>
                                                    </h5>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                                                        Not published yet. I'll upload APK/IPA file to host it here.
                                                    </p>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 2: Store URL Form -->
                                <div x-show="distributionMethod === 'store'" style="display: none;" class="space-y-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                            <i class="fas fa-store text-green-600"></i>
                                            Store URL Details
                                        </h4>
                                        <button type="button" @click="distributionMethod = null"
                                            class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 flex items-center gap-1">
                                            <i class="fas fa-arrow-left"></i>
                                            Change
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <x-input-label for="platform_store_{{ $version->id }}" value="Platform *" class="text-gray-700 dark:text-gray-300" />
                                            <select id="platform_store_{{ $version->id }}" name="platform"
                                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm text-sm">
                                                <option value="android">Android (Play Store)</option>
                                                <option value="ios">iOS (App Store)</option>
                                                <option value="web">Web App</option>
                                            </select>
                                        </div>
                                        <div>
                                            <x-input-label for="file_type_store_{{ $version->id }}" value="Type *" class="text-gray-700 dark:text-gray-300" />
                                            <select id="file_type_store_{{ $version->id }}" name="file_type"
                                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm text-sm">
                                                <option value="url">Store URL</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <x-input-label for="store_url_{{ $version->id }}" class="text-gray-700 dark:text-gray-300">
                                            <span class="flex items-center gap-2">
                                                <i class="fas fa-link text-green-600"></i>
                                                Store URL *
                                            </span>
                                        </x-input-label>
                                        <x-text-input id="store_url_{{ $version->id }}" name="store_url" type="url" class="mt-1 block w-full text-sm"
                                            placeholder="https://play.google.com/store/apps/details?id=com.example.app" />
                                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400 flex items-start gap-2">
                                            <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                            <span>
                                                <strong>Examples:</strong><br>
                                                • Play Store: https://play.google.com/store/apps/details?id=...<br>
                                                • App Store: https://apps.apple.com/app/...
                                            </span>
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-2 pt-2">
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                                            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                            <i class="fas fa-check"></i>
                                            Add Store Link
                                        </button>
                                        <button type="button" onclick="document.getElementById('add-file-{{ $version->id }}').classList.add('hidden'); setTimeout(() => { this.closest('[x-data]').__x.$data.distributionMethod = null; }, 300);"
                                            class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 3: File Upload Form -->
                                <div x-show="distributionMethod === 'upload'" style="display: none;" class="space-y-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                            <i class="fas fa-upload text-blue-600"></i>
                                            Upload File Details
                                        </h4>
                                        <button type="button" @click="distributionMethod = null"
                                            class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 flex items-center gap-1">
                                            <i class="fas fa-arrow-left"></i>
                                            Change
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <x-input-label for="platform_upload_{{ $version->id }}" value="Platform *" class="text-gray-700 dark:text-gray-300" />
                                            <select id="platform_upload_{{ $version->id }}" name="platform"
                                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm text-sm">
                                                <option value="android">Android (APK)</option>
                                                <option value="ios">iOS (IPA)</option>
                                                <option value="desktop">Desktop</option>
                                            </select>
                                        </div>
                                        <div>
                                            <x-input-label for="file_type_upload_{{ $version->id }}" value="File Type *" class="text-gray-700 dark:text-gray-300" />
                                            <select id="file_type_upload_{{ $version->id }}" name="file_type"
                                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm text-sm">
                                                <option value="apk">APK File</option>
                                                <option value="ipa">IPA File</option>
                                                <option value="bundle">Bundle</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <x-input-label for="file_{{ $version->id }}" class="text-gray-700 dark:text-gray-300">
                                            <span class="flex items-center gap-2">
                                                <i class="fas fa-file-archive text-blue-600"></i>
                                                Upload File *
                                            </span>
                                        </x-input-label>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-blue-500 dark:hover:border-blue-500 transition-colors">
                                            <div class="space-y-1 text-center">
                                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 dark:text-gray-600 mb-3"></i>
                                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                                    <label for="file_{{ $version->id }}"
                                                        class="relative cursor-pointer rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none">
                                                        <span>Upload a file</span>
                                                        <input id="file_{{ $version->id }}" name="file" type="file" class="sr-only">
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    APK, IPA up to 500MB
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 pt-2">
                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                                            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                                            <i class="fas fa-upload"></i>
                                            Upload File
                                        </button>
                                        <button type="button" onclick="document.getElementById('add-file-{{ $version->id }}').classList.add('hidden'); setTimeout(() => { this.closest('[x-data]').__x.$data.distributionMethod = null; }, 300);"
                                            class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @forelse ($version->files as $file)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                                    style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%);">
                                    @if ($file->platform === 'android')
                                        <i class="fab fa-android text-xl" style="color: #1363C6;"></i>
                                    @elseif ($file->platform === 'ios')
                                        <i class="fab fa-apple text-xl" style="color: #1363C6;"></i>
                                    @elseif ($file->platform === 'web')
                                        <i class="fas fa-globe text-xl" style="color: #1363C6;"></i>
                                    @else
                                        <i class="fas fa-desktop text-xl" style="color: #1363C6;"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white capitalize">{{ $file->platform }} - {{ $file->file_type }}</p>
                                    @if ($file->store_url)
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium">
                                                <i class="fas fa-check-circle"></i>
                                                Published on Store
                                            </span>
                                            <a href="{{ $file->store_url }}" target="_blank" class="text-xs text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                                                View Store <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        </div>
                                    @elseif ($file->file_path)
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs font-medium">
                                                <i class="fas fa-file-archive"></i>
                                                Hosted File
                                            </span>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $file->getFormattedFileSize() }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <form action="{{ route('apps.versions.files.destroy', [$app, $version, $file]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Delete file">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No files added yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4"
                style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%);">
                <i class="fas fa-code-branch text-3xl" style="color: #1363C6;"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No versions yet</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-4">Create your first version to start managing app files</p>
        </div>
    @endforelse
</div>
