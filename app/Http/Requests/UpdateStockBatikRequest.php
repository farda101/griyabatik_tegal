<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateStockBatikRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya superadmin yang diizinkan untuk memperbarui stok batik
        return Auth::check() && Auth::user()->isSuperadmin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $stockBatikId = $this->route('stock_batik'); // Jika perlu mengabaikan kode batik yang sama

        return [
            'pengrajin_id' => 'required|exists:pengrajins,id',
            // Kode batik tidak diubah via form edit, atau jika diubah, periksa unique kecuali dirinya sendiri
            // 'kode_batik' => ['required', 'string', 'max:15', Rule::unique('stock_batiks')->ignore($stockBatikId)],
            'nama_batik' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'motif' => 'nullable|string|max:100',
            'ukuran' => 'nullable|string|max:50',
            'harga_beli' => 'required|numeric|min:0|max:999999999.99',
            'harga_jual' => 'required|numeric|min:0|max:999999999.99|gte:harga_beli',
            // qty_masuk tidak boleh diubah setelah stok masuk (logika lebih ketat jika diperlukan)
            // qty_tersedia akan diupdate otomatis oleh sistem, tidak diinput manual
            // qty_terjual juga diupdate otomatis oleh sistem
            'tanggal_masuk' => 'required|date|before_or_equal:today',
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
            'pengrajin_id.required' => 'Pengrajin wajib dipilih.',
            'pengrajin_id.exists' => 'Pengrajin yang dipilih tidak valid.',
            'nama_batik.required' => 'Nama batik wajib diisi.',
            'nama_batik.max' => 'Nama batik maksimal 255 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'motif.max' => 'Motif maksimal 100 karakter.',
            'ukuran.max' => 'Ukuran maksimal 50 karakter.',
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_beli.numeric' => 'Harga beli harus berupa angka.',
            'harga_beli.min' => 'Harga beli tidak boleh negatif.',
            'harga_beli.max' => 'Harga beli terlalu besar.',
            'harga_jual.required' => 'Harga jual wajib diisi.',
            'harga_jual.numeric' => 'Harga jual harus berupa angka.',
            'harga_jual.min' => 'Harga jual tidak boleh negatif.',
            'harga_jual.max' => 'Harga jual terlalu besar.',
            'harga_jual.gte' => 'Harga jual harus lebih besar atau sama dengan harga beli.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'tanggal_masuk.date' => 'Format tanggal masuk tidak valid.',
            'tanggal_masuk.before_or_equal' => 'Tanggal masuk tidak boleh di masa depan.',
        ];
    }
}