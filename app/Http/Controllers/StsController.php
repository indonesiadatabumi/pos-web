<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Billing;
use Carbon\Carbon;

class StsController extends Controller
{
    public function index(Request $request)
    {
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
            return $item;
        });

        if ($request->ajax()) {
            return response()->json($billings);
        }

        return view('pages.sts.index', compact('billings'));
    }
    public function cetakPdf(Request $request)
    {
        $billings = Billing::join('daftar_usaha', 'billing.npwrd', '=', 'daftar_usaha.npwrd')
            ->select(
                'billing.*',
                'daftar_usaha.nama as daftarUsaha_nama',
                'daftar_usaha.alamat_usaha as daftarUsaha_alamat'
            )
            ->get();

        $pdf = Pdf::loadView('pages.sts.cetak', compact('billings'))
            ->setPaper([0, 0, 700, 1000]);

        return $pdf->stream('cetak-sts.pdf');
    }
}
