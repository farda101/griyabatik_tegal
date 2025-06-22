<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreStockBahanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya superadmin yang diizinkan untuk menyimpan stok bahan baru
        return Auth::check() && Auth::user()->isSuperadmin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Kode bahan akan di-auto-generate, jadi tidak perlu divalidasi dari input form
            'nama_bahan' => 'required|string|max:255',
            'satuan' => 'required|string|max:50', // Contoh: Meter, Kg, Pcs, Liter
            'harga_satuan' => 'required|numeric|min:0|max:999999999.99',
            'qty_masuk' => 'required|integer|min:1',
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
            'qty_masuk.required' => 'Jumlah masuk wajib diisi.',
            'qty_masuk.integer' => 'Jumlah masuk harus berupa bilangan bulat.',
            'qty_masuk.min' => 'Jumlah masuk minimal 1.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'tanggal_masuk.date' => 'Format tanggal masuk tidak valid.',
            'tanggal_masuk.before_or_equal' => 'Tanggal masuk tidak boleh di masa depan.',
            'keterangan.max' => 'Keterangan maksimal 1000 karakter.',
        ];
    }
}