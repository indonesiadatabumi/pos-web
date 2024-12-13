<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use Illuminate\Http\Request;
use App\Models\InputSsrd;
use App\Models\VerifikasiPermohonan;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class BillingController extends Controller
{
    public function index()
    {
        $billings = Billing::with('daftarUsaha')->get();
        return view('pages.penetapan.billing.index', compact('billings'));
    }
    public function store(Request $request)
    {
        $request->validate([
            // 'no_permohonan' => 'required|string|max:255',
            // 'npwrd' => 'required|string',
            // 'nama' => 'required|string',
            // 'nm_wr' => 'required|string',
            'ssrd_no_seri' => 'required|string|max:255',
            'ssrd_no_awal' => 'required|integer',
            'ssrd_no_akhir' => 'required|integer',
            'ssrd_jml_lembar' => 'required|integer',
            'ssrd_sisa' => 'required|integer',
            'ssrd_tarif' => 'required|integer',
            'ssrd_nilai_setor' => 'required|integer',
            // 'metode_bayar' => 'required|string',
        ]);

        $verifikasiPermohonan = VerifikasiPermohonan::rightJoin(
            'permohonan_faktur_detil',
            'verifikasi_permohonan.no_permohonan',
            '=',
            'permohonan_faktur_detil.no_permohonan'
        )->where('permohonan_faktur_detil.no_seri', $request->ssrd_no_seri)->first();

        $nomorBilling = $this->nomorBilling($verifikasiPermohonan);

        try {
            Billing::create([
                // 'no_permohonan' => $request->no_permohonan,
                'npwrd' => $verifikasiPermohonan->npwrd,
                // 'nama' => $request->nama,
                // 'nm_wr' => $request->nm_wr,
                'id_billing' => $nomorBilling,
                'ssrd_no_seri' => $request->ssrd_no_seri,
                'ssrd_no_awal' => $request->ssrd_no_awal,
                'ssrd_no_akhir' => $request->ssrd_no_akhir,
                'ssrd_jml_lembar' => $request->ssrd_jml_lembar,
                'ssrd_sisa' => $request->ssrd_sisa,
                'ssrd_tarif' => $request->ssrd_tarif,
                'ssrd_nilai_setor' => $request->ssrd_nilai_setor,
                // 'metode_bayar' => $request->metode_bayar,
            ]);

            // Billing::create([
            //     'no_permohonan' => $request->no_permohonan,
            //     'npwrd' => $request->npwrd,
            //     'nm_wr' => $request->nm_wr,
            //     'nama' => $request->nama,
            //     'ssrd_no_seri' => $request->ssrd_no_seri,
            //     'ssrd_no_awal' => $request->ssrd_no_awal,
            //     'ssrd_no_akhir' => $request->ssrd_no_akhir,
            //     'ssrd_jml_lembar' => $request->ssrd_jml_lembar,
            //     'ssrd_sisa' => $request->ssrd_sisa,
            //     'ssrd_tarif' => $request->ssrd_tarif,
            //     'ssrd_nilai_setor' => $request->ssrd_nilai_setor,
            //     'metode_bayar' => $request->metode_bayar,
            // ]);

            return redirect()->route('pages.input.ssrd.index')->with('success', 'Data SSRD berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    public function nomorBilling($verifikasiPermohonan)
    {
        $datetime = Carbon::now()->format('ymdHis');

        $kodeRetribusi = '002';
        $nomerNPWRD = $verifikasiPermohonan->npwrd;
        $nomorUrut = substr($nomerNPWRD, -1);
        $nomorBilling = $datetime . $kodeRetribusi . '000' . $nomorUrut;

        return $nomorBilling;
    }
    public function cetak($id)
    {
        $billing = Billing::with('daftarUsaha')->findOrFail($id);

        $pdf = PDF::loadView('pages.penetapan.billing.cetak', compact('billing'))->setPaper('a4', 'portrait');

        return $pdf->stream('Billing_' . $billing->id_billing . '.pdf');
    }
}
