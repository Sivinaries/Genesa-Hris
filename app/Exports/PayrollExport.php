<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Agar lebar kolom otomatis
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class PayrollExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    protected $companyId;
    protected $start;
    protected $end;
    
    // Variabel untuk nomor urut
    private $rowNumber = 0;

    public function __construct($companyId, $start, $end)
    {
        $this->companyId = $companyId;
        $this->start = $start;
        $this->end = $end;
    }

    public function query()
    {
        return Payroll::query()
            ->with('employee')
            ->where('compani_id', $this->companyId)
            ->where('pay_period_start', $this->start)
            ->where('pay_period_end', $this->end);
    }

    // 1. Header Tabel
    public function headings(): array
    {
        return [
            'No',
            'Nama Karyawan',
            'No. Rekening', // Format Text agar 0 di depan tidak hilang
            'Jumlah Transfer (IDR)',
            'Bank' // Opsional: Biasanya finance butuh tahu bank-nya apa
        ];
    }

    // 2. Isi Data
    public function map($payroll): array
    {
        $this->rowNumber++; // Auto increment nomor

        return [
            $this->rowNumber,
            $payroll->employee->name,
            
            // Tanda kutip satu (') memaksa Excel membaca sebagai Teks
            // Ini penting agar nomor rekening tidak berubah jadi format scientific (1.2E+10)
            $payroll->employee->bank_account_no ? "" . $payroll->employee->bank_account_no : '-',
            
            $payroll->net_salary, // Jumlah bersih
            
            $payroll->employee->bank_name ?? '-', // Nama Bank (Opsional tapi berguna)
        ];
    }

    // 3. Styling
    public function styles(Worksheet $sheet)
    {
        return [
            // Baris 1 (Header) Bold
            1 => ['font' => ['bold' => true]],
        ];
    }

    // 4. Format Angka (Agar kolom Gaji ada pemisah ribuan)
    public function columnFormats(): array
    {
        return [
            'D' => '#,##0', // Kolom D (Jumlah) diformat angka currency
        ];
    }
}