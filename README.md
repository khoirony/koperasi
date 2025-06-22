
## Cara Menjalankan

- download file ke local
- download php minimal 8.2
- download composer (jika belum)
- buka terminal lalu jalankan 'composer install'
- buat tabel mysql dengan nama koperasi
- buka file .env lalu sesuaikan DB username n passowrdnya
- buka terminal lalu jalankan 'php artisan migrate:fresh --seed'
- buka terminal lalu jalanankan 'php artisan serve'


## Data User
- buka file database/seeders/DatabaseSeeder
- lihat dibagian User::create, disitu ada data user untuk login

