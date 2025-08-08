<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VulnerableController extends Controller
{
    public function fetchContent(Request $request)
    {
        // Mendapatkan URL dari input pengguna TANPA validasi.
        $url = $request->input('target_url');

        // Pastikan URL tidak kosong
        if (empty($url)) {
            return 'Masukkan Target Tujuan Anda';
        }

        // Pencegahan Akses ke File Local
         $host = parse_url($url, PHP_URL_HOST);

        if ($host === 'localhost' || $host === '127.0.0.1') {
            return 'Akses ke alamat IP lokal dilarang.';
        }

        // Periksa apakah IP adalah IP privat menggunakan filter_var
        $ip = gethostbyname($host);
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            abort(403, 'Akses ditolak.');
        }
        // --- Akhir Code Keamanan ---

        try {
            // Gunakan fungsi PHP bawaan file_get_contents()
            $content = file_get_contents($url);

            // Mengembalikan isi dari file atau URL
            return $content;

        } catch (\Exception $e) {
            // Tangani error jika permintaan gagal
            return 'Terjadi kesalahan: ' . $e->getMessage();
        }
    }
}