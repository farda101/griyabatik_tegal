<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\StockBahan; // Untuk validasi stok tersedia

class StorePenggunaanBahanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya superadmin (atau kasir jika nanti diizinkan) yang bisa mencatat penggunaan bahan
        return Auth::check() && (Auth::user()->isSuperadmin || Auth::user()->isKasir);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'stock_bahan_id' => 'required|exists:stock_bahans,id', // Harus ada di tabel stock_bahans
            'qty_digunakan' => [
                'required',
                'integer',
                'min:1',
                // Custom rule atau closure untuk cek ketersediaan stok
                function ($attribute, $value, $fail) {
                    $bahan = StockBahan::find($this->stock_bahan_id);
                    if ($bahan && $value > $bahan->qty_tersedia) {
                        $fail("Kuantitas yang digunakan melebihi stok tersedia. Tersedia: {$bahan->qty_tersedia} {$bahan->satuan}.");
                    }
                },
            ],
            'keperluan' => 'required|string|max:255', // Contoh: Produksi, Workshop, Riset
            'keterangan' => 'nullable|string|max:1000',
            'tanggal_penggunaan' => 'required|date|before_or_equal:today', // Tidak boleh di masa depan
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