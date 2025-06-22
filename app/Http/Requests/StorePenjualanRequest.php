<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePenjualanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya kasir atau superadmin yang diizinkan untuk menyimpan penjualan
        return Auth::check() && (Auth::user()->isKasir || Auth::user()->isSuperadmin);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Pastikan nama properti di Livewire ($nama_pembeli, $telepon_pembeli, $cart, $total_bayar)
            // cocok dengan nama rules di sini.
            'nama_pembeli' => 'nullable|string|max:255',
            'telepon_pembeli' => 'nullable|string|max:20|regex:/^[0-9\-\(\)\s\+]+$/',
            'cart' => 'required|array|min:1', // Livewire property $cart akan di-map ke 'items'
            'cart.*.kode_batik' => 'required|string|exists:stock_batiks,kode_batik',
            'cart.*.qty' => 'required|integer|min:1',
            'total_harga' => 'required|numeric|min:0',
            'total_bayar' => 'required|numeric|min:0|gte:total_harga',
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
            'items.required' => 'Keranjang penjualan tidak boleh kosong.',
            'items.array' => 'Format item penjualan tidak valid.',
            'items.min' => 'Minimal harus ada 1 item di keranjang.',
            'items.*.kode_batik.required' => 'Kode batik wajib diisi untuk setiap item.',
            'items.*.kode_batik.exists' => 'Kode batik ":input" tidak ditemukan dalam stok.',
            'items.*.qty.required' => 'Kuantitas wajib diisi untuk setiap item.',
            'items.*.qty.integer' => 'Kuantitas harus berupa angka bulat.',
            'items.*.qty.min' => 'Kuantitas minimal 1.',
            'total_harga.required' => 'Total harga wajib diisi.',
            'total_harga.numeric' => 'Total harga harus berupa angka.',
            'total_harga.min' => 'Total harga tidak boleh negatif.',
            'total_bayar.required' => 'Total bayar wajib diisi.',
            'total_bayar.numeric' => 'Total bayar harus berupa angka.',
            'total_bayar.min' => 'Total bayar tidak boleh negatif.',
            'total_bayar.gte' => 'Total bayar harus lebih besar atau sama dengan total harga.',
        ];
    }
}