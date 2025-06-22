<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\StockBahan; // Untuk validasi stok tersedia
use App\Models\PenggunaanBahan; // Untuk mendapatkan nilai lama

class UpdatePenggunaanBahanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya superadmin (atau kasir jika nanti diizinkan) yang bisa memperbarui penggunaan bahan
        return Auth::check() && (Auth::user()->isSuperadmin || Auth::user()->isKasir);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Dapatkan objek PenggunaanBahan yang sedang di-update melalui Route Model Binding
        $penggunaanBahan = $this->route('penggunaan_bahan'); // 'penggunaan_bahan' adalah parameter resource

        return [
            'stock_bahan_id' => 'required|exists:stock_bahans,id',
            'qty_digunakan' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($penggunaanBahan) {
                    $bahan = StockBahan::find($this->stock_bahan_id);
                    if (!$bahan) {
                        $fail('Bahan baku tidak ditemukan.');
                        return;
                    }

                    // Hitung selisih kuantitas: new_qty - old_qty
                    // Jika bahan baku diubah, atau jika qty digunakan berkurang, maka perlu tambahkan stok dulu
                    $oldQty = $penggunaanBahan->qty_digunakan;
                    $oldBahanId = $penggunaanBahan->stock_bahan_id;

                    $stokTersediaSaatIni = $bahan->qty_tersedia;

                    // Jika bahan yang dipilih berubah, kita perlu menambahkan kembali stok ke bahan lama
                    // dan cek ketersediaan di bahan baru.
                    // Untuk menyederhanakan validasi di sini, anggap saja hanya qty yang berubah.
                    // Atau jika bahan berubah, logic update di controller akan lebih kompleks.

                    // Untuk kasus sederhana (hanya qty_digunakan berubah untuk bahan yang SAMA)
                    if ($this->stock_bahan_id == $oldBahanId) {
                        $qtySetelahDikembalikan = $stokTersediaSaatIni + $oldQty; // Stok setelah "mengembalikan" penggunaan lama
                        if ($value > $qtySetelahDikembalikan) {
                            $fail("Kuantitas yang digunakan melebihi stok tersedia setelah penyesuaian. Maksimal: {$qtySetelahDikembalikan} {$bahan->satuan}.");
                        }
                    } else {
                        // Jika bahan baku diganti, harus cek stok bahan yang BARU
                        // Ini skenario lebih kompleks, butuh logic di controller
                        // Untuk validasi di sini, kita hanya bisa cek stok bahan baru.
                        if ($value > $stokTersediaSaatIni) {
                            $fail("Kuantitas yang digunakan melebihi stok tersedia pada bahan baku yang baru dipilih. Tersedia: {$stokTersediaSaatIni} {$bahan->satuan}.");
                        }
                    }
                },
            ],
            'keperluan' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
            'tanggal_penggunaan' => 'required|date|before_or_equal:today',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'stock_bahan_id.required' => 'Bahan baku wajib dipilih.',
            'stock_bahan_id.exists' => 'Bahan baku yang dipilih tidak valid.',
            'qty_digunakan.required' => 'Kuantitas yang digunakan wajib diisi.',
            'qty_digunakan.integer' => 'Kuantitas yang digunakan harus berupa angka bulat.',
            'qty_digunakan.min' => 'Kuantitas yang digunakan minimal 1.',
            'keperluan.required' => 'Keperluan penggunaan wajib diisi.',
            'keperluan.max' => 'Keperluan maksimal 255 karakter.',
            'keterangan.max' => 'Keterangan maksimal 1000 karakter.',
            'tanggal_penggunaan.required' => 'Tanggal penggunaan wajib diisi.',
            'tanggal_penggunaan.date' => 'Format tanggal penggunaan tidak valid.',
            'tanggal_penggunaan.before_or_equal' => 'Tanggal penggunaan tidak boleh di masa depan.',
        ];
    }
}