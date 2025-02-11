<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\DaftarUsaha;


class PembayaranController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        $userRoleId = $user->role_id;

        $query = Billing::leftJoin('pembayaran', 'billing.id_billing', '=', 'pembayaran.id_billing')
            ->select('billing.*')
            ->whereNull('pembayaran.id_billing');

        if ($userRoleId === 3) {
            $userFullname = $user->fullname;

            $daftarUsaha = DaftarUsaha::where('nama', $userFullname)->first();

            if ($daftarUsaha) {
                $npwrd = $daftarUsaha->npwrd;
                $query->where('npwrd', $npwrd);
            }
        }

        $billings = $query->get();

        return view('pages.pembayaran.index', compact('billings'));
    }

    public function getData($id_billing)
    {
        $billing = Billing::with('daftarUsaha')->where('id_billing', $id_billing)->first();

        if ($billing) {
            return response()->json([
                'nama' => $billing->daftarUsaha->nama ?? 'Tidak ada data',
                'npwrd' => $billing->npwrd,
                'ssrd_no_seri' => $billing->ssrd_no_seri,
                'ssrd_no_awal' => $billing->ssrd_no_awal,
                'ssrd_no_akhir' => $billing->ssrd_no_akhir,
                'ssrd_jml_lembar' => $billing->ssrd_jml_lembar,
                'ssrd_nilai_setor' => $billing->ssrd_nilai_setor,
            ]);
        }

        return response()->json(['message' => 'Data not found'], 404);
    }

    public function store(Request $request)
    {

        $request->validate([
            'id_billing' => 'required|exists:billing,id_billing',
        ]);

        $id_billing = $request->input('id_billing');

        $ntp = Carbon::now()->format('YmdHis') . rand(0, 9999);

        Pembayaran::create([
            'id_billing' => $id_billing,
            'ntp' => $ntp,
            'status' => 'Lunas',
        ]);


        $billing = Billing::where('id_billing', $id_billing)->first();
        if ($billing) {

            $billing->status = 'Lunas';
            $billing->save();
        }

        session()->flash('pembayaran_berhasil', 'Pembayaran berhasil dilakukan!');

        return redirect()->route('pages.pembayaran.index')->with('success', 'Pembayaran berhasil disimpan dan status billing diperbarui menjadi Lunas');
    }
    public function searchBilling(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        $userRoleId = $user->role_id;

        $query = Billing::query();

        $searchQuery = $request->input('query');

        if ($userRoleId === 3) {
            $userFullname = $user->fullname;

            $daftarUsaha = DaftarUsaha::where('nama', $userFullname)->first();

            if ($daftarUsaha) {
                $npwrd = $daftarUsaha->npwrd;
                $query->where('npwrd', $npwrd);
            }
        }
        $query->where('status', '!=', 'Lunas');

        if ($searchQuery) {
            $query->where('id_billing', 'LIKE', "%{$searchQuery}%");
        }

        $billings = $query->get(['id_billing', 'npwrd']);

        return response()->json($billings->map(function ($billing) {
            return [
                'id' => $billing->id_billing,
                'text' => $billing->id_billing,
            ];
        }));
    }
}
