<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanFaktur;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanPermohonanController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        $userRoleId = $user->role_id;

        $query = PermohonanFaktur::rightJoin(
            'permohonan_faktur_detil',
            'permohonan_faktur.no_permohonan',
            '=',
            'permohonan_faktur_detil.no_permohonan'
        );

        if ($userRoleId === 3) {
            $query->where('permohonan_faktur.nama', $user->fullname);
        }


        if ($request->filled('nama')) {
            $query->where('permohonan_faktur.nama', 'like', '%' . $request->nama . '%');
        }

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

        $uniqueNames = PermohonanFaktur::select('nama')
            ->distinct()
            ->pluck('nama');

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
