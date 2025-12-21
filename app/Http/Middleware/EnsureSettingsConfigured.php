<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;

class EnsureSettingsConfigured
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip check for settings routes and logout
        if ($request->routeIs('settings.*') || $request->routeIs('logout') || $request->routeIs('profile.*')) {
            return $next($request);
        }

        // Check if settings exist and are configured
        $setting = Setting::first();
        
        // Define required fields that must be filled
        $requiredFields = ['site_name', 'email'];
        
        // Check if settings don't exist or required fields are empty
        if (!$setting || $this->hasEmptyRequiredFields($setting, $requiredFields)) {
            // Only allow access to dashboard and settings
            if (!$request->routeIs('dashboard')) {
                return redirect()->route('settings.index')
                    ->with('warning', 'Please complete the site configuration before accessing other features.');
            }
        }

        return $next($request);
    }

    /**
     * Check if any required fields are empty
     */
    private function hasEmptyRequiredFields($setting, array $requiredFields): bool
    {
        foreach ($requiredFields as $field) {
            if (empty($setting->$field)) {
                return true;
            }
        }
        return false;
    }
}
