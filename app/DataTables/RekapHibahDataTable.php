<?php

namespace App\DataTables;

use App\Models\Hibah;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RekapHibahDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Hibah> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', '')
            ->editColumn('total_diusulkan', function ($row) {
                return 'Rp ' . number_format($row->total_diusulkan, 0, ',', '.');
            })
            ->editColumn('total_disetujui', function ($row) {
                return $row->total_disetujui ? 'Rp ' . number_format($row->total_disetujui, 0, ',', '.') : '-';
            })
            ->addColumn('status', function ($item) {
                $status = ucfirst($item->status);
                $badgeClass = match(strtolower($item->status)) {
                    'disetujui' => 'bg-success',
                    'diproses' => 'bg-warning text-dark',
                    'ditolak' => 'bg-danger',
                    'draft' => 'bg-secondary',
                    default => 'bg-secondary'
                };
                return '<span class="badge rounded-pill ' . $badgeClass . '">' . $status . '</span>';
            })
            ->setRowId('id')
            ->rawColumns(['status']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Hibah>
     */
    public function query(Hibah $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('rekap-hibah-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'dom' => "<'row mb-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>" .
                         "<'row'<'col-sm-12'tr>>" .
                         "<'row mt-3'<'col-md-5'i><'col-md-7 d-flex justify-content-end'p>>",
                'buttons' => [
                    ['extend' => 'excel', 'className' => 'btn btn-success btn-sm px-3', 'text' => '<i class="bi bi-file-earmark-excel me-1"></i> Excel'],
                    ['extend' => 'csv', 'className' => 'btn btn-info btn-sm px-3 text-white', 'text' => '<i class="bi bi-filetype-csv me-1"></i> CSV'],
                    [
                        'extend' => 'pdf',
                        'className' => 'btn btn-danger btn-sm px-3',
                        'text' => '<i class="bi bi-file-earmark-pdf me-1"></i> PDF',
                        'orientation' => 'landscape',
                        'pageSize' => 'A4',
                        'customize' => 'function(doc) {
                            doc.content.splice(0, 1);
                            var logo = "data:image/png;base64,' . base64_encode(file_get_contents(public_path('assets/img/logouis.png'))) . '";
                            var header = {
                                columns: [
                                    { image: logo, width: "20%", alignment: "right", margin: [0, 0, 15, 0] },
                                    {
                                        stack: [
                                            { text: "YAYASAN PENDIDIKAN IBNU SINA BATAM (YAPISTA)", style: "headerSub", alignment: "center" },
                                            { text: "UNIVERSITAS IBNU SINA (UIS)", style: "headerMain", alignment: "center" },
                                            { text: "Jalan Teuku Umar, Lubuk Baja, Kota Batam-Indonesia Telp. 0778 - 408 3113", style: "headerSmall", alignment: "center" },
                                            { text: "Email : info@uis.ac.id / uibnusina@gmail.com Website : uis.ac.id", style: "headerSmall", alignment: "center" }
                                        ],
                                        alignment: "center",
                                        width: "60%"
                                    },
                                    { width: "20%", text: "" }
                                ],
                                margin: [0, 0, 0, 10]
                            };
                            var line = {
                                canvas: [
                                    { type: "line", x1: 0, y1: 0, x2: 760, y2: 0, lineWidth: 1, lineColor: "#2c6e3c" },
                                    { type: "line", x1: 0, y1: 3, x2: 760, y2: 3, lineWidth: 2, lineColor: "#2c6e3c" }
                                ],
                                margin: [0, 0, 0, 15]
                            };
                            var title = { text: "LAPORAN REKAPITULASI HIBAH", alignment: "center", fontSize: 14, bold: true, margin: [0, 0, 0, 15] };
                            doc.content.unshift(title);
                            doc.content.unshift(line);
                            doc.content.unshift(header);
                            doc.styles = doc.styles || {};
                            doc.styles.headerSub = { fontSize: 12, bold: true, color: "#2c6e3c" };
                            doc.styles.headerMain = { fontSize: 20, bold: true, color: "#2c6e3c" };
                            doc.styles.headerSmall = { fontSize: 10 };
                            doc.styles.tableHeader = { bold: true, fontSize: 10, color: "black", fillColor: "#f2f2f2", alignment: "center" };
                            doc.defaultStyle.fontSize = 9;
                            
                            var objLayout = {};
                            objLayout[\'hLineWidth\'] = function(i) { return 0.5; };
                            objLayout[\'vLineWidth\'] = function(i) { return 0.5; };
                            objLayout[\'hLineColor\'] = function(i) { return \'#000000\'; };
                            objLayout[\'vLineColor\'] = function(i) { return \'#000000\'; };
                            objLayout[\'paddingLeft\'] = function(i) { return 4; };
                            objLayout[\'paddingRight\'] = function(i) { return 4; };
                            doc.content[3].layout = objLayout;
                            doc.content[3].table.widths = ["5%", "15%", "10%", "10%", "5%", "15%", "10%", "10%", "10%", "10%"]; 
                        }'
                    ],
                ],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                ->title('NO')
                ->width('5%')
                ->addClass('text-center')
                ->searchable(false)
                ->orderable(false),
            Column::make('nama_hibah')
                ->title('Nama Hibah'),
            Column::make('sumber')
                ->title('Sumber'),
            Column::make('jenis')
                ->title('Jenis'),
            Column::make('tahun')
                ->title('Tahun')
                ->width('10%')
                ->addClass('text-center'),
            Column::make('ketua_pengusul')
                ->title('Ketua Pengusul'),
            Column::make('program_studi')
                ->title('Program Studi'),
            Column::make('total_diusulkan')
                ->title('Total Diusulkan'),
            Column::make('total_disetujui')
                ->title('Total Disetujui'),
            Column::make('status')
                ->title('Status')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Rekap_Hibah_' . date('YmdHis');
    }
}
