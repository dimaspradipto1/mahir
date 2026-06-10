<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class HibahRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_hibah' => 'required|string',
            'sumber' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'tahun' => 'required|numeric|digits:4',
            'ketua_pengusul' => 'required|string|max:255',
            'program_studi' => 'nullable|string|max:255',
            'total_diusulkan' => 'required|numeric',
            'total_disetujui' => 'nullable|numeric',
            'judul_deskripsi' => 'nullable|string',
            'tanggal_pengajuan' => 'nullable|date',
            'durasi_bulan' => 'nullable|numeric',
            'status' => 'required|string|max:255',
            'link_dokumen' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Kolom :attribute wajib diisi.',
            'tahun.numeric' => 'Tahun harus berupa angka.',
            'tahun.digits' => 'Tahun harus 4 digit angka.',
        ];
    }
}
