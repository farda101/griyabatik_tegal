<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StockBatik;
use Illuminate\Support\Facades\Storage;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QROutputInterface;
use Illuminate\Support\Facades\Log;

class RegenerateQrCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qrcode:regenerate {--batch=all : all|batik_code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate QR codes from SVG to PNG format for better scanner compatibility';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $batch = $this->option('batch');

        if ($batch === 'all') {
            return $this->regenerateAllQrCodes();
        } else {
            return $this->regenerateSingleQrCode($batch);
        }
    }

    /**
     * Regenerate all QR codes
     */
    private function regenerateAllQrCodes()
    {
        $this->info('Starting QR code regeneration for all stock batik...');

        try {
            // Eager load pengrajin relationship to avoid N+1 queries and missing data
            $stockBatiks = StockBatik::whereNotNull('qr_code')->with('pengrajin')->get();
            $total = $stockBatiks->count();
            $regeneratedCount = 0;
            $failedCount = 0;
            $alreadyPngCount = 0;

            if ($total === 0) {
                $this->warn('No stock batik found with QR codes.');
                return 0;
            }

            $bar = $this->output->createProgressBar($total);
            $bar->start();

            foreach ($stockBatiks as $stockBatik) {
                try {
                    // Skip if already PNG
                    if (str_ends_with($stockBatik->qr_code, '.png')) {
                        $bar->advance();
                        $alreadyPngCount++;
                        continue;
                    }

                    // Delete old SVG file
                    if (Storage::disk('public')->exists($stockBatik->qr_code)) {
                        Storage::disk('public')->delete($stockBatik->qr_code);
                    }

                    // Generate new PNG QR code
                    $pengrajinNama = $stockBatik->pengrajin ? $stockBatik->pengrajin->nama_pengrajin : 'N/A';
                    $tanggalMasuk = $stockBatik->tanggal_masuk ? $stockBatik->tanggal_masuk->format('Y-m-d') : date('Y-m-d');
                    
                    $qrCodeData = json_encode([
                        'kode' => $stockBatik->kode_batik,
                        'nama' => $stockBatik->nama_batik,
                        'pengrajin' => $pengrajinNama,
                        'harga_jual' => $stockBatik->harga_jual,
                        'tanggal_masuk' => $tanggalMasuk,
                    ]);

                    $qrCodeFileName = 'batik_' . $stockBatik->kode_batik . '.png';
                    $qrCodePath = 'qr_codes/batik/' . $qrCodeFileName;

                    // Generate QR code using chillerlan library (no Imagick required)
                    $options = new QROptions([
                        'version'      => QRCode::VERSION_AUTO,
                        'eccLevel'     => QRCode::ECC_H,
                        'outputType'   => QROutputInterface::GDIMAGE_PNG,
                        'imageBase64'  => false,
                        'scale'        => 10,
                    ]);
                    
                    $qrCode = new QRCode($options);
                    $qrCodeImage = $qrCode->render($qrCodeData);

                    Storage::disk('public')->put($qrCodePath, $qrCodeImage);
                    $stockBatik->update(['qr_code' => $qrCodePath]);

                    $regeneratedCount++;
                } catch (\Exception $e) {
                    Log::error("Failed to regenerate QR code for batik {$stockBatik->id}: " . $e->getMessage());
                    $failedCount++;
                }

                $bar->advance();
            }

            $bar->finish();

            $this->newLine();
            $this->info("✓ QR Code regeneration complete!");
            $this->line("  • Regenerated: {$regeneratedCount}");
            $this->line("  • Failed: {$failedCount}");
            $this->line("  • Already PNG: {$alreadyPngCount}");

            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to regenerate QR codes: ' . $e->getMessage());
            Log::error('QR Code regeneration failed: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Regenerate single QR code by batik code
     */
    private function regenerateSingleQrCode($batchCode)
    {
        $this->info("Regenerating QR code for batik code: {$batchCode}");

        try {
            $stockBatik = StockBatik::where('kode_batik', $batchCode)->with('pengrajin')->first();

            if (!$stockBatik) {
                $this->error("Stock batik with code '{$batchCode}' not found.");
                return 1;
            }

            // Delete old file if exists
            if ($stockBatik->qr_code && Storage::disk('public')->exists($stockBatik->qr_code)) {
                Storage::disk('public')->delete($stockBatik->qr_code);
            }

            // Generate new PNG QR code
            $pengrajinNama = $stockBatik->pengrajin ? $stockBatik->pengrajin->nama_pengrajin : 'N/A';
            $tanggalMasuk = $stockBatik->tanggal_masuk ? $stockBatik->tanggal_masuk->format('Y-m-d') : date('Y-m-d');
            
            $qrCodeData = json_encode([
                'kode' => $stockBatik->kode_batik,
                'nama' => $stockBatik->nama_batik,
                'pengrajin' => $pengrajinNama,
                'harga_jual' => $stockBatik->harga_jual,
                'tanggal_masuk' => $tanggalMasuk,
            ]);

            $qrCodeFileName = 'batik_' . $stockBatik->kode_batik . '.png';
            $qrCodePath = 'qr_codes/batik/' . $qrCodeFileName;

            // Generate QR code using chillerlan library (no Imagick required)
            $options = new QROptions([
                'version'      => QRCode::VERSION_AUTO,
                'eccLevel'     => QRCode::ECC_H,
                'outputType'   => QROutputInterface::GDIMAGE_PNG,
                'imageBase64'  => false,
                'scale'        => 10,
            ]);
            
            $qrCode = new QRCode($options);
            $qrCodeImage = $qrCode->render($qrCodeData);

            Storage::disk('public')->put($qrCodePath, $qrCodeImage);
            $stockBatik->update(['qr_code' => $qrCodePath]);

            $this->info("✓ QR code successfully regenerated for: {$batchCode}");
            $this->line("  • File: {$qrCodePath}");
            $this->line("  • Format: PNG");
            $this->line("  • Size: 300x300px");
            $this->line("  • Error Correction: High");

            return 0;
        } catch (\Exception $e) {
            $this->error("Failed to regenerate QR code: " . $e->getMessage());
            Log::error("Failed to regenerate QR code for batik {$batchCode}: " . $e->getMessage());
            return 1;
        }
    }
}
