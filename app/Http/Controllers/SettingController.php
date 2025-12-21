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
        $validated = $request->validate([
            'site_name'         => 'nullable|string|max:255',
            'tagline'           => 'nullable|string|max:255',

            'logo_path'         => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'favicon_path'      => 'nullable|image|mimes:png,ico,jpg,jpeg,webp|max:1024',
            'og_image'          => 'nullable|image|mimes:png,jpg,jpeg,webp|max:4096',
            'twitter_image'     => 'nullable|image|mimes:png,jpg,jpeg,webp|max:4096',

            'email'             => 'nullable|email|max:255',
            'phone'             => 'nullable|string|max:50',
            'address'           => 'nullable|string|max:255',

            'facebook_url'      => 'nullable|url|max:255',
            'twitter_url'       => 'nullable|url|max:255',
            'instagram_url'     => 'nullable|url|max:255',
            'linkedin_url'      => 'nullable|url|max:255',
            'youtube_url'       => 'nullable|url|max:255',

            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'meta_keywords'     => 'nullable|string|max:255',
            'canonical_url'     => 'nullable|url|max:255',

            'og_title'          => 'nullable|string|max:255',
            'og_description'    => 'nullable|string|max:500',

            'twitter_title'     => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
        ]);

        $settings = \App\Models\Setting::first();

        $data = $validated;

        $data['show_logo'] = (int) $request->input('show_logo', 0);

        if ($request->hasFile('logo_path')) {
            $data['logo_path'] = $request->file('logo_path')->store('logos', 'public');
        }

        if ($request->hasFile('favicon_path')) {
            $data['favicon_path'] = $request->file('favicon_path')->store('favicons', 'public');
        }

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('setting_seo', 'public');
        }

        if ($request->hasFile('twitter_image')) {
            $data['twitter_image'] = $request->file('twitter_image')->store('setting_seo', 'public');
        }

        $settings
            ? $settings->update($data)
            : \App\Models\Setting::create($data);

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
