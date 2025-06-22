<?php

namespace App\Livewire\Kasir;

use Livewire\Component;
use App\Models\StockBatik;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Http\Requests\StorePenjualanRequest; // Import Form Request
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;

class PosPenjualan extends Component
{
    protected static $layout = 'layouts.livewire';
      
    // Properti yang akan diikat ke form/input di tampilan Livewire
    public $searchBatik = '';
    public $selectedBatik = null;
    public $qtyToAdd = 1;

    public $cart = [];
    public $nama_pembeli = ''; // <--- Ubah dari $namaPembeli
    public $telepon_pembeli = ''; // <--- Ubah dari $teleponPembeli
    public $total_bayar = 0; // <--- Ubah dari $totalBayar
    public $kembalian = 0;
    public $paymentStatusMessage = '';

    // Computed properties untuk total harga otomatis
    public $total_harga = 0;

    public function mount()
    {
        $this->calculateTotals();
    }

    public function updated($propertyName)
    {
        // Pastikan total_bayar selalu berupa angka
        if ($propertyName === 'total_bayar') { // <--- Sesuaikan nama properti
            $this->total_bayar = $this->sanitizeNumericInput($this->total_bayar); // <--- Sesuaikan nama properti
        }
        
        if (in_array($propertyName, ['searchBatik'])) {
             // Validasi atau logika lain saat input ini berubah
        }
        $this->calculateTotals();
    }

    private function sanitizeNumericInput($value)
    {
        if (empty($value) || !is_numeric($value)) {
            return 0;
        }
        return (float) $value;
    }

    public function searchAndAddBatik()
    {
        $this->resetValidation();

        if (empty($this->searchBatik)) {
            $this->addError('searchBatik', 'Kode batik tidak boleh kosong.');
            return;
        }

        $batik = StockBatik::where('kode_batik', $this->searchBatik)
                            ->available()
                            ->first();

        if (!$batik) {
            $this->addError('searchBatik', 'Batik dengan kode ini tidak ditemukan atau stok kosong.');
            return;
        }

        $existingItemKey = null;
        foreach ($this->cart as $key => $item) {
            if ($item['kode_batik'] === $batik->kode_batik) {
                $existingItemKey = $key;
                break;
            }
        }

        if ($existingItemKey !== null) {
            $currentQtyInCart = $this->cart[$existingItemKey]['qty'];
            if ($currentQtyInCart + $this->qtyToAdd > $batik->qty_tersedia) {
                $this->addError('searchBatik', 'Jumlah ' . $batik->nama_batik . ' yang diminta melebihi stok tersedia. Tersedia: ' . $batik->qty_tersedia);
                return;
            }
            $this->cart[$existingItemKey]['qty'] += $this->qtyToAdd;
        } else {
            if ($this->qtyToAdd > $batik->qty_tersedia) {
                 $this->addError('searchBatik', 'Jumlah ' . $batik->nama_batik . ' yang diminta melebihi stok tersedia. Tersedia: ' . $batik->qty_tersedia);
                 return;
            }
            $this->cart[] = [
                'kode_batik' => $batik->kode_batik,
                'nama_batik' => $batik->nama_batik,
                'harga_jual' => $batik->harga_jual,
                'qty' => $this->qtyToAdd,
                'stock_batik_id' => $batik->id,
            ];
        }

        $this->searchBatik = '';
        $this->qtyToAdd = 1;
        $this->calculateTotals();
    }

    public function updateCartItemQty($index, $newQty)
    {
        $this->resetErrorBag('cart_item_qty');

        if (!isset($this->cart[$index])) {
            return;
        }

        $newQty = (int) $newQty;
        if ($newQty < 1) {
            $this->removeCartItem($index);
            return;
        }

        $batikInStock = StockBatik::find($this->cart[$index]['stock_batik_id']);

        if (!$batikInStock || $newQty > $batikInStock->qty_tersedia) {
            $this->addError('cart_item_qty.' . $index, 'Kuantitas tidak cukup. Tersedia: ' . ($batikInStock->qty_tersedia ?? 0));
            $this->cart[$index]['qty'] = $batikInStock->qty_tersedia;
            $this->calculateTotals();
            return;
        }

        $this->cart[$index]['qty'] = $newQty;
        $this->calculateTotals();
    }

    public function removeCartItem($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
        $this->calculateTotals();
    }

    protected function calculateTotals()
    {
        $this->total_harga = 0;
        foreach ($this->cart as $item) {
            $this->total_harga += $item['harga_jual'] * $item['qty'];
        }

        $totalBayar = $this->sanitizeNumericInput($this->total_bayar); // <--- Sesuaikan nama properti
        $this->kembalian = $totalBayar - $this->total_harga;

        if ($totalBayar >= $this->total_harga) {
            $this->paymentStatusMessage = '';
        } else {
            $this->paymentStatusMessage = 'Kurang: Rp ' . number_format($this->total_harga - $totalBayar, 0, ',', '.');
        }
    }

    public function processSale()
    {
        try {
            // Kita tidak perlu lagi membuat $dataToValidate secara manual.
            // Livewire akan secara otomatis mengambil properti publik yang cocok dengan rules.
            // Pastikan nama properti di Livewire ($nama_pembeli, $telepon_pembeli, $cart, $total_bayar)
            // cocok dengan nama rules di StorePenjualanRequest.

            // Dapatkan aturan dan pesan dari Form Request
            $requestRules = (new StorePenjualanRequest())->rules();
            $requestMessages = (new StorePenjualanRequest())->messages();

            // Panggil validasi langsung pada komponen Livewire.
            // Livewire akan menggunakan properti publik komponen ($this->nama_pembeli, $this->telepon_pembeli, etc.)
            $this->validate($requestRules, $requestMessages);

            // Setelah validasi, data yang tervalidasi bisa diakses langsung dari properti komponen
            // atau jika ingin lebih eksplisit:
            // $validatedData = $this->all(); // Ambil semua properti publik komponen
            // Anda mungkin perlu membersihkan properti yang tidak relevan.

            // Menggunakan properti komponen langsung
            $kasirId = Auth::id();
            $totalHargaFinal = $this->total_harga;
            $kembalianFinal = $this->kembalian;
            $tanggalPenjualan = now();

            DB::beginTransaction();

            $penjualan = Penjualan::create([
                'nomor_nota' => Penjualan::generateNomorNota(),
                'kasir_id' => $kasirId,
                'nama_pembeli' => $this->nama_pembeli ?? 'Anonim', // <--- Sesuaikan nama properti
                'telepon_pembeli' => $this->telepon_pembeli ?? null, // <--- Sesuaikan nama properti
                'total_harga' => $totalHargaFinal,
                'total_bayar' => $this->total_bayar, // <--- Sesuaikan nama properti
                'kembalian' => $kembalianFinal,
                'tanggal_penjualan' => $tanggalPenjualan,
            ]);

            // Item keranjang juga diakses langsung
            foreach ($this->cart as $itemData) { // <--- Langsung pakai $this->cart
                $batik = StockBatik::find($itemData['stock_batik_id']);

                if (!$batik) {
                    DB::rollBack();
                    Session::flash('error', 'Item batik dengan kode ' . $itemData['kode_batik'] . ' tidak ditemukan di stok.');
                    return;
                }

                if ($batik->qty_tersedia < $itemData['qty']) {
                    DB::rollBack();
                    Session::flash('error', 'Stok ' . $batik->nama_batik . ' tidak cukup. Tersedia: ' . $batik->qty_tersedia);
                    return;
                }

                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'stock_batik_id' => $batik->id,
                    'qty' => $itemData['qty'],
                    'harga_satuan' => $itemData['harga_jual'],
                    'subtotal' => $itemData['qty'] * $itemData['harga_jual'],
                ]);

                $batik->kurangiStock($itemData['qty']);
            }

            DB::commit();

            $this->reset(['cart', 'nama_pembeli', 'telepon_pembeli', 'total_bayar', 'kembalian', 'searchBatik', 'qtyToAdd']); // <--- Sesuaikan nama properti
            $this->calculateTotals();
            Session::flash('success', 'Penjualan berhasil diproses! Nomor Nota: ' . $penjualan->nomor_nota);

            $this->dispatch('saleProcessed', $penjualan->nomor_nota);
        } catch (ValidationException $e) {
            Log::error('Validasi penjualan gagal: ' . $e->getMessage(), ['errors' => $e->errors()]);
            // Livewire akan secara otomatis menampilkan error di Blade
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memproses penjualan: ' . $e->getMessage(), ['exception' => $e, 'cart_data' => $this->cart]);
            Session::flash('error', 'Terjadi kesalahan sistem saat memproses penjualan: ' . $e->getMessage());
        }
    }
}