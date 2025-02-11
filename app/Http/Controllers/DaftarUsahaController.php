<?php

namespace App\Http\Controllers;

use App\Models\DaftarUsaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\VerifikasiPermohonan;
use illuminate\support\Facades\DB;
use App\Models\DetilJenisRetribusiUsaha;

class DaftarUsahaController extends Controller
{
    public function index()
    {
        $daftarUsaha = DaftarUsaha::with('jenis_retribusi')->get();

        return view('pages.daftar.usaha.index', compact('daftarUsaha'));
    }

    public function lihat($id)
    {
        $usaha = DaftarUsaha::with('jenis_retribusi')->findOrFail($id);

        return view('pages.daftar.usaha.lihat', compact('usaha'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_registrasi' => 'required|string',
            'nm_wr' => 'required|string',
            'npwrd1' => 'required|string|max:4',
            'npwrd2' => 'required|string|max:4',
            'npwrd3' => 'required|string|max:4',
            'nama' => 'required|string|max:100',
            'kd_rekening' => 'required|string|max:20',
            'email' => 'required|string',
            'kota' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg',
            'id_kelurahan' => 'required|integer',
            'id_kecamatan' => 'required|integer',
            'no_handphone' => 'required|string|max:15',
            'alamat_usaha' => 'required|string|max:255',
            'pemilik' => 'required|string|max:50',
            'retribusi_details' => 'array',
            'retribusi_details.*' => 'string',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $originalFileName = $request->file('foto')->getClientOriginalName();
            $fotoPath = $request->file('foto')->storeAs('foto', $originalFileName, 'public');
            $fotoPath = '' . $originalFileName;
        }

        $npwrd = implode('', [
            $request->npwrd1,
            $request->npwrd2,
            $request->npwrd3,
        ]);

        if (DaftarUsaha::where('npwrd', $npwrd)->exists()) {
            return back()->withErrors(['npwrd' => 'NPWRD sudah terdaftar.'])->withInput();
        }

        try {
            $usaha = DaftarUsaha::create([
                'no_registrasi' => $request->no_registrasi,
                'nm_wr' => $request->nm_wr,
                'npwrd' => $npwrd,
                'nama' => $request->nama,
                'kd_rekening' => $request->kd_rekening,
                'email' => $request->email,
                'kota' => $request->kota,
                'foto' => $fotoPath,
                'kd_kelurahan' => $request->id_kelurahan,
                'kd_kecamatan' => $request->id_kecamatan,
                'no_handphone' => $request->no_handphone,
                'alamat_usaha' => $request->alamat_usaha,
                'pemilik' => $request->pemilik ?? null,
            ]);
            $retribusi_details = $request->input('retribusi_details', []);
            if (count($retribusi_details) > 0) {
                foreach ($retribusi_details as $kd_rekening) {
                    DetilJenisRetribusiUsaha::create([
                        'daftar_id' => $usaha->id,
                        'kd_rekening' => $kd_rekening,
                        'nilai_checkbox' => true,
                    ]);
                }
            }
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ])->withInput();
        }

        return redirect()->route('pages.registrasi.index')
            ->with('success', 'Pendaftaran berhasil!');
    }

    public function edit($id)
    {
        $usaha = DaftarUsaha::findOrFail($id);
        return view('pages.registrasi.edit', compact('usaha'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_registrasi' => 'required|string',
            'nm_wr' => 'required|string|max:20',
            'npwrd' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'email' => 'required|string',
            'kota' => 'required|string',
            'id_kelurahan' => 'required|integer',
            'id_kecamatan' => 'required|integer',
            'no_handphone' => 'required|string|max:15',
            'alamat_usaha' => 'required|string|max:255',
            'pemilik' => 'nullable|string|max:50',
            'foto' => 'image|mimes:jpeg,png,jpg',
        ]);

        $usaha = DaftarUsaha::findOrFail($id);

        $fotoPath = $usaha->foto;

        if ($request->hasFile('foto')) {
            $originalFileName = $request->file('foto')->getClientOriginalName();
            $fotoPath = $request->file('foto')->storeAs('foto', $originalFileName, 'public');
            $fotoPath = '' . $originalFileName;
        }

        $usaha->update([
            'no_registrasi' => $request->no_registrasi,
            'nm_wr' => $request->nm_wr,
            'npwrd' => $request->npwrd,
            'nama' => $request->nama,
            'email' => $request->email,
            'kota' => $request->kota,
            'kd_kelurahan' => $request->id_kelurahan,
            'kd_kecamatan' => $request->id_kecamatan,
            'no_handphone' => $request->no_handphone,
            'alamat_usaha' => $request->alamat_usaha,
            'pemilik' => $request->pemilik,
            'foto' => $fotoPath,
        ]);

        VerifikasiPermohonan::where('npwrd', $usaha->npwrd)->update([
            'nm_wr' => $request->nm_wr,
            'alamat_usaha' => $request->alamat_usaha,
            'no_handphone' => $request->no_handphone,
            'pemilik' => $request->pemilik,
        ]);

        $usaha->save();

        return redirect()->back()->with('success', 'Data usaha berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $usaha = DaftarUsaha::findOrFail($id);
            $usaha->delete();

            return redirect()->route('pages.daftar.usaha.index')
                ->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ]);
        }
    }

    public function cetakPdf($id)
    {
        $usaha = DaftarUsaha::findOrFail($id);

        $pdf = PDF::loadView('pages.daftar.usaha.cetak', compact('usaha'));

        return $pdf->stream('daftar_usaha_' . $usaha->id . '.pdf');
    }

    public function getNpwrdSequence($kd_kecamatan)
    {
        $latestNpwrd = DaftarUsaha::where('kd_kecamatan', $kd_kecamatan)
            ->orderBy('npwrd', 'desc')
            ->first();

        $sequence = $latestNpwrd ? (int) substr($latestNpwrd->npwrd, -4) + 1 : 1;

        return response()->json(['sequence' => str_pad($sequence, 4, '0', STR_PAD_LEFT)]);
    }

    public function getJenisRetribusi(Request $request)
    {
        $request->validate([
            'kd_jenis_retribusi' => 'required|string|size:5',
            'daftar_id' => 'required|integer',
            'retribusi_details' => 'array',
            'retribusi_details.*' => 'string',
        ]);

        $kd_jenis_retribusi = $request->input('kd_jenis_retribusi');
        $daftar_id = $request->input('daftar_id');
        $retribusi_details = $request->input('retribusi_details', []);

        $data = DB::table('jenis_retribusi')
            ->where(DB::raw('LEFT(kd_rekening, 5)'), '=', $kd_jenis_retribusi)
            ->get();

        if (count($retribusi_details) > 0) {
            foreach ($retribusi_details as $kd_rekening) {
                if ($data->contains('kd_rekening', $kd_rekening)) {
                    DetilJenisRetribusiUsaha::create([
                        'daftar_id' => $daftar_id,
                        'kd_rekening' => $kd_rekening,
                        'nilai_checkbox' => true,
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
