<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreGaleriRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya superadmin yang diizinkan untuk menambahkan foto ke galeri
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
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Wajib, format gambar, maks 2MB
            'urutan' => 'nullable|integer|min:0', // Urutan tampilan, opsional
            'is_active' => 'boolean', // Status aktif/non-aktif, opsional
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
            'judul.required' => 'Judul foto wajib diisi.',
            'judul.max' => 'Judul foto maksimal 255 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'foto.required' => 'File foto wajib diunggah.',
            'foto.image' => 'File yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Format gambar yang diizinkan: JPEG, PNG, JPG, GIF, SVG.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
            'urutan.integer' => 'Urutan harus berupa bilangan bulat.',
            'urutan.min' => 'Urutan minimal 0.',
            'is_active.boolean' => 'Status aktif tidak valid.',
        ];
    }
}