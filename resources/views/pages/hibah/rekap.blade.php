@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Rekap Hibah</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Hibah</li>
                <li class="breadcrumb-item active">Rekap Hibah</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body mt-3">
            <h5 class="card-title p-0 mb-3" style="font-size: 16px; font-weight: 600; color: #012970;">Laporan Seluruh Rekapitulasi Hibah</h5>
            <div class="table-responsive">
                {{ $dataTable->table([
                    'class' => 'table table-hover align-middle',
                    'style' => 'width:100%;',
                ]) }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Ensure DataTables Buttons extension scripts are loaded -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    
    @if (app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
@endpush
