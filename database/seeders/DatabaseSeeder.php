<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB; // <-- Jangan lupa tambahkan ini di atas jika belum ada
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin & Staff (yang sebelumnya sudah kita buat)
        User::updateOrCreate(
            ['email' => 'admin@rental.com'],
            [
                'name' => 'Siti Admin',
                'email' => 'admin@rental.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@rental.com'],
            [
                'name' => 'Petugas Staff',
                'email' => 'staff@rental.com',
                'password' => Hash::make('staff123'),
                'role' => 'staff'
            ]
        );

        // 2. Masukkan Kembali 3 Paket Rental Mobil
        DB::table('paket_rental')->updateOrInsert(
            ['nama_paket' => 'Paket All In'],
            [
                'deskripsi' => 'Fasilitas lengkap sudah termasuk supir berpengalaman dan BBM.',
                'harga_per_hari' => 800000,
                'biaya_driver' => 150000,
                'ketentuan' => 'Terima beres, all inclusive.'
            ]
        );

        DB::table('paket_rental')->updateOrInsert(
            ['nama_paket' => 'Paket Luar Kota'],
            [
                'deskripsi' => 'Cocok untuk perjalanan jauh Antar Kota / Provinsi.',
                'harga_per_hari' => 500000,
                'biaya_driver' => 200000,
                'ketentuan' => 'Termasuk asuransi ringan, bebas.'
            ]
        );

        DB::table('paket_rental')->updateOrInsert(
            ['nama_paket' => 'Paket Lepas Kunci'],
            [
                'deskripsi' => 'Rental mobil mandiri tanpa supir untuk kebebasan perjalanan Anda.',
                'harga_per_hari' => 400000,
                'biaya_driver' => 0,
                'ketentuan' => 'Tanpa driver, wajib verifikasi SIM.'
            ]
        );
    }
}