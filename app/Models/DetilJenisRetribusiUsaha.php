<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetilJenisRetribusiUsaha extends Model
{
    use HasFactory;

    protected $table = 'detil_jenis_retribusi_usaha';

    protected $fillable = [
        'daftar_id',
        'kd_rekening',
        'nilai_checkbox',
    ];
    public function jenis_retribusi()
    {
        return $this->belongsTo(JenisRetribusi::class, 'kd_rekening', 'kd_rekening');
    }
    public function daftar_usaha()
    {
        return $this->belongsTo(DaftarUsaha::class, 'daftar_id', 'daftar_id');
    }
}
