<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Models\Hibah;

class DetailHibahDataTable extends DataTable
{
    protected $years = [];

    public function __construct()
    {
        $this->years = [];
        if (request()->has('tahun1') || request()->has('tahun2') || request()->has('tahun3')) {
            if (request()->filled('tahun1')) $this->years[] = (int) request('tahun1');
            if (request()->filled('tahun2')) $this->years[] = (int) request('tahun2');
            if (request()->filled('tahun3')) $this->years[] = (int) request('tahun3');
        } elseif (request()->has('tahun') && request()->filled('tahun')) {
            $year = (int) request('tahun');
            $this->years = [$year - 2, $year - 1, $year];
        }

        if (count($this->years) < 3) {
            $default = Hibah::select('tahun')->distinct()->orderBy('tahun', 'desc')->limit(3)->pluck('tahun')->sort()->values()->toArray();
            if (empty($default)) {
                $default = [date('Y') - 1, date('Y'), date('Y') + 1];
            }
            while (count($default) < 3) {
                $default[] = end($default) + 1;
            }
            
            // Fill missing
            for ($i = count($this->years); $i < 3; $i++) {
                $this->years[] = $default[$i];
            }
        }
        // sort($this->years);  // we don't sort here so user can determine order
    }

    public function getYears()
    {
        return $this->years;
    }

    public function dataTable($query)
    {
        $dt = datatables()->collection($query);
        
        $dt->editColumn('sumber', function($row) {
            if ($row['sumber'] == 'Perguruan Tinggi') {
                return '<span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2 text-wrap">' . $row['sumber'] . '</span>';
            } elseif ($row['sumber'] == 'DIKTI') {
                return '<span class="badge rounded-pill bg-info bg-opacity-10 px-3 py-2 text-wrap" style="color: #6f42c1 !important; background-color: #f3e8ff !important;">' . $row['sumber'] . '</span>';
            } else {
                return '<span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 text-wrap">' . $row['sumber'] . '</span>';
            }
        });

        foreach ($this->years as $year) {
            $dt->editColumn((string)$year, function($row) use ($year) {
                return $row[$year] > 0 ? number_format($row[$year], 0, ',', '.') : '&mdash;';
            });
        }
        
        $dt->editColumn('total', function($row) {
            return number_format($row['total'], 0, ',', '.');
        });
        
        $dt->rawColumns(array_merge(['sumber'], array_map('strval', $this->years), ['total']));

        $dt->with('sum_footer', function() use ($query) {
            $footer = [
                'sumber' => 'TOTAL HIBAH',
                'jenis' => '',
            ];
            
            foreach ($this->years as $year) {
                $sum = $query->sum($year);
                $footer[$year] = number_format($sum, 0, ',', '.');
            }
            $footer['total'] = number_format($query->sum('total'), 0, ',', '.');
            
            return $footer;
        });

        return $dt;
    }

    public function query()
    {
        $raw_data = Hibah::all();
        $summary = [];
        
        foreach ($raw_data as $h) {
            $key = $h->sumber . '_' . $h->jenis;
            if (!isset($summary[$key])) {
                $summary[$key] = [
                    'sumber' => $h->sumber,
                    'jenis' => $h->jenis,
                    $this->years[0] => 0,
                    $this->years[1] => 0,
                    $this->years[2] => 0,
                    'total' => 0
                ];
            }
            
            if (in_array($h->tahun, $this->years)) {
                $summary[$key][$h->tahun] += $h->total_diusulkan;
                $summary[$key]['total'] += $h->total_diusulkan;
            }
        }

        return collect(array_values($summary));
    }

    public function html(): HtmlBuilder
    {
        $columns = [
            Column::make('sumber')->title('Sumber')->footer('TOTAL HIBAH')->className('text-center align-middle')->width('15%'),
            Column::make('jenis')->title('Jenis')->footer('')->className('align-middle')->width('25%'),
        ];
        
        foreach ($this->years as $year) {
            $columns[] = Column::make((string)$year)->title((string)$year)->footer('0')->className('text-end align-middle')->width('15%');
        }
        
        $columns[] = Column::make('total')->title('Jumlah 3 Tahun')->footer('0')->className('text-end align-middle fw-bold')->width('15%');

        return $this->builder()
                    ->setTableId('detailhibah-table')
                    ->columns($columns)
                    ->minifiedAjax()
                    ->orderBy(0, 'asc')
                    ->parameters([
                        'footerCallback' => 'function (row, data, start, end, display) {
                            var api = this.api();
                            var json = api.ajax.json();
                            
                            if(json && json.sum_footer) {
                                // We do not use colspan to avoid datatables misalignment
                                $(api.column(0).footer()).html(json.sum_footer.sumber).removeClass("text-end").addClass("text-center fw-bold").css({"background-color": "#f8f9fa"});
                                $(api.column(1).footer()).html("").css({"background-color": "#f8f9fa"});
                                
                                api.columns().every(function(index) {
                                    if(index >= 2 && index < api.columns().count() - 1) {
                                        var colName = this.dataSrc();
                                        $(this.footer()).html(json.sum_footer[colName]).addClass("text-end fw-bold").css({"background-color": "#f8f9fa", "color": "#212529"});
                                    }
                                });
                                // total column
                                $(api.column(api.columns().count() - 1).footer()).html(json.sum_footer.total).addClass("text-end fw-bold").css({"background-color": "#d1e7dd", "color": "#0f5132"});
                            }
                        }'
                    ]);
    }
}
