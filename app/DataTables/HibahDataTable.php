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

class HibahDataTable extends DataTable
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
            ->addColumn('link_dokumen', function ($row) {
                if ($row->link_dokumen) {
                    return '<a href="' . $row->link_dokumen . '" target="_blank" class="text-success text-decoration-none fw-bold" style="font-size: 12px; white-space: nowrap;" title="Lihat Dokumen"><i class="bi bi-link-45deg me-1"></i>Lihat Dokumen</a>';
                }
                return '-';
            })
            ->addColumn('action', function ($row) {
                if (auth()->user()->role == 'user' || auth()->user()->role == 'pimpinan') {
                    return '';
                }
                $btn = '<div class="d-flex justify-content-center align-items-center" style="gap: 5px;">';
                $btn .= '<a href="' . route('hibah.edit', $row->id) . '" class="btn btn-sm btn-warning text-white rounded shadow-sm d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" title="Edit"><i class="fa-solid fa-pen-to-square" style="font-size: 11px;"></i></a>';
                $btn .= '<form action="' . route('hibah.destroy', $row->id) . '" method="POST" class="m-0">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm rounded shadow-sm d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;" title="Hapus" onclick="return confirm(\'Yakin ingin menghapus data ini?\')"><i class="fa-solid fa-trash-can" style="font-size: 11px;"></i></button></form>';
                $btn .= '</div>';
                return $btn;
            })
            ->setRowId('id')
            ->rawColumns(['action', 'status', 'link_dokumen']);
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
            ->setTableId('hibah-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
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
            Column::make('total_diusulkan')
                ->title('Total Diusulkan'),
            Column::make('total_disetujui')
                ->title('Total Disetujui'),
            Column::make('status')
                ->title('Status')
                ->addClass('text-center'),
            Column::make('link_dokumen')
                ->title('Dokumen')
                ->exportable(false)
                ->printable(false)
                ->width('5%')
                ->addClass('text-center'),
            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->width('10%')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Hibah_' . date('YmdHis');
    }
}
