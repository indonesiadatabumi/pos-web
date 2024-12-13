<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisRetribusi extends Model
{
    use HasFactory;

    protected $table = 'jenis_retribusi';

    protected $fillable = [
        'kd_rekening',
        'nm_retribusi',
        'dasar_hukum_pengenaan',
        'item',
        'non_karcis',
        'karcis',
        'denda',
        'fk_denda',
        'lv_kategori',
        'sub_kategori',
        'kode_kategori',
    ];
}
