<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\AppVersion;
use App\Models\AppFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppFileController extends Controller
{
    public function store(Request $request, App $app, AppVersion $version)
    {
        $data = $request->validate([
            'platform' => 'required|in:android,ios,web,desktop',
            'file_type' => 'required|in:apk,ipa,url,bundle',
            'file' => 'nullable|file|max:512000',
            'external_url' => 'nullable|url',
            'store_url' => 'nullable|url',
        ]);

        $data['app_version_id'] = $version->id;

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file_path'] = $file->store('apps/files', 'public');
            $data['file_size'] = $file->getSize();
            $data['mime_type'] = $file->getMimeType();
        }

        // If store URL exists, it's published
        if (!empty($data['store_url'])) {
            $data['file_type'] = 'url';
        }

        AppFile::create($data);

        return redirect()->route('apps.show', $app)
            ->with('success', 'File added successfully!');
    }

    public function destroy(App $app, AppVersion $version, AppFile $file)
    {
        if ($file->file_path) {
            Storage::disk('public')->delete($file->file_path);
        }

        $file->delete();

        return redirect()->route('apps.show', $app)
            ->with('success', 'File deleted successfully!');
    }
}
