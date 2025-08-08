<?php
 
namespace Database\Seeders;
 
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Salary;
use App\Models\Employee;
 
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * Buat Data Dummy Pake Library Faker Dengan Fitur Factories Laravel
         */
        // \App\Models\User::factory(10)->create();
 
 
 
        Role::create([
            'role_name' => 'Admin'      // id = 1
        ]);
        Role::create([
            'role_name' => 'Finance Manager'  // id = 2
        ]);
        Role::create([
            'role_name' => 'karyawan'   // id = 3
        ]);
 
        Category::create([
            'nama_kategori'     => 'Produk Digital',
            'jenis_kategori'    => 'Pemasukan'
        ]);
        Category::create([
            'nama_kategori'     => 'Beli PC',
            'jenis_kategori'    => 'Pengeluaran'
        ]);
        Category::create([
            'nama_kategori'     => 'Jasa Konsultasi ',
            'jenis_kategori'    => 'Pemasukan'
        ]);
        Category::create([
            'nama_kategori'     => 'Beli Kursi & Meja',
            'jenis_kategori'    => 'Pengeluaran'
        ]);
        Category::create([
            'nama_kategori'     => 'Kebutuhan Alat-Alat Kantor',
            'jenis_kategori'    => 'Pengeluaran'
        ]);
        Category::create([
            'nama_kategori'     => 'Layanan R&D & Support',
            'jenis_kategori'    => 'Pemasukan'
        ]);
        Category::create([
            'nama_kategori'     => 'Biaya Sewa Gedung',
            'jenis_kategori'    => 'Pengeluaran'
        ]);
        // Salaries
        Salary::create([
            'jabatan'       => 'Project Manager',
            'gaji_pokok'    => 4000000,
            'tj_transport'  => 400000,
            'uang_makan'    => 300000
        ]);
        Salary::create([
            'jabatan'       => 'Developer',
            'gaji_pokok'    => 4000000,
            'tj_transport'  => 400000,
            'uang_makan'    => 300000
        ]);
        Salary::create([
            'jabatan'       => 'IT Support',
            'gaji_pokok'    => 4000000,
            'tj_transport'  => 300000,
            'uang_makan'    => 300000
        ]);
        Salary::create([
            'jabatan'       => 'Developer',
            'gaji_pokok'    => 3500000,
            'tj_transport'  => 300000,
            'uang_makan'    => 300000
        ]);
        Salary::create([
            'jabatan'       => 'Designer',
            'gaji_pokok'    => 4100000,
            'tj_transport'  => 300000,
            'uang_makan'    => 300000
        ]);
 
        // Employee
        // \App\Models\Employee::factory(3)->create();
        Employee::create([
            'salary_id'     => 1,
            'nip'           => '01136738',
            'nama'          => 'Christian Yohanes',
            'jenis_kelamin' => 'L',
            'tempat_lahir'  => 'Tangerang',
            'tgl_lahir'     => '2001-09-08',
            'alamat'        => 'Jl. Sudirman Selatan No. 34',
            'no_telp'       => '089691497717',
            'no_rek'        => '26384853',
            'bank'          => 'BCA',
            'tgl_masuk'     => '2020-01-01',
            'status'        => 2  
        ]);
        Employee::create([
            'salary_id'     => 2,
            'nip'           => '01276738',
            'nama'          => 'Marihot Tambunan',
            'jenis_kelamin' => 'P',
            'tempat_lahir'  => 'Cikarang',
            'tgl_lahir'     => '2003-09-08',
            'alamat'        => 'Jl. Sudirman Selatan No. 34',
            'no_telp'       => '089654678652',
            'no_rek'        => '76384853',
            'bank'          => 'Mandiri',
            'tgl_masuk'     => '2021-01-01',
            'status'        => 2  
        ]);
        Employee::create([
            'salary_id'     => 3,   // Apoteker
            'nip'           => '01376738',
            'nama'          => 'Handika Harahap',
            'jenis_kelamin' => 'L',
            'tempat_lahir'  => 'Surabaya',
            'tgl_lahir'     => '2002-09-08',
            'alamat'        => 'Jl. Sudirman Selatan No. 34',
            'no_telp'       => '089654676667',
            'no_rek'        => '56384853',
            'bank'          => 'BRI',
            'tgl_masuk'     => '2022-01-01',
            'status'        => 1    // karyawan Kontrak
        ]);
        Employee::create([
            'salary_id'     => 4,   // Asisten Apoteker
            'nip'           => '01476738',
            'nama'          => 'Emalia Putri',
            'jenis_kelamin' => 'P',
            'tempat_lahir'  => 'Tangerang',
            'tgl_lahir'     => '2001-06-12',
            'alamat'        => 'Jl. Sudirman Selatan No. 34',
            'no_telp'       => '089654677832',
            'no_rek'        => '96384853',
            'bank'          => 'BCA',
            'tgl_masuk'     => '2023-01-01',
            'status'        => 1    // karyawan Kontrak
        ]);
 
        // Users
        User::create([
            'employee_id'   => 1,
            'email'         => 'admin@gmail.com',
            'password'      => 'test123', // password
            'role_id'       => 1,   // role admin
        ]);
        User::create([
            'employee_id'   => 2,   // Umaya Hutagalung
            'email'         => 'bendahara@gmail.com',
            'password'      => 'test123', // password
            'role_id'       => 2,   // role bendahara
        ]);
        User::create([
            'employee_id'   => 3,   // Edi Ardianto
            'email'         => 'test@gmail.com',
            'password'      => 'test123', // password
            'role_id'       => 3,   // role karyawan
        ]);
        User::create([
            'employee_id'   => 4,   // Ludwina Fathihah
            'email'         => 'karyawan@gmail.com',
            'password'      => 'test123', // password
            'role_id'       => 3,   // role karyawan
        ]);
 
        \App\Models\Income::factory(35)->create();
        \App\Models\Outcome::factory(15)->create();
 
        // \App\Models\Debt::factory(10)->create();
    }
}