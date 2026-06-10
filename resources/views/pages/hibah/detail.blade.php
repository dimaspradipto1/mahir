@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Detail Rekap Hibah</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Detail Hibah</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-secondary"><i class="bi bi-layout-text-window-reverse me-1"></i> DETAIL REKAP HIBAH</h6>
            <div class="d-flex align-items-center gap-2">
                <form action="{{ route('hibah.detail') }}" method="GET" class="d-flex align-items-center m-0 gap-2">
                    <label class="form-label m-0 text-nowrap text-secondary" style="font-size: 0.875rem;">Filter Tahun:</label>
                    <select name="tahun1" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                        <option value="">-- Kolom 1 --</option>
                        @foreach($available_years as $y)
                            <option value="{{ $y }}" {{ request('tahun1', $selected_years[0] ?? '') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                    <select name="tahun2" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                        <option value="">-- Kolom 2 --</option>
                        @foreach($available_years as $y)
                            <option value="{{ $y }}" {{ request('tahun2', $selected_years[1] ?? '') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                    <select name="tahun3" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                        <option value="">-- Kolom 3 --</option>
                        @foreach($available_years as $y)
                            <option value="{{ $y }}" {{ request('tahun3', $selected_years[2] ?? '') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
        <div class="card-body mt-3">
            <div class="table-responsive">
                {{ $dataTable->table([
                    'class' => 'table table-hover table-bordered align-middle',
                    'style' => 'width:100%;',
                ], true) }}
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    @if (app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
    
    <script>
        // Custom styling for datatables headers to match the previous green theme
        $(document).ready(function() {
            var tableId = 'detailhibah-table'; // Make sure this matches setTableId in DataTable class
            
            // Wait for DataTables to draw
            $('#' + tableId).on('draw.dt', function() {
                var thead = $('#' + tableId + ' thead');
                thead.css({
                    'background-color': '#3b7444',
                    'color': 'white'
                });
                thead.find('th').css({
                    'font-weight': '500'
                });
            });
            
            // Initialize once for the first load
            setTimeout(function() {
                var thead = $('#' + tableId + ' thead');
                thead.css({
                    'background-color': '#3b7444',
                    'color': 'white'
                });
                thead.find('th').css({
                    'font-weight': '500'
                });
            }, 100);
        });
    </script>
@endpush
