<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Tambahkan ini

class StoreJadwalWorkshopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya superadmin yang diizinkan untuk menyimpan jadwal workshop baru
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
            'paket_workshop_id' => 'required|exists:paket_workshops,id', // Harus ada di tabel paket_workshops
            'tanggal' => 'required|date|after_or_equal:today', // Tanggal tidak boleh di masa lalu
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai', // Jam selesai harus setelah jam mulai
            'max_peserta' => 'required|integer|min:1|max:100', // Sesuai dengan batasan di PaketWorkshop
            // Status akan diatur secara otomatis di controller/model
            'status' => ['required', Rule::in(['available', 'unavailable', 'full'])],
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
            'paket_workshop_id.required' => 'Paket workshop wajib dipilih.',
            'paket_workshop_id.exists' => 'Paket workshop yang dipilih tidak valid.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'tanggal.after_or_equal' => 'Tanggal tidak boleh di masa lalu.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid (HH:MM).',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid (HH:MM).',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            'max_peserta.required' => 'Maksimal peserta wajib diisi.',
            'max_peserta.integer' => 'Maksimal peserta harus berupa bilangan bulat.',
            'max_peserta.min' => 'Maksimal peserta minimal 1.',
            'max_peserta.max' => 'Maksimal peserta maksimal 100.',
            'status.required' => 'Status wajib diisi.',
            'status' => ['nullable', Rule::in(['available', 'unavailable', 'full'])],
        ];
    }
}