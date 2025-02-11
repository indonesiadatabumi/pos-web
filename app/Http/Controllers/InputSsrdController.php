<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerifikasiPermohonan;
use App\Models\Billing;
use Illuminate\Support\Facades\Auth;
use App\Models\PermohonanFakturDetil;

class InputSsrdController extends Controller
{

    public function index()
    {
        $billings = Billing::all();
        $user = Auth::user();
        $validatedSerialNumbers = [];
        if ($user->role_id == 3) {
            $validatedSerialNumbers = VerifikasiPermohonan::rightJoin('permohonan_faktur_detil', 'verifikasi_permohonan.no_permohonan', '=', 'permohonan_faktur_detil.no_permohonan')
                ->where('status', 'Diterima')
                ->where('nama', $user->fullname)
                ->pluck('no_seri');
        } else {
            $validatedSerialNumbers = VerifikasiPermohonan::rightJoin('permohonan_faktur_detil', 'verifikasi_permohonan.no_permohonan', '=', 'permohonan_faktur_detil.no_permohonan')
                ->where('status', 'Diterima')
                ->pluck('no_seri');
        }

        return view('pages.input.ssrd.index', compact('validatedSerialNumbers', 'billings'));
    }

    public function getTarif(Request $request)
    {
        $noSeri = $request->input('no_seri');
        // $noAwal = $request->input('no_awal');
        // $noAkhir = $request->input('no_akhir');

        $verifikasi = PermohonanFakturDetil::where('no_seri', $noSeri)
            // ->where('no_awal', '<=', $noAwal)
            // ->where('no_akhir', '>=', $noAkhir)
            ->first();

        $billing = Billing::where('ssrd_no_seri', $noSeri)
            // ->where('ssrd_no_awal', '<=', $noAwal)
            // ->where('ssrd_no_akhir', '>=', $noAkhir)
            ->latest()->first();
        // dd($billing);
        if ($verifikasi || $billing) {
            return response()->json([
                'tarif' => $verifikasi->tarif,
                'jml_lembar' => $verifikasi->jml_lembar,
                'sisa_belum_setor' => $billing->ssrd_sisa ?? $verifikasi->jml_lembar,
            ]);
        }

        return response()->json(['tarif' => null]);
    }
}
