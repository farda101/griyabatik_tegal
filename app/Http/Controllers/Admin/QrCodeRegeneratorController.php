<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\StockBatik;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;

class QrCodeRegeneratorController
{
    /**
     * Regenerate QR codes from SVG to PNG format
     * This is a helper controller to fix existing QR codes
     */
    public function regenerateAllQrCodes()
    {
        try {
            $stockBatiks = StockBatik::whereNotNull('qr_code')->get();
            $regeneratedCount = 0;
            $failedCount = 0;

            foreach ($stockBatiks as $stockBatik) {
                try {
                    // Skip if already PNG
                    if (str_ends_with($stockBatik->qr_code, '.png')) {
                        continue;
                    }

                    // Delete old SVG file
                    if (Storage::disk('public')->exists($stockBatik->qr_code)) {
                        Storage::disk('public')->delete($stockBatik->qr_code);
                    }

                    // Generate new PNG QR code
                    $qrCodeData = json_encode([
                        'kode' => $stockBatik->kode_batik,
                        'nama' => $stockBatik->nama_batik,
                        'pengrajin' => $stockBatik->pengrajin->nama_pengrajin ?? 'N/A',
                        'harga_jual' => $stockBatik->harga_jual,
                        'tanggal_masuk' => $stockBatik->tanggal_masuk->format('Y-m-d'),
                    ]);

                    $qrCodeFileName = 'batik_' . $stockBatik->kode_batik . '.png';
                    $qrCodePath = 'qr_codes/batik/' . $qrCodeFileName;

                    $qrCodeImage = QrCode::size(300)
                        ->errorCorrection('H')
                        ->format('png')
                        ->generate($qrCodeData);

                    Storage::disk('public')->put($qrCodePath, $qrCodeImage);
                    $stockBatik->update(['qr_code' => $qrCodePath]);

                    $regeneratedCount++;
                } catch (\Exception $e) {
                    Log::error("Failed to regenerate QR code for batik {$stockBatik->id}: " . $e->getMessage());
                    $failedCount++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "QR Code regeneration complete. Regenerated: {$regeneratedCount}, Failed: {$failedCount}",
                'regenerated' => $regeneratedCount,
                'failed' => $failedCount,
            ]);
        } catch (\Exception $e) {
            Log::error('QR Code regeneration failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to regenerate QR codes: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Regenerate single QR code
     */
    public function regenerateSingleQrCode(StockBatik $stockBatik)
    {
        try {
            // Delete old file if exists
            if ($stockBatik->qr_code && Storage::disk('public')->exists($stockBatik->qr_code)) {
                Storage::disk('public')->delete($stockBatik->qr_code);
            }

            // Generate new PNG QR code
            $qrCodeData = json_encode([
                'kode' => $stockBatik->kode_batik,
                'nama' => $stockBatik->nama_batik,
                'pengrajin' => $stockBatik->pengrajin->nama_pengrajin ?? 'N/A',
                'harga_jual' => $stockBatik->harga_jual,
                'tanggal_masuk' => $stockBatik->tanggal_masuk->format('Y-m-d'),
            ]);

            $qrCodeFileName = 'batik_' . $stockBatik->kode_batik . '.png';
            $qrCodePath = 'qr_codes/batik/' . $qrCodeFileName;

            $qrCodeImage = QrCode::size(300)
                ->errorCorrection('H')
                ->format('png')
                ->generate($qrCodeData);

            Storage::disk('public')->put($qrCodePath, $qrCodeImage);
            $stockBatik->update(['qr_code' => $qrCodePath]);

            return response()->json([
                'success' => true,
                'message' => 'QR Code successfully regenerated in PNG format',
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to regenerate QR code for batik {$stockBatik->id}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to regenerate QR code: ' . $e->getMessage(),
            ], 500);
        }
    }
}
