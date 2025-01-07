<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Billing;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanPersediaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Billing::query();

        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        $userRoleId = $user->role_id;

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_rekam', $request->tahun);
        }

        $billings = $query->get()->map(function ($item) {
            $item->tarif = 'Rp' . number_format($item->ssrd_tarif, 0, ',', '.');
            $item->nilai_setor = 'Rp' . number_format($item->ssrd_nilai_setor, 0, ',', '.');
            $item->tahun_rekam = Carbon::parse($item->tanggal_rekam)->format('Y');
            return $item;
        });

        return view('pages.laporan.persediaan.index', compact('billings'));
    }
}
