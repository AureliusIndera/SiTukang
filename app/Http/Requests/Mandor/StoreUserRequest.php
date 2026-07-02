<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'unique:users,email'],
            'password'     => ['required', 'confirmed', Password::min(6)],
            'role'         => ['required', 'in:admin,mandor,tukang'],

            // Profil Mandor — wajib jika role = mandor
            'nama_mandor'  => ['required_if:role,mandor', 'nullable', 'string', 'max:100'],
            'no_hp_mandor' => ['nullable', 'string', 'max:20'],
            'alamat_mandor'=> ['nullable', 'string'],

            // Profil Tukang — wajib jika role = tukang
            'nama_tukang'  => ['required_if:role,tukang', 'nullable', 'string', 'max:100'],
            'no_hp_tukang' => ['nullable', 'string', 'max:20'],
            'alamat_tukang'=> ['nullable', 'string'],
            'skill'        => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'          => 'Nama wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.unique'           => 'Email sudah terdaftar.',
            'password.required'      => 'Password wajib diisi.',
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',
            'role.required'          => 'Role wajib dipilih.',
            'role.in'                => 'Role tidak valid.',
            'nama_mandor.required_if'=> 'Nama mandor wajib diisi.',
            'nama_tukang.required_if'=> 'Nama tukang wajib diisi.',
        ];
    }
}
