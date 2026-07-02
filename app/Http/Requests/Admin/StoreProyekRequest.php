<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProyekRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'nama_proyek'     => ['required', 'string', 'max:150'],
            'lokasi'          => ['nullable', 'string', 'max:200'],
            'status_proyek'   => ['required', 'in:pending,aktif,selesai'],
            'tanggal_mulai'   => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_proyek.required'          => 'Nama proyek wajib diisi.',
            'status_proyek.required'        => 'Status proyek wajib dipilih.',
            'status_proyek.in'              => 'Status proyek tidak valid.',
            'tanggal_selesai.after_or_equal'=> 'Tanggal selesai harus setelah tanggal mulai.',
        ];
    }
}
