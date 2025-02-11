<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Billing;


class LaporanPembayaranController extends Controller
{

    public function index(Request $request)
    {
        $billings = Billing::where('status', 'lunas')->get();

        return view('pages.laporan.pembayaran.index', compact('billings'));
    }
}
