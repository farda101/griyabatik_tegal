<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Import Rule

class UpdatePaketWorkshopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya superadmin yang diizinkan untuk memperbarui paket workshop
        return Auth::check() && Auth::user()->isSuperadmin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Ambil ID paket workshop dari rute atau request (misalnya, jika menggunakan route model binding)
        $paketWorkshopId = $this->route('paket_workshop'); // 'paket_workshop' adalah nama parameter di rute resource

        return [
            'nama_paket' => [
                'required',
                'string',
                'max:255',
                // Pastikan nama_paket unik, kecuali untuk paket_workshop yang sedang di-update
                Rule::unique('paket_workshops', 'nama_paket')->ignore($paketWorkshopId),
            ],
            'deskripsi' => 'nullable|string|max:1000',
            'harga_individu' => 'required|numeric|min:0|max:99999999.99',
            'harga_kelompok' => 'required|numeric|min:0|max:99999999.99',
            'durasi_menit' => 'required|integer|min:30|max:1440',
            'max_peserta' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean',
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
            'nama_paket.required' => 'Nama paket wajib diisi.',
            'nama_paket.unique' => 'Nama paket ini sudah digunakan oleh paket lain.',
            'nama_paket.max' => 'Nama paket maksimal 255 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'harga_individu.required' => 'Harga individu wajib diisi.',
            'harga_individu.numeric' => 'Harga individu harus berupa angka.',
            'harga_individu.min' => 'Harga individu tidak boleh negatif.',
            'harga_individu.max' => 'Harga individu terlalu besar.',
            'harga_kelompok.required' => 'Harga kelompok wajib diisi.',
            'harga_kelompok.numeric' => 'Harga kelompok harus berupa angka.',
            'harga_kelompok.min' => 'Harga kelompok tidak boleh negatif.',
            'harga_kelompok.max' => 'Harga kelompok terlalu besar.',
            'durasi_menit.required' => 'Durasi menit wajib diisi.',
            'durasi_menit.integer' => 'Durasi menit harus berupa bilangan bulat.',
            'durasi_menit.min' => 'Durasi minimal 30 menit.',
            'durasi_menit.max' => 'Durasi maksimal 1440 menit (24 jam).',
            'max_peserta.required' => 'Maksimal peserta wajib diisi.',
            'max_peserta.integer' => 'Maksimal peserta harus berupa bilangan bulat.',
            'max_peserta.min' => 'Maksimal peserta minimal 1.',
            'max_peserta.max' => 'Maksimal peserta maksimal 100.',
            'is_active.boolean' => 'Status aktif tidak valid.',
        ];
    }
}