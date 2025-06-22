<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Untuk unique rule jika kode_bahan bisa diubah

class UpdateStockBahanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya superadmin yang diizinkan untuk memperbarui stok bahan
        return Auth::check() && Auth::user()->isSuperadmin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Jika kode_bahan bisa diubah dan harus unik, gunakan Rule::unique()->ignore()
        // $stockBahanId = $this->route('stock_bahan'); // 'stock_bahan' adalah nama parameter di rute resource

        return [
            // Kode bahan tidak diubah via form edit, atau jika diubah, periksa unique kecuali dirinya sendiri
            // 'kode_bahan' => ['required', 'string', 'max:10', Rule::unique('stock_bahans')->ignore($stockBahanId)],
            'nama_bahan' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'harga_satuan' => 'required|numeric|min:0|max:999999999.99',
            // qty_masuk tidak boleh diubah setelah stok masuk
            // qty_tersedia dan qty_terpakai diupdate otomatis oleh sistem
            'tanggal_masuk' => 'required|date|before_or_equal:today',
            'keterangan' => 'nullable|string|max:1000',
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
            'nama_bahan.required' => 'Nama bahan wajib diisi.',
            'nama_bahan.max' => 'Nama bahan maksimal 255 karakter.',
            'satuan.required' => 'Satuan wajib diisi.',
            'satuan.max' => 'Satuan maksimal 50 karakter.',
            'harga_satuan.required' => 'Harga satuan wajib diisi.',
            'harga_satuan.numeric' => 'Harga satuan harus berupa angka.',
            'harga_satuan.min' => 'Harga satuan tidak boleh negatif.',
            'harga_satuan.max' => 'Harga satuan terlalu besar.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'tanggal_masuk.date' => 'Format tanggal masuk tidak valid.',
            'tanggal_masuk.before_or_equal' => 'Tanggal masuk tidak boleh di masa depan.',
            'keterangan.max' => 'Keterangan maksimal 1000 karakter.',
        ];
    }
}