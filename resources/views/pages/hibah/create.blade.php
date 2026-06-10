@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Hibah</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hibah.index') }}">Data Hibah</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tambah Hibah Baru</h5>

                    <form action="{{ route('hibah.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="nama_hibah" class="form-label">Nama hibah</label>
                                <input type="text" class="form-control @error('nama_hibah') is-invalid @enderror" id="nama_hibah" name="nama_hibah" value="{{ old('nama_hibah') }}" placeholder="Contoh: Hibah Penelitian Dasar DIKTI 2026">
                                @error('nama_hibah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="sumber" class="form-label">Sumber pendanaan</label>
                                <select class="form-select @error('sumber') is-invalid @enderror" id="sumber" name="sumber">
                                    <option value="">-- Pilih Sumber Dana --</option>
                                    <option value="Perguruan Tinggi" {{ old('sumber') == 'Perguruan Tinggi' ? 'selected' : '' }}>Perguruan Tinggi</option>
                                    <option value="DIKTI" {{ old('sumber') == 'DIKTI' ? 'selected' : '' }}>DIKTI</option>
                                    <option value="Eskternal" {{ old('sumber') == 'Eskternal' ? 'selected' : '' }}>Eskternal</option>
                                </select>
                                @error('sumber')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="jenis" class="form-label">Jenis hibah</label>
                                <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis">
                                    <option value="">-- Pilih Jenis Hibah --</option>
                                    <option value="Penelitian" {{ old('jenis') == 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                                    <option value="PKM" {{ old('jenis') == 'PKM' ? 'selected' : '' }}>PKM</option>
                                    <option value="Lainnya" {{ old('jenis') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tahun" class="form-label">Tahun usulan</label>
                                <input type="number" min="2000" max="2099" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}">
                                @error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="Diproses" {{ old('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Disetujui" {{ old('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="Ditolak" {{ old('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ketua_pengusul" class="form-label">Ketua pengusul</label>
                                <input type="text" class="form-control @error('ketua_pengusul') is-invalid @enderror" id="ketua_pengusul" name="ketua_pengusul" value="{{ old('ketua_pengusul') }}" placeholder="Nama dosen pengusul">
                                @error('ketua_pengusul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="program_studi" class="form-label">Program studi</label>
                                <select class="form-select @error('program_studi') is-invalid @enderror" id="program_studi" name="program_studi">
                                    <option value="">-- Pilih Program Studi --</option>
                                    <optgroup label="Fakultas Ekonomi dan Bisnis">
                                        <option value="S2 Manajemen" {{ old('program_studi') == 'S2 Manajemen' ? 'selected' : '' }}>S2 Manajemen</option>
                                        <option value="S1 Manajemen" {{ old('program_studi') == 'S1 Manajemen' ? 'selected' : '' }}>S1 Manajemen</option>
                                        <option value="S1 Akuntansi" {{ old('program_studi') == 'S1 Akuntansi' ? 'selected' : '' }}>S1 Akuntansi</option>
                                    </optgroup>
                                    <optgroup label="Fakultas Ilmu Kesehatan">
                                        <option value="S2 Magister Kesehatan Masyarakat" {{ old('program_studi') == 'S2 Magister Kesehatan Masyarakat' ? 'selected' : '' }}>S2 Magister Kesehatan Masyarakat</option>
                                        <option value="S1 Kesehatan dan Keselamatan Kerja (K3)" {{ old('program_studi') == 'S1 Kesehatan dan Keselamatan Kerja (K3)' ? 'selected' : '' }}>S1 Kesehatan dan Keselamatan Kerja (K3)</option>
                                        <option value="S1 Kesehatan Lingkungan" {{ old('program_studi') == 'S1 Kesehatan Lingkungan' ? 'selected' : '' }}>S1 Kesehatan Lingkungan</option>
                                    </optgroup>
                                    <optgroup label="Fakultas Sains dan Teknologi">
                                        <option value="S1 Teknik Informatika" {{ old('program_studi') == 'S1 Teknik Informatika' ? 'selected' : '' }}>S1 Teknik Informatika</option>
                                        <option value="S1 Teknik Industri" {{ old('program_studi') == 'S1 Teknik Industri' ? 'selected' : '' }}>S1 Teknik Industri</option>
                                        <option value="S1 Sistem Informasi" {{ old('program_studi') == 'S1 Sistem Informasi' ? 'selected' : '' }}>S1 Sistem Informasi</option>
                                        <option value="S1 Teknik Perkapalan" {{ old('program_studi') == 'S1 Teknik Perkapalan' ? 'selected' : '' }}>S1 Teknik Perkapalan</option>
                                        <option value="S1 Teknik Logistik" {{ old('program_studi') == 'S1 Teknik Logistik' ? 'selected' : '' }}>S1 Teknik Logistik</option>
                                    </optgroup>
                                    <option value="Lainnya" {{ old('program_studi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('program_studi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="total_diusulkan" class="form-label">Total diusulkan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('total_diusulkan') is-invalid @enderror" id="total_diusulkan" name="total_diusulkan" value="{{ old('total_diusulkan') }}" placeholder="contoh: 50000000">
                                </div>
                                @error('total_diusulkan')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="total_disetujui" class="form-label">Total disetujui</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('total_disetujui') is-invalid @enderror" id="total_disetujui" name="total_disetujui" value="{{ old('total_disetujui') }}" placeholder="kosongkan jika belum">
                                </div>
                                @error('total_disetujui')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="judul_deskripsi" class="form-label">Judul/deskripsi singkat</label>
                                <textarea class="form-control @error('judul_deskripsi') is-invalid @enderror" id="judul_deskripsi" name="judul_deskripsi" rows="3" placeholder="Deskripsi singkat tema atau topik hibah...">{{ old('judul_deskripsi') }}</textarea>
                                @error('judul_deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tanggal_pengajuan" class="form-label">Tanggal pengajuan</label>
                                <input type="date" class="form-control @error('tanggal_pengajuan') is-invalid @enderror" id="tanggal_pengajuan" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan', date('Y-m-d')) }}">
                                @error('tanggal_pengajuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="durasi_bulan" class="form-label">Durasi (bulan)</label>
                                <input type="number" class="form-control @error('durasi_bulan') is-invalid @enderror" id="durasi_bulan" name="durasi_bulan" value="{{ old('durasi_bulan') }}" placeholder="12">
                                @error('durasi_bulan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="link_dokumen" class="form-label">Link Dokumen (Opsional)</label>
                                <input type="text" class="form-control @error('link_dokumen') is-invalid @enderror" id="link_dokumen" name="link_dokumen" value="{{ old('link_dokumen') }}" placeholder="https://...">
                                @error('link_dokumen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('hibah.index') }}" class="btn btn-light px-4 me-2">Batal</a>
                            <button type="submit" class="btn btn-success px-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
