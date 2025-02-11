<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusSeeder extends Seeder
{
    public function run()
    {
        $menus = [
            [
                'name' => 'Dashboard',
                'slug' => 'dashboard',
            ],
            [
                'name' => 'Pelayanan',
                'slug' => 'pelayanan',
            ],
            [
                'name' => 'Registrasi',
                'slug' => 'registrasi',
            ],
            [
                'name' => 'Permohononan Faktur',
                'slug' => 'permohonan-faktur',
            ],
            [
                'name' => 'Daftar Usaha',
                'slug' => 'daftar-usaha',
            ],
            [
                'name' => 'Verifikasi Permohonan',
                'slug' => 'verifikasi-permohonan',
            ],
            [
                'name' => 'Input SSRD',
                'slug' => 'input-ssrd',
            ],
            [
                'name' => 'Penetapan',
                'slug' => 'penetapan',
            ],
            [
                'name' => 'Daftar Penetapan Billing',
                'slug' => 'penetapan-billing',
            ],
            [
                'name' => 'Pembayaran',
                'slug' => 'pembayaran',
            ],
            [
                'name' => 'Pembayaran Billing',
                'slug' => 'pembayaran-billing',
            ],
            [
                'name' => 'Laporan',
                'slug' => 'laporan',
            ],
            [
                'name' => 'Rekap Setor Struk',
                'slug' => 'rekap-setor-struk',
            ],
            [
                'name' => 'Laporan Penerimaan',
                'slug' => 'laporan-penerimaan',
            ],
            [
                'name' => 'Laporan Permohonan',
                'slug' => 'laporan-permohonan',
            ],
            [
                'name' => 'Laporan Stok Karcis',
                'slug' => 'laporan-stok-struk',
            ],
            [
                'name' => 'Laporan Persediaan Karcis',
                'slug' => 'laporan-persediaan-struk',
            ],
            [
                'name' => 'Setting',
                'slug' => 'setting',
            ],
            [
                'name' => 'Manajemen User',
                'slug' => 'manajemen-user',
            ],
            [
                'name' => 'Manajemen Level',
                'slug' => 'manajemen-level',
            ],
            [
                'name' => 'Manajemen Berita',
                'slug' => 'manajemen-berita',
            ],
        ];

        // Insert the menu data into the menus table
        foreach ($menus as $menu) {
            DB::table('menus')->insert($menu);
        }
    }
}
