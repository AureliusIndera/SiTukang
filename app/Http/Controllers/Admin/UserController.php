<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\Mandor;
use App\Models\Tukang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->where('role', '!=', 'admin');

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->with(['mandor', 'tukang'])
                        ->latest()
                        ->paginate(10)
                        ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

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
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User baru berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $user->load(['mandor', 'tukang']);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:100'],
            'email'         => ['required', 'email', 'unique:users,email,' . $user->id],
            'password'      => ['nullable', 'confirmed', 'min:6'],

            'nama_mandor'   => ['required_if:role,mandor', 'nullable', 'string', 'max:100'],
            'no_hp_mandor'  => ['nullable', 'string', 'max:20'],
            'alamat_mandor' => ['nullable', 'string'],

            'nama_tukang'   => ['required_if:role,tukang', 'nullable', 'string', 'max:100'],
            'no_hp_tukang'  => ['nullable', 'string', 'max:20'],
            'alamat_tukang' => ['nullable', 'string'],
            'skill'         => ['nullable', 'string', 'max:100'],
        ]);

        DB::transaction(function () use ($validated, $user) {
            $userData = [
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ];

            if (! empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);

            if ($user->role === 'mandor' && $user->mandor) {
                $user->mandor->update([
                    'nama_mandor' => $validated['nama_mandor'],
                    'no_hp'       => $validated['no_hp_mandor'] ?? null,
                    'alamat'      => $validated['alamat_mandor'] ?? null,
                ]);
            }

            if ($user->role === 'tukang' && $user->tukang) {
                $user->tukang->update([
                    'nama_tukang' => $validated['nama_tukang'],
                    'no_hp'       => $validated['no_hp_tukang'] ?? null,
                    'alamat'      => $validated['alamat_tukang'] ?? null,
                    'skill'       => $validated['skill'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'mandor' && $user->mandor) {
            $punyaAbsensi = $user->mandor->absensis()->exists();

            if ($punyaAbsensi) {
                return back()->with(
                    'error',
                    'Mandor ini tidak bisa dihapus karena memiliki riwayat input absensi (audit trail).'
                );
            }
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
