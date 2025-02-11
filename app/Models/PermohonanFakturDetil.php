<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanFakturDetil extends Model
{
    use HasFactory;

    protected $table = 'permohonan_faktur_detil';

    protected $fillable = [
        'no_seri',
        'no_awal',
        'no_akhir',
        'jml_lembar',
        'tarif',
        'total',
        'no_permohonan',
        'status',
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'npwrd', 'npwrd');
    }
    public function permohonanFaktur()
{
    return $this->belongsTo(PermohonanFaktur::class, 'no_permohonan', 'no_permohonan');
}

}
