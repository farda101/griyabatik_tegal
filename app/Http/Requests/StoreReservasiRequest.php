<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule

class StoreReservasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Karena ini adalah form publik, semua orang diizinkan untuk membuat reservasi
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jadwal_workshop_id' => 'required|exists:jadwal_workshops,id', // Harus ada di tabel jadwal_workshops
            'jenis_peserta' => ['required', Rule::in(['individu', 'kelompok'])],
            'jumlah_peserta' => 'required|integer|min:1',
            'nama_pemesan' => 'required|string|max:255',
            'email_pemesan' => 'required|email|max:255',
            'telepon_pemesan' => 'required|string|max:20|regex:/^[0-9\-\(\)\s\+]+$/',
            'alamat_pemesan' => 'nullable|string|max:500',
            'file_permohonan' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Contoh: PDF/DOC maksimal 2MB
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
            'jadwal_workshop_id.required' => 'Jadwal workshop wajib dipilih.',
            'jadwal_workshop_id.exists' => 'Jadwal workshop yang dipilih tidak valid.',
            'jenis_peserta.required' => 'Jenis peserta wajib dipilih.',
            'jenis_peserta.in' => 'Jenis peserta tidak valid.',
            'jumlah_peserta.required' => 'Jumlah peserta wajib diisi.',
            'jumlah_peserta.integer' => 'Jumlah peserta harus berupa angka bulat.',
            'jumlah_peserta.min' => 'Jumlah peserta minimal 1.',
            'nama_pemesan.required' => 'Nama pemesan wajib diisi.',
            'nama_pemesan.max' => 'Nama pemesan maksimal 255 karakter.',
            'email_pemesan.required' => 'Email pemesan wajib diisi.',
            'email_pemesan.email' => 'Format email pemesan tidak valid.',
            'email_pemesan.max' => 'Email pemesan maksimal 255 karakter.',
            'telepon_pemesan.required' => 'Telepon pemesan wajib diisi.',
            'telepon_pemesan.max' => 'Telepon pemesan maksimal 20 karakter.',
            'telepon_pemesan.regex' => 'Format telepon pemesan tidak valid.',
            'alamat_pemesan.max' => 'Alamat pemesan maksimal 500 karakter.',
            'file_permohonan.file' => 'File permohonan harus berupa file.',
            'file_permohonan.mimes' => 'Format file permohonan harus PDF, DOC, atau DOCX.',
            'file_permohonan.max' => 'Ukuran file permohonan maksimal 2MB.',
        ];
    }
}