<?php

namespace App\Exports;

use App\Models\KeluhanPelanggan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KeluhanPelangganExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return KeluhanPelanggan::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'Nomor HP',
            'Status',
            'Keluhan',
            'created_at',
        ];
    }
}

