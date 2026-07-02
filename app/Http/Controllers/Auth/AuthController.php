<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Mandor;
use App\Models\Tukang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return $this->redirectBasedOnRole();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function redirectBasedOnRole()
    {
        return match (Auth::user()->role) {
            'admin'  => redirect()->intended(route('admin.dashboard')),
            'mandor' => redirect()->intended(route('mandor.dashboard')),
            'tukang' => redirect()->intended(route('tukang.dashboard')),
            default  => redirect('/'),
        };
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'role'         => ['required', 'in:mandor,tukang'],
            'name'         => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'unique:users,email'],
            'password'     => ['required', 'confirmed', 'min:6'],

            // Profil Mandor
            'nama_mandor'  => ['required_if:role,mandor', 'nullable', 'string', 'max:100'],
            'no_hp_mandor' => ['nullable', 'string', 'max:20'],
            'alamat_mandor'=> ['nullable', 'string'],

            // Profil Tukang
            'nama_tukang'  => ['required_if:role,tukang', 'nullable', 'string', 'max:100'],
            'no_hp_tukang' => ['nullable', 'string', 'max:20'],
            'alamat_tukang'=> ['nullable', 'string'],
            'skill'        => ['nullable', 'string', 'max:100'],
        ], [
            'role.required'          => 'Daftar sebagai apa wajib dipilih.',
            'role.in'                => 'Pilihan role tidak valid.',
            'name.required'          => 'Nama wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.unique'           => 'Email sudah terdaftar.',
            'password.required'      => 'Password wajib diisi.',
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',
            'password.min'           => 'Password minimal 6 karakter.',
            'nama_mandor.required_if'=> 'Nama mandor wajib diisi.',
            'nama_tukang.required_if'=> 'Nama tukang wajib diisi.',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => $validated['role'],
            ]);

            if ($validated['role'] === 'mandor') {
                Mandor::create([
                    'user_id'     => $user->id,
                    'nama_mandor' => $validated['nama_mandor'],
                    'no_hp'       => $validated['no_hp_mandor'] ?? null,
                    'alamat'      => $validated['alamat_mandor'] ?? null,
                ]);
            }

            if ($validated['role'] === 'tukang') {
                Tukang::create([
                    'user_id'     => $user->id,
                    'nama_tukang' => $validated['nama_tukang'],
                    'no_hp'       => $validated['no_hp_tukang'] ?? null,
                    'alamat'      => $validated['alamat_tukang'] ?? null,
                    'skill'       => $validated['skill'] ?? null,
                ]);
            }

            Auth::login($user);
        });

        return $this->redirectBasedOnRole();
    }
}