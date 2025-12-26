<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\AppScreenshot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppScreenshotController extends Controller
{
    public function store(Request $request, App $app)
    {
        $request->validate([
            'screenshots' => 'required|array|max:10',
            'screenshots.*' => 'image|max:5120',
            'device_type' => 'required|in:mobile,tablet,desktop',
        ]);

        $order = $app->screenshots()->max('order') ?? 0;

        foreach ($request->file('screenshots') as $screenshot) {
            $order++;
            AppScreenshot::create([
                'app_id' => $app->id,
                'image_path' => $screenshot->store('apps/screenshots', 'public'),
                'device_type' => $request->device_type,
                'order' => $order,
            ]);
        }

        return redirect()->route('apps.show', $app)
            ->with('success', 'Screenshots uploaded successfully!');
    }

    public function destroy(App $app, AppScreenshot $screenshot)
    {
        Storage::disk('public')->delete($screenshot->image_path);
        $screenshot->delete();

        return redirect()->route('apps.show', $app)
            ->with('success', 'Screenshot deleted successfully!');
    }
}
