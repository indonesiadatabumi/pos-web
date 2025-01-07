<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Billing;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanPenerimaanController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        $userRoleId = $user->role_id;

        $query = Billing::join('daftar_usaha', 'billing.npwrd', '=', 'daftar_usaha.npwrd')
            ->select(
                'billing.*',
                'daftar_usaha.nama as daftarUsaha_nama',
                'daftar_usaha.alamat_usaha as daftarUsaha_alamat'
            );

        if ($userRoleId === 3) {
            $query->where('daftar_usaha.nama', $user->fullname);
        }

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

        return view('pages.laporan.penerimaan.index', compact('billings'));
    }

    public function cetakPdf(Request $request, $id)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        $userRoleId = $user->role_id;

        $query = Billing::join('daftar_usaha', 'billing.npwrd', '=', 'daftar_usaha.npwrd')
            ->select(
                'billing.*',
                'daftar_usaha.nama as daftarUsaha_nama',
                'daftar_usaha.alamat_usaha as daftarUsaha_alamat'
            )
            ->where('billing.id', $id);

        if ($userRoleId === 3) {
            $query->where('daftar_usaha.nama', $user->fullname);
        }

        $billings = $query->first();

        $pdf = Pdf::loadView('pages.laporan.penerimaan.cetak', compact('billings'))
            ->setPaper([0, 0, 700, 1000]);

        return $pdf->stream('cetak-laporan.pdf');
    }
}
