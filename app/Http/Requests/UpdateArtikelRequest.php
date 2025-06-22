<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Untuk rule 'unique' dan 'in'

class UpdateArtikelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya superadmin yang diizinkan untuk memperbarui artikel
        return Auth::check() && Auth::user()->isSuperadmin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Dapatkan ID artikel yang sedang di-update melalui Route Model Binding
        $artikelId = $this->route('artikel'); // 'artikel' adalah parameter resource

        return [
            'judul' => [
                'required',
                'string',
                'max:255',
                // Pastikan judul unik, kecuali untuk artikel yang sedang di-update
                Rule::unique('artikels', 'judul')->ignore($artikelId),
            ],
            // Slug akan di-auto-generate/diperbarui di model, tidak perlu divalidasi dari input form
            'konten' => 'required|string',
            'excerpt' => 'nullable|string|max:300',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Opsional saat update
            'status' => ['required', Rule::in(['draft', 'published'])],
            // views_count dan author_id tidak diubah manual dari sini
            'published_at' => 'nullable|date',
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
            'judul.required' => 'Judul artikel wajib diisi.',
            'judul.max' => 'Judul artikel maksimal 255 karakter.',
            'judul.unique' => 'Judul artikel ini sudah digunakan oleh artikel lain.',
            'konten.required' => 'Konten artikel wajib diisi.',
            'excerpt.max' => 'Ringkasan artikel maksimal 300 karakter.',
            'featured_image.image' => 'Gambar unggulan harus berupa gambar.',
            'featured_image.mimes' => 'Format gambar unggulan yang diizinkan: JPEG, PNG, JPG, GIF, SVG.',
            'featured_image.max' => 'Ukuran gambar unggulan maksimal 2MB.',
            'status.required' => 'Status artikel wajib dipilih.',
            'status.in' => 'Status artikel tidak valid.',
            'published_at.date' => 'Format tanggal publikasi tidak valid.',
        ];
    }
}