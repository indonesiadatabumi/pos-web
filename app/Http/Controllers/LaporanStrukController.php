<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Billing;
use Carbon\Carbon;

class LaporanStrukController extends Controller
{
    public function index(Request $request)
    {
        // Inisialisasi query dasa
        $billings = Billing::all();
        $query = Billing::join('daftar_usaha', 'billing.npwrd', '=', 'daftar_usaha.npwrd')
            ->select(
                'billing.*',
                'daftar_usaha.nama as daftarUsaha_nama',
                'daftar_usaha.alamat_usaha as daftarUsaha_alamat'
            );

        if ($request->filled('nama')) {
            $query->where('daftar_usaha.nama', $request->nama);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('billing.created_at', [$request->start_date, $request->end_date]);
        }
        $billings = $query->get()->map(function ($item) {
            $item->formatted_created_at = Carbon::parse($item->created_at)->format('Y-m-d');
            $item->ssrd_jml_lembar = $item->ssrd_no_akhir + $item->ssrd_sisa;
            return $item;
        });

        if ($request->ajax()) {
            return response()->json($billings);
        }

        return view('pages.laporan.struk.index', compact('billings'));
    }
    public function cetakPdf(Request $request)
    {
        $pdf = Pdf::loadView('pages.laporan.struk.cetak');


        return $pdf->stream('cetak-laporan.struk.pdf');
    }
}
