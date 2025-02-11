<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Billing;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanStrukController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        $userRoleId = $user->role_id;

        $query = Billing::join('daftar_usaha', 'billing.npwrd', '=', 'daftar_usaha.npwrd')
            ->join('permohonan_faktur', 'billing.npwrd', '=', 'permohonan_faktur.npwrd')
            ->leftJoin('permohonan_faktur_detil', 'permohonan_faktur.no_permohonan', '=', 'permohonan_faktur_detil.no_permohonan')
            ->select(
                'billing.*',
                'daftar_usaha.nama as daftarUsaha_nama',
                'daftar_usaha.alamat_usaha as daftarUsaha_alamat',
                'permohonan_faktur_detil.jml_lembar as jumlahLembar'
            )
            ->distinct();


        if ($userRoleId === 3) {
            $query->where('daftar_usaha.nama', $user->fullname);
        }

        $names = $query->get()->unique('daftarUsaha_nama');


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

        return view('pages.laporan.struk.index', compact('billings', 'names'));
    }

    public function cetakPdf(Request $request)
    {
        $pdf = Pdf::loadView('pages.laporan.struk.cetak');
        return $pdf->stream('cetak-laporan.struk.pdf');
    }
}
