<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Billing;
use Illuminate\Support\Carbon;

class LaporanPersediaanController extends Controller
{
    public function index(Request $request)
    {
        $billings = Billing::all()->map(function ($item) {

            $item->tarif = 'Rp' . number_format($item->ssrd_tarif, 0, ',', '.');
            $item->nilai_setor = 'Rp' . number_format($item->ssrd_nilai_setor, 0, ',', '.');

            $item->tahun_rekam = Carbon::parse($item->tanggal_rekam)->format('Y');

            return $item;
        });

        return view('pages.laporan.persediaan.index', compact('billings'));
    }
}
