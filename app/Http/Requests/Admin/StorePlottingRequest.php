<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePlottingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'tukang_id'      => ['required', 'exists:tukangs,id'],
            'proyek_id'      => ['required', 'exists:proyeks,id'],
            'tarif_harian'   => ['required', 'numeric', 'min:0'],
            'tanggal_masuk'  => ['nullable', 'date'],
            'tanggal_keluar' => ['nullable', 'date', 'after_or_equal:tanggal_masuk'],
        ];
    }

    public function messages(): array
    {
        return [
            'tukang_id.required'    => 'Tukang wajib dipilih.',
            'tukang_id.exists'      => 'Tukang tidak ditemukan.',
            'proyek_id.required'    => 'Proyek wajib dipilih.',
            'proyek_id.exists'      => 'Proyek tidak ditemukan.',
            'tarif_harian.required' => 'Tarif harian wajib diisi.',
            'tarif_harian.numeric'  => 'Tarif harian harus berupa angka.',
            'tarif_harian.min'      => 'Tarif harian tidak boleh negatif.',
        ];
    }
}
