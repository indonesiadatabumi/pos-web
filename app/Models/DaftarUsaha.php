<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarUsaha extends Model
{
    use HasFactory;

    protected $table = 'daftar_usaha';

    public function permohonanFaktur()
    {
        return $this->hasMany(PermohonanFaktur::class, 'no_permohonan', 'no_permohonan');
    }


    protected $fillable = [
        'no_registrasi',
        'no_permohonan',
        'npwrd',
        'nm_wr',
        'nama',
        'email',
        'kd_rekening',
        'kota',
        'foto',
        'kd_kelurahan',
        'kd_kecamatan',
        // 'tempat_lahir',
        // 'tanggal_lahir',
        // 'alamat',
        'no_handphone',
        // 'no_rekening',
        'alamat_usaha',
        'pemilik',
    ];


    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kd_kecamatan', 'kd_kecamatan');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kd_kelurahan', 'kd_kelurahan');
    }
    public function jenis_retribusi()
    {
        return $this->belongsTo(JenisRetribusi::class, 'kd_rekening', 'kd_rekening');
    }
    public function detilRetribusi()
    {
        return $this->hasMany(DetilJenisRetribusiUsaha::class, 'daftar_id', 'id');
    }
}
