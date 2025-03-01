<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class SheetExport implements FromArray, WithHeadings, WithStyles, WithTitle, WithEvents
{
    protected $data;
    protected $headings;
    protected $title; 

    public function __construct($data, $headings, $title)
    {
        $this->data = $data;
        $this->headings = $headings;
        $this->title = $title; // Simpan nama sheet
    }

    public function array(): array
    {
        return collect($this->data)->map(function ($item) {
            return is_array($item) ? $item : (array) $item;
        })->toArray();
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '2DAA9E']]
            ],
        ];
    }

    public function title(): string
    {
        return $this->title; // Berikan nama sheet sesuai parameter di constructor
    }

    // 🚀 Menyesuaikan ukuran kolom secara otomatis
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                foreach (range('A', 'Z') as $column) { 
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
