<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'id_billing',
        'ntp',
        'status',
    ];
    public function billing()
    {
        return $this->belongsTo(billing::class, 'id_billing', 'id_billing');
    }
}
