<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Untuk rule 'in'

class StoreArtikelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya superadmin yang diizinkan untuk menambahkan artikel
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
            'judul' => 'required|string|max:255|unique:artikels,judul', // Judul unik
            // Slug akan di-auto-generate, tidak perlu divalidasi dari input form
            'konten' => 'required|string', // Konten artikel bisa sangat panjang
            'excerpt' => 'nullable|string|max:300', // Ringkasan artikel, opsional
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Gambar unggulan, opsional, maks 2MB
            'status' => ['required', Rule::in(['draft', 'published'])], // Status artikel
            // views_count dan author_id akan diisi otomatis di controller/model
            'published_at' => 'nullable|date', // Tanggal publikasi, opsional
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
            'judul.unique' => 'Judul artikel ini sudah ada.',
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