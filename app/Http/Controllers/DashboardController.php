<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hibah;

class DashboardController extends Controller
{
    private function formatRupiah($number)
    {
        if ($number >= 1000000000) {
            return 'Rp ' . str_replace(',00', '', number_format($number / 1000000000, 2, ',', '.')) . ' M';
        } elseif ($number >= 1000000) {
            return 'Rp ' . str_replace(',00', '', number_format($number / 1000000, 2, ',', '.')) . ' jt';
        }
        return 'Rp ' . number_format($number, 0, ',', '.');
    }

    public function index()
    {
        $years = Hibah::select('tahun')->distinct()->orderBy('tahun', 'desc')->limit(3)->pluck('tahun')->sort()->values()->toArray();
        if (empty($years)) {
            $years = [date('Y') - 2, date('Y') - 1, date('Y')];
        }
        while (count($years) < 3) {
            $years[] = end($years) + 1;
        }
        sort($years);
        
        $year1 = $years[0];
        $year2 = $years[1];
        $year3 = $years[2];

        $hibahs = Hibah::whereIn('tahun', $years)->get();

        $totalHibah = $hibahs->sum('total_diusulkan');
        $totalsByYear = [
            $year1 => $hibahs->where('tahun', $year1)->sum('total_diusulkan'),
            $year2 => $hibahs->where('tahun', $year2)->sum('total_diusulkan'),
            $year3 => $hibahs->where('tahun', $year3)->sum('total_diusulkan'),
        ];
        
        $highestYear = array_keys($totalsByYear, max($totalsByYear))[0];
        
        $percentChange = 0;
        if ($totalsByYear[$year2] > 0) {
            $percentChange = (($totalsByYear[$year3] - $totalsByYear[$year2]) / $totalsByYear[$year2]) * 100;
        }
        $percentChangeStr = ($percentChange > 0 ? '+' : '') . str_replace('.', ',', round($percentChange, 1)) . '%';

        $sumberList = ['Perguruan Tinggi', 'DIKTI', 'Eksternal'];
        $barSeries = [];
        foreach ($sumberList as $sumber) {
            $data = [];
            foreach ($years as $year) {
                // Convert back to Millions (jt) for the bar chart so the Y-axis says 'Rp ... jt'
                $data[] = round($hibahs->where('tahun', $year)->where('sumber', $sumber)->sum('total_diusulkan') / 1000000, 2);
            }
            $barSeries[] = [
                'name' => $sumber,
                'data' => $data
            ];
        }

        $donutData = [];
        $donutTotal = [];
        $donutPercent = [];
        foreach ($sumberList as $sumber) {
            $sum = $hibahs->where('sumber', $sumber)->sum('total_diusulkan');
            $donutData[] = $sum;
            $donutTotal[$sumber] = $this->formatRupiah($sum);
        }
        
        $maxDonut = empty($donutData) || max($donutData) == 0 ? 1 : max($donutData);
        foreach ($sumberList as $index => $sumber) {
            $donutPercent[$sumber] = ($donutData[$index] / $maxDonut) * 100;
        }

        $totalHibahStr = $this->formatRupiah($totalHibah);
        $highestYearStr = $this->formatRupiah($totalsByYear[$highestYear]);
        $year2Str = $this->formatRupiah($totalsByYear[$year2]);
        $year3Str = $this->formatRupiah($totalsByYear[$year3]);

        return view('layouts.dashboard.index', compact(
            'years', 'year1', 'year2', 'year3', 'highestYear', 'totalsByYear',
            'totalHibahStr', 'highestYearStr', 'year2Str', 'year3Str',
            'percentChangeStr', 'totalHibah', 'barSeries', 'donutData', 'donutTotal', 'donutPercent', 'sumberList'
        ))->with('formatRupiah', function($num) { return $this->formatRupiah($num); });
    }
}
