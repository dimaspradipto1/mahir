@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Data Hibah</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Hibah</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row">
        <!-- Total Entri Card -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card sales-card" style="border-top: 2px solid #0d6efd; border-radius: 4px; box-shadow: 0px 0px 8px rgba(0,0,0,0.05);">
                <div class="card-body p-3">
                    <h5 class="card-title p-0 mb-3" style="font-size: 14px; font-weight: 600; color: #012970;">Total Entri <span class="text-muted fw-normal" style="font-size: 12px;">| Semua status</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #f6f6fe; color: #0d6efd;">
                            <i class="bi bi-journal-text fs-5"></i>
                        </div>
                        <div class="ps-3">
                            <h6 class="mb-0 fw-bold" style="font-size: 24px; color: #012970;">{{ $totalEntri }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Disetujui Card -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card revenue-card" style="border-top: 2px solid #198754; border-radius: 4px; box-shadow: 0px 0px 8px rgba(0,0,0,0.05);">
                <div class="card-body p-3">
                    <h5 class="card-title p-0 mb-3" style="font-size: 14px; font-weight: 600; color: #012970;">Disetujui <span class="text-muted fw-normal" style="font-size: 12px;">| Hibah aktif</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #e0f8e9; color: #198754;">
                            <i class="bi bi-check-circle fs-5"></i>
                        </div>
                        <div class="ps-3">
                            <h6 class="mb-0 fw-bold" style="font-size: 24px; color: #012970;">{{ $totalDisetujui }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diproses Card -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card customers-card" style="border-top: 2px solid #ffc107; border-radius: 4px; box-shadow: 0px 0px 8px rgba(0,0,0,0.05);">
                <div class="card-body p-3">
                    <h5 class="card-title p-0 mb-3" style="font-size: 14px; font-weight: 600; color: #012970;">Diproses <span class="text-muted fw-normal" style="font-size: 12px;">| Menunggu</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #ffecdf; color: #ffc107;">
                            <i class="bi bi-hourglass-split fs-5"></i>
                        </div>
                        <div class="ps-3">
                            <h6 class="mb-0 fw-bold" style="font-size: 24px; color: #012970;">{{ $totalDiproses }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Diusulkan Card -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card" style="border-top: 2px solid #0dcaf0; border-radius: 4px; box-shadow: 0px 0px 8px rgba(0,0,0,0.05);">
                <div class="card-body p-3">
                    <h5 class="card-title p-0 mb-3" style="font-size: 14px; font-weight: 600; color: #012970;">Total Diusulkan <span class="text-muted fw-normal" style="font-size: 12px;">| Seluruh entri</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #e0f6fd; color: #0dcaf0;">
                            <i class="bi bi-cash-stack fs-5"></i>
                        </div>
                        <div class="ps-3">
                            <h6 class="mb-0 fw-bold" style="font-size: 24px; color: #012970;">{{ $totalDanaDiusulkan }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body mt-3">
            <div class="mb-3">
                <a href="{{ route('hibah.create') }}" class="btn btn-primary btn-sm px-3 py-2 rounded">Tambah</a>
            </div>
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
    @if (app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
@endpush
