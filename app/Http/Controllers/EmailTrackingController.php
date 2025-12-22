<?php

namespace App\Http\Controllers;

use App\Models\EmailLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EmailTrackingController extends Controller
{
    public function trackOpen(string $token)
    {
        $emailLog = EmailLog::where('tracking_token', $token)->first();

        if ($emailLog) {
            $emailLog->markAsOpened();
        }

        // Return 1x1 transparent pixel
        $pixel = base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
        
        return Response::make($pixel, 200, [
            'Content-Type' => 'image/gif',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
    }

    public function trackClick(Request $request, string $token)
    {
        $emailLog = EmailLog::where('tracking_token', $token)->first();
        $url = $request->query('url');

        if ($emailLog && $url) {
            $emailLog->recordClick(
                $url,
                $request->ip(),
                $request->userAgent()
            );
        }

        return redirect($url ?? '/');
    }
}
