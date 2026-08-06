<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaExport implements FromCollection, WithHeadings
{
    /**
     * Ambil semua data siswa untuk diexport
     */
    public function collection()
    {
        return Siswa::select('nis', 'nama', 'kelas', 'jurusan', 'status')->get();
    }

    /**
     * Tambahkan heading di file Excel
     */
    public function headings(): array
    {
        return [
            'NIS',
            'Nama',
            'Kelas',
            'Jurusan',
            'Status',
        ];
    }
}
