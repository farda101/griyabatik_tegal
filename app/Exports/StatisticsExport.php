<?php

namespace App\Exports;

use App\Models\Penjualan;
use App\Models\Reservasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class StatisticsExport implements WithMultipleSheets
{
    protected $startDate;
    protected $endDate;

    public function __construct(string $startDate = null, string $endDate = null)
    {
        $this->startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : null;
        $this->endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : null;
    }

    public function sheets(): array
    {
        return [
            'Penjualan Bulanan' => new MonthlySalesSheet($this->startDate, $this->endDate),
            'Penjualan Harian' => new DailySalesSheet($this->startDate, $this->endDate),
            'Status Reservasi' => new ReservationStatusSheet(),
        ];
    }
}

class MonthlySalesSheet implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $data = [];
        
        if ($this->startDate && $this->endDate) {
            $startMonth = Carbon::parse($this->startDate)->startOfMonth();
            $endMonth = Carbon::parse($this->endDate)->endOfMonth();
            $currentMonth = $startMonth->copy();
            
            while ($currentMonth <= $endMonth) {
                $sales = Penjualan::whereBetween('tanggal_penjualan', [
                    $currentMonth->copy()->startOfMonth(),
                    $currentMonth->copy()->endOfMonth()
                ])->sum('total_harga');
                
                $data[] = [
                    'Bulan' => $currentMonth->format('M Y'),
                    'Total Penjualan (Rp)' => $sales,
                    'Jumlah Transaksi' => Penjualan::whereBetween('tanggal_penjualan', [
                        $currentMonth->copy()->startOfMonth(),
                        $currentMonth->copy()->endOfMonth()
                    ])->count(),
                ];
                $currentMonth->addMonth();
            }
        } else {
            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $sales = Penjualan::whereMonth('tanggal_penjualan', $date->month)
                    ->whereYear('tanggal_penjualan', $date->year)
                    ->sum('total_harga');
                $count = Penjualan::whereMonth('tanggal_penjualan', $date->month)
                    ->whereYear('tanggal_penjualan', $date->year)
                    ->count();
                
                $data[] = [
                    'Bulan' => $date->format('M Y'),
                    'Total Penjualan (Rp)' => $sales,
                    'Jumlah Transaksi' => $count,
                ];
            }
        }
        
        return collect($data);
    }

    public function headings(): array
    {
        return ['Bulan', 'Total Penjualan (Rp)', 'Jumlah Transaksi'];
    }
}

class DailySalesSheet implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $data = [];
        
        if ($this->startDate && $this->endDate) {
            $startDay = Carbon::parse($this->startDate);
            $endDay = Carbon::parse($this->endDate);
            $daysDiff = $startDay->diffInDays($endDay);
            
            if ($daysDiff > 30) {
                $startDay = $endDay->copy()->subDays(29);
            }
            
            $currentDay = $startDay->copy();
            while ($currentDay <= $endDay) {
                $sales = Penjualan::whereDate('tanggal_penjualan', $currentDay)->sum('total_harga');
                $count = Penjualan::whereDate('tanggal_penjualan', $currentDay)->count();
                
                $data[] = [
                    'Tanggal' => $currentDay->format('d M Y'),
                    'Total Penjualan (Rp)' => $sales,
                    'Jumlah Transaksi' => $count,
                ];
                $currentDay->addDay();
            }
        } else {
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $sales = Penjualan::whereDate('tanggal_penjualan', $date)->sum('total_harga');
                $count = Penjualan::whereDate('tanggal_penjualan', $date)->count();
                
                $data[] = [
                    'Tanggal' => $date->format('d M Y'),
                    'Total Penjualan (Rp)' => $sales,
                    'Jumlah Transaksi' => $count,
                ];
            }
        }
        
        return collect($data);
    }

    public function headings(): array
    {
        return ['Tanggal', 'Total Penjualan (Rp)', 'Jumlah Transaksi'];
    }
}

class ReservationStatusSheet implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return collect([
            [
                'Status' => 'Pending',
                'Jumlah' => Reservasi::where('status_pembayaran', 'pending')->count(),
            ],
            [
                'Status' => 'Lunas',
                'Jumlah' => Reservasi::where('status_pembayaran', 'paid')->count(),
            ],
            [
                'Status' => 'Gagal',
                'Jumlah' => Reservasi::where('status_pembayaran', 'failed')->count(),
            ],
            [
                'Status' => 'Kadaluarsa',
                'Jumlah' => Reservasi::where('status_pembayaran', 'expired')->count(),
            ],
        ]);
    }

    public function headings(): array
    {
        return ['Status', 'Jumlah'];
    }
}
