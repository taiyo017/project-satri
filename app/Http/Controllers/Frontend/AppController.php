<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\AppDownload;
use App\Services\DeviceDetectionService;
use Illuminate\Http\Request;

class AppController extends Controller
{
    protected $deviceDetection;

    public function __construct(DeviceDetectionService $deviceDetection)
    {
        $this->deviceDetection = $deviceDetection;
    }

    public function show($slug, Request $request)
    {
        $app = App::where('slug', $slug)
            ->where('status', 'active')
            ->with(['category', 'latestVersion.files', 'screenshots', 'qrCode', 'approvedReviews'])
            ->firstOrFail();

        $platform = $this->deviceDetection->detectPlatform($request);
        $deviceInfo = $this->deviceDetection->getDeviceInfo($request);

        return view('frontend.apps.show', compact('app', 'platform', 'deviceInfo'));
    }

    public function download($slug, Request $request)
    {
        $app = App::where('slug', $slug)
            ->where('status', 'active')
            ->with(['latestVersion.files'])
            ->firstOrFail();

        $platform = $this->deviceDetection->detectPlatform($request);
        $deviceInfo = $this->deviceDetection->getDeviceInfo($request);

        // Track download
        AppDownload::create([
            'app_id' => $app->id,
            'app_version_id' => $app->latestVersion?->id,
            'platform' => $platform,
            'source' => $request->query('source', 'direct'),
            'ip_address' => $deviceInfo['ip_address'],
            'user_agent' => $deviceInfo['user_agent'],
            'device_type' => $deviceInfo['device_type'],
            'browser' => $deviceInfo['browser'],
            'os' => $deviceInfo['os'],
            'referrer' => $request->header('referer'),
        ]);

        $app->incrementDownloadCount();

        // Get appropriate file for platform
        $file = $app->latestVersion?->getFileForPlatform($platform);

        if (!$file) {
            return redirect()->route('frontend.apps.show', $slug)
                ->with('error', 'No download available for your platform.');
        }

        $downloadUrl = $file->getDownloadUrl();

        if (!$downloadUrl) {
            return redirect()->route('frontend.apps.show', $slug)
                ->with('error', 'Download link not available.');
        }

        return redirect($downloadUrl);
    }

    public function index(Request $request)
    {
        $query = App::where('status', 'active')
            ->with(['category', 'latestVersion']);

        if ($request->filled('category')) {
            $query->where('app_category_id', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $apps = $query->latest()->paginate(12);
        $categories = \App\Models\AppCategory::where('is_active', true)
            ->withCount('activeApps')
            ->orderBy('order')
            ->get();

        return view('frontend.apps.index', compact('apps', 'categories'));
    }
}
