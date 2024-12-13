<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class PermohonanFaktur extends Model
{
    use HasFactory;

    protected $table = 'permohonan_faktur';

    protected $fillable = [
        'no_permohonan',
        'nm_wr',
        'nama',
        'npwrd',
        'alamat_usaha',
        'no_handphone',
        'pemilik',
        'kd_rekening',
        // 'no_seri',
        // 'no_awal',
        // 'no_akhir',
        // 'jml_lembar',
        // 'tarif',
        // 'total',
        // 'status',
    ];

    public function daftarUsaha()
    {
        return $this->belongsTo(DaftarUsaha::class, 'npwrd', 'npwrd');
    }

    public function permohonanFakturDetil()
    {
        return $this->belongsTo(PermohonanFakturDetil::class, 'no_permohonan', 'no_permohonan');
    }
    public function details()
    {
        return $this->hasMany(PermohonanFakturDetil::class, 'no_permohonan', 'no_permohonan');
    }
    public function jenis_retribusi()
    {
        return $this->belongsTo(JenisRetribusi::class, 'kd_rekening', 'kd_rekening');
    }
}
