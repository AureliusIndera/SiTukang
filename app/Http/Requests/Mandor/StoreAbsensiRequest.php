<?php

namespace App\Http\Requests\Mandor;

use Illuminate\Foundation\Http\FormRequest;

class StoreAbsensiRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Hanya mandor yang boleh input absensi
        return $this->user()->isMandor();
    }

    public function rules(): array
    {
        return [
            'proyek_id'          => ['required', 'exists:proyeks,id'],
            'tanggal'            => ['required', 'date', 'before_or_equal:today'],
            'absensi'            => ['required', 'array', 'min:1'],
            'absensi.*.tukang_id'=> ['required', 'exists:tukangs,id'],
            'absensi.*.status'   => ['required', 'in:Hadir,Absen,Izin'],
            'absensi.*.keterangan'=> ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'proyek_id.required'           => 'Proyek wajib dipilih.',
            'proyek_id.exists'             => 'Proyek tidak ditemukan.',
            'tanggal.required'             => 'Tanggal wajib diisi.',
            'tanggal.before_or_equal'      => 'Tanggal absensi tidak boleh lebih dari hari ini.',
            'absensi.required'             => 'Data absensi tukang wajib diisi.',
            'absensi.*.tukang_id.required' => 'ID tukang tidak valid.',
            'absensi.*.status.required'    => 'Status absensi wajib dipilih.',
            'absensi.*.status.in'          => 'Status absensi tidak valid.',
        ];
    }
}
