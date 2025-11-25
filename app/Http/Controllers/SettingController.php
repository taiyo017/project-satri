<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = \App\Models\Setting::first();
        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $settings = \App\Models\Setting::first();

        $data = $request->only([
            'site_name',
            'tagline',
            'logo_path',
            'favicon_path',
            'email',
            'phone',
            'address',
            'facebook_url',
            'twitter_url',
            'instagram_url',
            'linkedin_url',
            'youtube_url',
            'meta_title',
            'meta_description',
        ]);

        if ($request->hasFile('logo_path')) {
            $logoPath = $request->file('logo_path')->store('logos', 'public');
            $data['logo_path'] = $logoPath;
        }

        if ($request->hasFile('favicon_path')) {
            $faviconPath = $request->file('favicon_path')->store('favicons', 'public');
            $data['favicon_path'] = $faviconPath;
        }

        if ($settings) {
            $settings->update($data);
        } else {
            \App\Models\Setting::create($data);
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
