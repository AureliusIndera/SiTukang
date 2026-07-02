<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================================
        // 1 ADMIN
        // ============================================================
        $adminId = DB::table('users')->insertGetId([
            'name'       => 'Administrator',
            'email'      => 'admin@situkang.test',
            'password'   => Hash::make('password'),
            'role'       => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ============================================================
        // 2 MANDOR
        // ============================================================
        $mandorUsers = [
            [
                'name'  => 'Budi Santoso',
                'email' => 'budi.mandor@situkang.test',
                'profil' => [
                    'nama_mandor' => 'Budi Santoso',
                    'no_hp'       => '081234567890',
                    'alamat'      => 'Jl. Mawar No. 12, Sleman, Yogyakarta',
                ],
            ],
            [
                'name'  => 'Hendra Wijaya',
                'email' => 'hendra.mandor@situkang.test',
                'profil' => [
                    'nama_mandor' => 'Hendra Wijaya',
                    'no_hp'       => '082345678901',
                    'alamat'      => 'Jl. Melati No. 7, Bantul, Yogyakarta',
                ],
            ],
        ];

        foreach ($mandorUsers as $data) {
            $userId = DB::table('users')->insertGetId([
                'name'       => $data['name'],
                'email'      => $data['email'],
                'password'   => Hash::make('password'),
                'role'       => 'mandor',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('mandors')->insert([
                'user_id'     => $userId,
                'nama_mandor' => $data['profil']['nama_mandor'],
                'no_hp'       => $data['profil']['no_hp'],
                'alamat'      => $data['profil']['alamat'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        // ============================================================
        // 5 TUKANG
        // ============================================================
        $tukangUsers = [
            [
                'name'  => 'Agus Trisno',
                'email' => 'agus@situkang.test',
                'profil' => [
                    'nama_tukang' => 'Agus Trisno',
                    'no_hp'       => '083456789012',
                    'alamat'      => 'Jl. Kenanga No. 3, Godean, Sleman',
                    'skill'       => 'Tukang Batu',
                ],
            ],
            [
                'name'  => 'Slamet Riyadi',
                'email' => 'slamet@situkang.test',
                'profil' => [
                    'nama_tukang' => 'Slamet Riyadi',
                    'no_hp'       => '084567890123',
                    'alamat'      => 'Jl. Flamboyan No. 5, Moyudan, Sleman',
                    'skill'       => 'Tukang Kayu',
                ],
            ],
            [
                'name'  => 'Wahyu Purnomo',
                'email' => 'wahyu@situkang.test',
                'profil' => [
                    'nama_tukang' => 'Wahyu Purnomo',
                    'no_hp'       => '085678901234',
                    'alamat'      => 'Jl. Anggrek No. 9, Gamping, Sleman',
                    'skill'       => 'Tukang Las',
                ],
            ],
            [
                'name'  => 'Joko Susilo',
                'email' => 'joko@situkang.test',
                'profil' => [
                    'nama_tukang' => 'Joko Susilo',
                    'no_hp'       => '086789012345',
                    'alamat'      => 'Jl. Dahlia No. 2, Mlati, Sleman',
                    'skill'       => 'Tukang Cat',
                ],
            ],
            [
                'name'  => 'Eko Prasetyo',
                'email' => 'eko@situkang.test',
                'profil' => [
                    'nama_tukang' => 'Eko Prasetyo',
                    'no_hp'       => '087890123456',
                    'alamat'      => 'Jl. Tulip No. 14, Depok, Sleman',
                    'skill'       => 'Tukang Batu',
                ],
            ],
        ];

        foreach ($tukangUsers as $data) {
            $userId = DB::table('users')->insertGetId([
                'name'       => $data['name'],
                'email'      => $data['email'],
                'password'   => Hash::make('password'),
                'role'       => 'tukang',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('tukangs')->insert([
                'user_id'     => $userId,
                'nama_tukang' => $data['profil']['nama_tukang'],
                'no_hp'       => $data['profil']['no_hp'],
                'alamat'      => $data['profil']['alamat'],
                'skill'       => $data['profil']['skill'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
