<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; // Penting untuk otorisasi
use Illuminate\Validation\Rule; // Tambahkan ini

class UpdatePengrajinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya superadmin yang diizinkan untuk memperbarui pengrajin
        return Auth::check() && Auth::user()->isSuperadmin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Ambil ID pengrajin dari rute atau request (misalnya, jika menggunakan route model binding)
        $pengrajinId = $this->route('pengrajin'); // 'pengrajin' adalah nama parameter di rute resource

        return [
            'kode_pengrajin' => [
                'required',
                'string',
                'max:4',
                // Rule::unique diabaikan untuk ID pengrajin yang sedang di-update
                Rule::unique('pengrajins', 'kode_pengrajin')->ignore($pengrajinId),
                'regex:/^[0-9]{4}$/'
            ],
            'nama_pengrajin' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'telepon' => 'nullable|string|max:20|regex:/^[0-9\-\(\)\s\+]+$/',
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
            'kode_pengrajin.required' => 'Kode pengrajin wajib diisi.',
            'kode_pengrajin.unique' => 'Kode pengrajin ini sudah digunakan oleh pengrajin lain.',
            'kode_pengrajin.max' => 'Kode pengrajin maksimal 4 karakter.',
            'kode_pengrajin.regex' => 'Kode pengrajin harus 4 digit angka.',
            'nama_pengrajin.required' => 'Nama pengrajin wajib diisi.',
            'nama_pengrajin.max' => 'Nama pengrajin maksimal 255 karakter.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
            'telepon.max' => 'Nomor telepon maksimal 20 karakter.',
            'telepon.regex' => 'Format nomor telepon tidak valid.',
            'is_active.boolean' => 'Status aktif tidak valid.',
        ];
    }
}