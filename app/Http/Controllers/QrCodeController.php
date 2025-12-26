<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeController extends Controller
{
    public function generate(App $app)
    {
        if ($app->qrCode) {
            return redirect()->route('apps.show', $app)
                ->with('error', 'QR Code already exists. Use regenerate instead.');
        }

        $qrCode = QrCode::create([
            'app_id' => $app->id,
            'is_active' => true,
        ]);

        $this->generateQrCodeImage($qrCode);

        return redirect()->route('apps.show', $app)
            ->with('success', 'QR Code generated successfully!');
    }

    public function regenerate(App $app)
    {
        if (!$app->qrCode) {
            return redirect()->route('apps.show', $app)
                ->with('error', 'No QR Code exists. Generate one first.');
        }

        $this->generateQrCodeImage($app->qrCode);

        return redirect()->route('apps.show', $app)
            ->with('success', 'QR Code regenerated successfully!');
    }

    public function scan($token)
    {
        $qrCode = QrCode::where('token', $token)->where('is_active', true)->firstOrFail();
        
        $qrCode->incrementScanCount();

        // Redirect directly to download route instead of show page
        return redirect()->route('frontend.apps.download', $qrCode->app->slug);
    }

    private function generateQrCodeImage(QrCode $qrCode)
    {
        $url = $qrCode->getScanUrl();
        
        try {
            // Use endroid/qr-code v5 which works with GD (no imagick required)
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($url)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(ErrorCorrectionLevel::High)
                ->size(512)
                ->margin(10)
                ->build();

            $filename = 'qr-codes/' . $qrCode->token . '.png';
            Storage::disk('public')->put($filename, $result->getString());

            $qrCode->update(['qr_code_path' => $filename]);
        } catch (\Exception $e) {
            // If QR generation fails, log error but don't break the flow
            \Log::error('QR Code generation failed: ' . $e->getMessage());
            throw new \Exception('Failed to generate QR code. Please ensure GD extension is installed.');
        }
    }
}
