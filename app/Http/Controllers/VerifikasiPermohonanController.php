<?php

namespace App\Http\Controllers;

use App\Models\VerifikasiPermohonan;
use App\Models\PermohonanFaktur;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\PermohonanFakturDetil;

class VerifikasiPermohonanController extends Controller
{
    public function index()
    {
        $permohonan = PermohonanFaktur::rightJoin('permohonan_faktur_detil', 'permohonan_faktur.no_permohonan', '=', 'permohonan_faktur_detil.no_permohonan')
            ->select(
                'permohonan_faktur.id as permohonan_faktur_id',
                'permohonan_faktur_detil.id as permohonan_faktur_detil_id',
                'permohonan_faktur.*',
                'permohonan_faktur_detil.*'
            )
            ->orderByRaw("FIELD(status, 'Menunggu', 'Diterima', 'Ditolak')")
            ->get();

        // dd($permohonan);
        return view('pages.verifikasi.permohonan.index', compact('permohonan'));
    }

    public function showValidationForm($id)
    {
        $permohonan = PermohonanFaktur::find($id);
        return view('pages.verifikasi.permohonan.validasi', compact('permohonan'));
    }

    public function validateRequest($id)
    {
        $permohonan = PermohonanFakturDetil::findOrFail($id);
        $permohonan->status = 'Diterima';
        $permohonan->save();

        // VerifikasiPermohonan::where('no_permohonan', $permohonan->no_permohonan)
        //     ->update(['status' => 'Diterima']);

        return redirect()->route('pages.verifikasi.permohonan.index')->with('success', 'Data telah diverifikasi dan Permohonan Anda Diterima.');
    }

    public function invalidateRequest($id)
    {
        $permohonan = PermohonanFakturDetil::findOrFail($id);
        $permohonan->status = 'Ditolak';
        $permohonan->save();

        // VerifikasiPermohonan::where('no_permohonan', $permohonan->no_permohonan)
        //     ->update(['status' => 'Ditolak']);

        return redirect()->route('pages.verifikasi.permohonan.index')->with('error', 'Data telah diverifikasi dan Permohonan Anda Ditolak.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_permohonan' => 'required|string|max:255',
            'nm_wr' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'npwrd' => 'required|string|max:21',
            'alamat_usaha' => 'required|string|max:255',
            'no_handphone' => 'required|digits_between:10,15',
            'pemilik' => 'required|string|max:255',
            'kd_rekening' => 'required|string|max:20',
            'no_seri' => 'required|array',
            'no_seri.*' => 'required|string',
            'no_awal' => 'required|array',
            'no_awal.*' => 'required|integer',
            'no_akhir' => 'required|array',
            'no_akhir.*' => 'required|integer',
            'jml_lembar' => 'required|array',
            'jml_lembar.*' => 'required|integer',
            'tarif' => 'required|array',
            'tarif.*' => 'required|integer',
            'total' => 'required|array',
            'total.*' => 'required|integer',
        ]);

        // dd($request->all())
        try {
            $permohonanFaktur = PermohonanFaktur::create([
                'no_permohonan' => $request->no_permohonan,
                'nm_wr' => $request->nm_wr,
                'nama' => $request->nama,
                'npwrd' => $request->npwrd,
                'alamat_usaha' => $request->alamat_usaha,
                'no_handphone' => $request->no_handphone,
                'pemilik' => $request->pemilik,
                'kd_rekening' => $request->kd_rekening,

            ]);

            foreach ($request->no_seri as $index => $noSeri) {
                PermohonanFakturDetil::create([
                    'no_seri' => $noSeri,
                    'no_awal' => $request->no_awal[$index],
                    'no_akhir' => $request->no_akhir[$index],
                    'jml_lembar' => $request->jml_lembar[$index],
                    'tarif' => $request->tarif[$index],
                    'total' => $request->total[$index],
                    'no_permohonan' => $request->no_permohonan,
                    'status' => 'Menunggu'

                ]);
            }
            VerifikasiPermohonan::create([
                'no_permohonan' => $request->no_permohonan,
                'nm_wr' => $request->nm_wr,
                'nama' => $request->nama,
                'npwrd' => $request->npwrd,
                'alamat_usaha' => $request->alamat_usaha,
                'no_handphone' => $request->no_handphone,
                'pemilik' => $request->pemilik,
                'kd_rekening' => $request->kd_rekening,
                // 'status' => 'Menunggu'
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ])->withInput();
        }

        if (Auth::check() && Auth::user()->role_id === 3) {
            return back()->with('success', 'Permohonan berhasil ditambahkan.');
        } else {

            return redirect()->route('pages.verifikasi.permohonan.index')->with('success', 'Permohonan berhasil ditambahkan.');
        }
    }

    public function updateStatus(Request $request)
    {
        $permohonan = PermohonanFakturDetil::find($request->id);
        // dd($permohonan);
        if ($permohonan) {
            $permohonan->status = $request->status;
            $permohonan->save();

            // VerifikasiPermohonan::where('no_permohonan', $permohonan->no_permohonan)
            //     ->update(['status' => $request->status]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }




    public function destroy($id)
    {
        $permohonan = PermohonanFaktur::findOrFail($id);
        $permohonan->delete();

        return redirect()->route('verifikasi_permohonan.index')->with('success', 'Permohonan berhasil dihapus.');
    }

    public function cetak($id)
    {
        $permohonan = PermohonanFaktur::find($id);

        if (!$permohonan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        return view('pages.verifikasi.permohonan.lihat', compact('permohonan'));
    }

    public function cetakPdf(Request $request)
    {

        $id = $request->query('sid');
        $permohonan = PermohonanFaktur::with('daftarUsaha')->findOrFail($id);


        $pdf = Pdf::loadView('pages.verifikasi.permohonan.cetak', compact('permohonan'));


        // return $pdf->download('permohonan-wajib-pajak.pdf'); // Unduh langsung
        return $pdf->stream('permohonan-wajib-pajak.pdf'); // Tampilkan di browser
    }
}
