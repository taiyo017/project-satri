<?php

namespace App\Services;

use Illuminate\Http\Request;

class DeviceDetectionService
{
    public function detectPlatform(Request $request): string
    {
        $userAgent = $request->userAgent();

        if ($this->isAndroid($userAgent)) {
            return 'android';
        }

        if ($this->isIOS($userAgent)) {
            return 'ios';
        }

        if ($this->isMobile($userAgent)) {
            return 'mobile';
        }

        return 'desktop';
    }

    public function isAndroid(string $userAgent): bool
    {
        return stripos($userAgent, 'Android') !== false;
    }

    public function isIOS(string $userAgent): bool
    {
        return stripos($userAgent, 'iPhone') !== false || 
               stripos($userAgent, 'iPad') !== false || 
               stripos($userAgent, 'iPod') !== false;
    }

    public function isMobile(string $userAgent): bool
    {
        return preg_match('/(android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini)/i', $userAgent);
    }

    public function getDeviceInfo(Request $request): array
    {
        $userAgent = $request->userAgent();
        
        return [
            'platform' => $this->detectPlatform($request),
            'user_agent' => $userAgent,
            'ip_address' => $request->ip(),
            'device_type' => $this->isMobile($userAgent) ? 'mobile' : 'desktop',
            'browser' => $this->getBrowser($userAgent),
            'os' => $this->getOS($userAgent),
        ];
    }

    private function getBrowser(string $userAgent): string
    {
        if (stripos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (stripos($userAgent, 'Safari') !== false) return 'Safari';
        if (stripos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (stripos($userAgent, 'Edge') !== false) return 'Edge';
        if (stripos($userAgent, 'Opera') !== false) return 'Opera';
        
        return 'Unknown';
    }

    private function getOS(string $userAgent): string
    {
        if (stripos($userAgent, 'Windows') !== false) return 'Windows';
        if (stripos($userAgent, 'Mac OS') !== false) return 'macOS';
        if (stripos($userAgent, 'Linux') !== false) return 'Linux';
        if (stripos($userAgent, 'Android') !== false) return 'Android';
        if (stripos($userAgent, 'iOS') !== false) return 'iOS';
        
        return 'Unknown';
    }
}
