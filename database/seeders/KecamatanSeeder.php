<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    public function run()
    {
        $kecamatan = [
            ['id' => 1, 'kd_kecamatan' => '150', 'nm_kecamatan' => 'ANGGANA', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'kd_kecamatan' => '270', 'nm_kecamatan' => 'KEMBANG JANGGUT', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'kd_kecamatan' => '111', 'nm_kecamatan' => 'KENOHAN', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'kd_kecamatan' => '250', 'nm_kecamatan' => 'KOTA BANGUN', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'kd_kecamatan' => '130', 'nm_kecamatan' => 'LOA JANAN', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'kd_kecamatan' => '100', 'nm_kecamatan' => 'LOA KULU', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'kd_kecamatan' => '161', 'nm_kecamatan' => 'MARANG KAYU', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'kd_kecamatan' => '160', 'nm_kecamatan' => 'MUARA BADAK', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'kd_kecamatan' => '110', 'nm_kecamatan' => 'MUARA JAWA', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'kd_kecamatan' => '240', 'nm_kecamatan' => 'MUARA KAMAN', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'kd_kecamatan' => '90', 'nm_kecamatan' => 'MUARA MUNTAI', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'kd_kecamatan' => '251', 'nm_kecamatan' => 'MUARA WIS', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'kd_kecamatan' => '120', 'nm_kecamatan' => 'SAMBOJA', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'kd_kecamatan' => '140', 'nm_kecamatan' => 'SANGA-SANGA', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'kd_kecamatan' => '180', 'nm_kecamatan' => 'SEBULU', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'kd_kecamatan' => '280', 'nm_kecamatan' => 'TABANG', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'kd_kecamatan' => '170', 'nm_kecamatan' => 'TENGGARONG', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'kd_kecamatan' => '171', 'nm_kecamatan' => 'TENGGARONG SEBERANG', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'kd_kecamatan' => '121', 'nm_kecamatan' => 'SAMBOJA BARAT', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'kd_kecamatan' => '252', 'nm_kecamatan' => 'KOTA BANGUN DARAT', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($kecamatan as $kecamatan) {
            DB::table('kecamatan')->insert($kecamatan);
        }
    }
}
