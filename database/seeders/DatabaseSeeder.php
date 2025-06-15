<?php

namespace Database\Seeders;

use App\Models\ConfigStatusPinjaman;
use App\Models\ConfigUserRole;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Pegawai;
use App\Models\Pinjaman;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // role users
        ConfigUserRole::create([
            'nama' => 'Admin',
        ]);
        ConfigUserRole::create([
            'nama' => 'Pegawai',
        ]);
        ConfigUserRole::create([
            'nama' => 'Peminjam',
        ]);

        // status pinjaman
        ConfigStatusPinjaman::create([
            'nama' => 'Proses',
        ]);
        ConfigStatusPinjaman::create([
            'nama' => 'Sukses',
        ]);
        ConfigStatusPinjaman::create([
            'nama' => 'Gagal',
        ]);

        User::create([
            'nama' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin1234'),
            'role_id' => 1,
            'is_active' => 1,
        ]);

        User::create([
            'nama' => 'Eko Prayoga',
            'email' => 'eko@gmail.com',
            'password' => bcrypt('eko12345'),
            'role_id' => 2,
            'nik' => '011111111111',
            'tempat_lahir' => 'Rembang',
            'tgl_lahir' => '2000-10-23',
            'jenis_kelamin' => 'Laki-Laki',
            'alamat' => 'Rembang, jawa Tengah',
            'no_telp' => '08385893585829',
        ]);

        User::create([
            'nama' => 'Saad Adzan Magrib',
            'email' => 'saad@gmail.com',
            'password' => bcrypt('saad12345'),
            'role_id' => 3,
            'nik' => '02222222222222',
            'tempat_lahir' => 'Makassar',
            'tgl_lahir' => '2000-10-23',
            'jenis_kelamin' => 'Laki-Laki',
            'alamat' => 'Makassar, Sulawesi Selatan',
            'no_telp' => '08847583458458',
        ]);

        Pinjaman::create([
            'id_peminjam' => 3,
            'jumlah' => 3000000,
            'jangka_waktu' => 10,
            'status_pinjaman' => 1,
            'tujuan_pinjaman' => 'buat dugem',
            'nama' => 'Saad Adzan Magrib',
            'nik' => '02222222222222',
            'tempat_lahir' => 'Makassar',
            'tgl_lahir' => '2000-10-23',
            'jenis_kelamin' => 'Laki-Laki',
            'alamat' => 'Makassar, Sulawesi Selatan',
            'no_telp' => '08847583458458',
            'status_kawin' => 'Kawin',
            'pekerjaan' => 'Disainer',
            'kewarganegaraan' => 'Dubai',
        ]);

        Pinjaman::create([
            'id_peminjam' => 3,
            'jumlah' => 3000000,
            'jangka_waktu' => 10,
            'bunga_perbulan' => 1,
            'status_pinjaman' => 3,
            'tanggapan' => 'gaboleh ngeslot ygy',
            'tujuan_pinjaman' => 'buat ngeslot',
            'nama' => 'Saad Adzan Magrib',
            'nik' => '02222222222222',
            'tempat_lahir' => 'Makassar',
            'tgl_lahir' => '2000-10-23',
            'jenis_kelamin' => 'Laki-Laki',
            'alamat' => 'Makassar, Sulawesi Selatan',
            'no_telp' => '08847583458458',
            'status_kawin' => 'Kawin',
            'pekerjaan' => 'Disainer',
            'kewarganegaraan' => 'Dubai',
        ]);

        Pinjaman::create([
            'id_peminjam' => 3,
            'jumlah' => 5000000,
            'jangka_waktu' => 12,
            'bunga_perbulan' => 0.5,
            'status_pinjaman' => 2,
            'tanggapan' => 'cair ni boss',
            'tujuan_pinjaman' => 'buat beli pesawat',
            'nama' => 'Saad Adzan Magrib',
            'nik' => '02222222222222',
            'tempat_lahir' => 'Makassar',
            'tgl_lahir' => '2000-10-23',
            'jenis_kelamin' => 'Laki-Laki',
            'alamat' => 'Makassar, Sulawesi Selatan',
            'no_telp' => '08847583458458',
            'status_kawin' => 'Kawin',
            'pekerjaan' => 'Disainer',
            'kewarganegaraan' => 'Dubai',
        ]);
        
    }
}
