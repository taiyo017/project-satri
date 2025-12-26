<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Screenshots</h3>
        <button type="button" onclick="document.getElementById('add-screenshots-form').classList.toggle('hidden')"
            class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
            style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
            <i class="fas fa-plus"></i>
            Upload Screenshots
        </button>
    </div>

    <div id="add-screenshots-form" class="hidden bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
        <form action="{{ route('apps.screenshots.store', $app) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <x-input-label for="device_type" value="Device Type *" class="text-gray-700 dark:text-gray-300" />
                    <select id="device_type" name="device_type" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-lg shadow-sm">
                        <option value="mobile">Mobile</option>
                        <option value="tablet">Tablet</option>
                        <option value="desktop">Desktop</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="screenshots" value="Screenshots (Max 10) *" class="text-gray-700 dark:text-gray-300" />
                    <input type="file" id="screenshots" name="screenshots[]" multiple accept="image/*" required
                        class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-900 focus:outline-none">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG up to 5MB each</p>
                </div>
            </div>

            <div class="mt-4 flex items-center gap-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                    style="background: linear-gradient(135deg, #1363C6 0%, #0d4a99 100%);">
                    <i class="fas fa-upload"></i>
                    Upload Screenshots
                </button>
                <button type="button" onclick="document.getElementById('add-screenshots-form').classList.add('hidden')"
                    class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                    Cancel
                </button>
            </div>
        </form>
    </div>

    @if ($app->screenshots->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($app->screenshots as $screenshot)
                <div class="relative group">
                    <img src="{{ $screenshot->getImageUrl() }}" alt="Screenshot"
                        class="w-full h-48 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-700">
                    
                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <form action="{{ route('apps.screenshots.destroy', [$app, $screenshot]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>

                    <div class="absolute bottom-2 left-2">
                        <span class="inline-block px-2 py-1 rounded bg-black/50 text-white text-xs font-medium capitalize">
                            {{ $screenshot->device_type }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4"
                style="background: linear-gradient(135deg, rgba(19, 99, 198, 0.1) 0%, rgba(13, 74, 153, 0.1) 100%);">
                <i class="fas fa-images text-3xl" style="color: #1363C6;"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No screenshots yet</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-4">Upload screenshots to showcase your app</p>
        </div>
    @endif
</div>
