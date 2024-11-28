<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Registrasi;
use App\Models\Billing;
use App\Models\PermohonanFaktur;
use App\Models\VerifikasiPermohonan;

class MainController extends Controller
{
    public function dashboard()
    {
        $news = News::all();
        $news = News::where('status_aktif', 1)->orderBy('id', 'desc')->get(); 

        $totalJmlLembar = Billing::sum('ssrd_jml_lembar');
        $pengajuanProses = VerifikasiPermohonan::where('status', 'diterima')->count();
        $jumlahPengajuan = PermohonanFaktur::count();
        $totalSetor = Billing::sum('ssrd_nilai_setor');

        $formattedTotalSetor = 'Rp' . number_format($totalSetor, 0, ',', '.');

        echo $formattedTotalSetor;
        return view('pages.dashboard', compact('news',  'totalJmlLembar', 'pengajuanProses', 'jumlahPengajuan', 'formattedTotalSetor'));
    }

    public function create()
    {
        return view('pages/registrasi.create');
    }

    public function daftarUsaha()
    {
        return view('pages/daftar-usaha');
    }

    public function loginV3()
    {
        return view('pages/login-v3');
    }

    public function verifikasiPermohonan()
    {
        return view('pages/verifikasi-permohonan');
    }

    public function permohonanFaktur()
    {
        return view('pages/permohonan-faktur');
    }

    public function permohonanReturUsaha()
    {
        return view('pages/permohonan-retur-usaha');
    }

    public function daftarPenetapanBilling()
    {
        return view('pages/daftar-penetapan-billing');
    }

    public function rekapSetorStruk()
    {
        return view('pages/rekap-setor-struk');
    }

    public function laporanPenerimaan()
    {
        return view('pages/laporan-penerimaan');
    }

    public function laporanPermohonan()
    {
        return view('pages/laporan-permohonan');
    }

    public function laporanStokStruk()
    {
        return view('pages/laporan-stok-struk');
    }

    public function laporanPersediaanStruk()
    {
        return view('pages/laporan-persediaan-struk');
    }

    public function laporanReturStruk()
    {
        return view('pages/laporan-retur-struk');
    }

    public function manajemenUser()
    {
        return view('pages/manajemen-user');
    }

    public function manajemenStruk()
    {
        return view('pages/manajemen-struk');
    }

    public function manajemenPejabat()
    {
        return view('pages/manajemen-pejabat');
    }

    // Metode baru untuk menampilkan form pendaftaran
    public function createRegistrasi()
    {
        return view('registrasi.create'); // Pastikan file ini ada
    }

    // Metode baru untuk menyimpan data pendaftaran
    public function storeRegistrasi(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'npwrd1' => 'required|string|max:1',
            'npwrd2' => 'required|string|max:1',
            'npwrd3' => 'required|string|max:2',
            'npwrd4' => 'required|string|max:2',
            'npwrd5' => 'required|string|max:7',
            'fullname' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'no_handphone' => 'required|digits_between:10,15',
            'no_rekening' => 'required|digits',
            'alamat_usaha' => 'required|string|max:255',
            'jenis' => 'required|string',
            'pemilik' => 'nullable|string',
        ]);

        // Simpan data ke dalam model
        Registrasi::create($request->all());

        // Redirect ke halaman sukses atau kembali ke form dengan pesan sukses
        return redirect()->route('registrasi.create')->with('success', 'Pendaftaran berhasil!');
    }
}
