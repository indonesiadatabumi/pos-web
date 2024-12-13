<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanFaktur;
use Carbon\Carbon;

class LaporanPermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PermohonanFaktur::rightJoin(
            'permohonan_faktur_detil',
            'permohonan_faktur.no_permohonan',
            '=',
            'permohonan_faktur_detil.no_permohonan'
        );

        // Filter berdasarkan nama
        if ($request->filled('nama')) {
            $query->where('nm_wr', 'like', '%' . $request->nama . '%');
        }

        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('permohonan_faktur.created_at', [$request->start_date, $request->end_date]);
        }

        $laporanPermohonan = $query->get()->map(function ($item) {
            $item->formatted_created_at = Carbon::parse($item->created_at)->format('Y-m-d');
            $item->formatted_tarif = 'Rp' . number_format($item->tarif, 0, ',', '.');
            $item->formatted_total = 'Rp' . number_format($item->total, 0, ',', '.');
            return $item;
        });
        if ($request->ajax()) {
            return response()->json($laporanPermohonan);
        }

        $uniqueNames = PermohonanFaktur::select('nm_wr')
            ->distinct()
            ->pluck('nm_wr');

        // Return ke view
        return view('pages.laporan.permohonan.index', compact('laporanPermohonan', 'uniqueNames'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
