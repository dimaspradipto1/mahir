<?php

namespace App\Http\Controllers;

use App\Models\Hibah;
use Illuminate\Http\Request;
use App\DataTables\HibahDataTable;
use App\Http\Requests\HibahRequest;
use RealRashid\SweetAlert\Facades\Alert;

class HibahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(HibahDataTable $dataTable)
    {
        $title = 'Data Hibah';
        $totalEntri = Hibah::count();
        $totalDisetujui = Hibah::where('status', 'Disetujui')->count();
        $totalDiproses = Hibah::where('status', 'Diproses')->count();
        
        $sumDana = Hibah::sum('total_diusulkan');
        if ($sumDana >= 1000000000) {
            $totalDanaDiusulkan = 'Rp ' . round($sumDana / 1000000000, 1) . ' M';
        } elseif ($sumDana >= 1000000) {
            $totalDanaDiusulkan = 'Rp ' . round($sumDana / 1000000, 1) . ' jt';
        } else {
            $totalDanaDiusulkan = 'Rp ' . number_format($sumDana, 0, ',', '.');
        }

        return $dataTable->render('pages.hibah.index', compact('title', 'totalEntri', 'totalDisetujui', 'totalDiproses', 'totalDanaDiusulkan'));
    }

    public function detail(\App\DataTables\DetailHibahDataTable $dataTable)
    {
        $title = 'Detail Hibah';
        $available_years = \App\Models\Hibah::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun')->toArray();
        $selected_years = $dataTable->getYears();
        return $dataTable->render('pages.hibah.detail', compact('title', 'available_years', 'selected_years'));
    }

    public function rekap(\App\DataTables\RekapHibahDataTable $dataTable)
    {
        $title = 'Rekap Hibah';
        return $dataTable->render('pages.hibah.rekap', compact('title'));
    }

    public function create()
    {
        $title = 'Tambah Hibah';
        return view('pages.hibah.create', compact('title'));
    }

    public function store(HibahRequest $request)
    {
        Hibah::create($request->validated());
        Alert::success('Berhasil', 'Data hibah berhasil ditambahkan');
        return redirect()->route('hibah.index');
    }

    public function show(Hibah $hibah)
    {
        //
    }

    public function edit(Hibah $hibah)
    {
        $title = 'Edit Hibah';
        return view('pages.hibah.edit', compact('title', 'hibah'));
    }

    public function update(HibahRequest $request, Hibah $hibah)
    {
        $hibah->update($request->validated());
        Alert::success('Berhasil', 'Data hibah berhasil diperbarui');
        return redirect()->route('hibah.index');
    }

    public function destroy(Hibah $hibah)
    {
        $hibah->delete();
        Alert::success('Berhasil', 'Data hibah berhasil dihapus');
        return redirect()->route('hibah.index');
    }
}
