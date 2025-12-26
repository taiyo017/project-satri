<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\AppVersion;
use Illuminate\Http\Request;

class AppVersionController extends Controller
{
    public function store(Request $request, App $app)
    {
        $data = $request->validate([
            'version_number' => 'required|string|max:255',
            'version_code' => 'nullable|string|max:255',
            'release_notes' => 'nullable|string',
            'changelog' => 'nullable|string',
            'is_latest' => 'sometimes|boolean',
            'status' => 'required|in:active,inactive,beta',
            'released_at' => 'nullable|date',
        ]);

        $data['app_id'] = $app->id;
        $data['is_latest'] = $request->has('is_latest');
        $data['released_at'] = $data['released_at'] ?? now();

        $version = AppVersion::create($data);

        return redirect()->route('apps.show', $app)
            ->with('success', 'Version added successfully!');
    }

    public function update(Request $request, App $app, AppVersion $version)
    {
        $data = $request->validate([
            'version_number' => 'required|string|max:255',
            'version_code' => 'nullable|string|max:255',
            'release_notes' => 'nullable|string',
            'changelog' => 'nullable|string',
            'is_latest' => 'sometimes|boolean',
            'status' => 'required|in:active,inactive,beta',
            'released_at' => 'nullable|date',
        ]);

        $data['is_latest'] = $request->has('is_latest');

        $version->update($data);

        return redirect()->route('apps.show', $app)
            ->with('success', 'Version updated successfully!');
    }

    public function destroy(App $app, AppVersion $version)
    {
        $version->delete();

        return redirect()->route('apps.show', $app)
            ->with('success', 'Version deleted successfully!');
    }
}
