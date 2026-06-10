<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hibah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_hibah',
        'sumber',
        'jenis',
        'tahun',
        'ketua_pengusul',
        'program_studi',
        'total_diusulkan',
        'total_disetujui',
        'judul_deskripsi',
        'tanggal_pengajuan',
        'durasi_bulan',
        'status',
        'link_dokumen',
    ];
}
