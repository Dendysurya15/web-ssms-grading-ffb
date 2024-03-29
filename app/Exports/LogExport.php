<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithDrawings;

class LogExport implements FromView, WithEvents, WithDrawings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     //
    //     return DB::table('log')->get();
    // }
    public $summary;
    public $data;

    public function __construct($summary, $data)
    {
        $this->summary = $summary;
        $this->data = $data;
    }

    public function view(): View
    {
        return view('export.log', [
            'summary' => $this->summary,
            'data' => $this->data,
        ]);
    }
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/img/logo-SSS.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B3');

        return $drawing;
    }
    public function registerEvents(): array
    {
        // dd();
        // dd($this->data->last()->iterasi);
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A10:G10')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '#20353F'],
                        ],
                    ],
                    'B' => ['alignment' => ['wrapText' => true]],
                ]);
                $event->sheet->getStyle('A11:G' . ($this->data->last()->iterasi + 10))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '#262B30'],
                        ],
                    ]
                ]);
            }
        ];
    }
}
