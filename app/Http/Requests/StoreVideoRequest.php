<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya superadmin yang diizinkan untuk menambahkan video
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
            'file_video' => 'required|file|mimes:mp4,mov,avi,wmv,flv,webm|max:500000', // Wajib, format video, maks 500MB
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Opsional, gambar, maks 2MB
            'durasi_detik' => 'required|integer|min:1', // Durasi dalam detik, wajib
            'is_active' => 'boolean', // Status aktif/non-aktif
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
            'judul.required' => 'Judul video wajib diisi.',
            'judul.max' => 'Judul video maksimal 255 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'file_video.required' => 'File video wajib diunggah.',
            'file_video.file' => 'File yang diunggah harus berupa file.',
            'file_video.mimes' => 'Format video yang diizinkan: MP4, MOV, AVI, WMV, FLV, WEBM.',
            'file_video.max' => 'Ukuran video maksimal 500MB.',
            'thumbnail.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Format thumbnail yang diizinkan: JPEG, PNG, JPG, GIF, SVG.',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
            'durasi_detik.required' => 'Durasi video wajib diisi.',
            'durasi_detik.integer' => 'Durasi video harus berupa bilangan bulat.',
            'durasi_detik.min' => 'Durasi video minimal 1 detik.',
            'is_active.boolean' => 'Status aktif tidak valid.',
        ];
    }
}