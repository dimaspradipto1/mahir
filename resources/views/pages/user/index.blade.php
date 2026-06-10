@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Form Pengguna</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Pengguna</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="card">
        <div class="card-body mt-3">
            @if(auth()->user()->role == 'superadmin' || auth()->user()->role == 'admin')
            <div class="mb-3">
                <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm px-3 py-2 rounded">Tambah</a>
            </div>
            @endif
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
