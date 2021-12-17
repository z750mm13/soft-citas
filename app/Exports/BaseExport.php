<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class BaseExport implements WithEvents, WithDrawings {
    protected $cellRange = 'A1:W1';
    protected $sizes = [];
    protected $pdf = false;
    function _construct($cellRange, $sizes = array(), $pdf = false) {
        $this->cellRange = $cellRange;
        $this->sizes = $sizes;
        $this->pdf = $pdf;
    }
    /**
     * @return array
     */
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                foreach ($this->sizes as $size) {
                    $event->sheet->getDelegate()->getColumnDimension($size['name'])->setWidth(($size['value'])+($this->pdf?5:0));
                }

                $cellRange = $this->cellRange; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('A7:D7')->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle(str_replace($cellRange, '1', '2'))->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle(str_replace($cellRange, '1', '3'))->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle(str_replace($cellRange, '1', '6'))->getFont()->setSize(14);

                $event->sheet->getStyle('D1:D3')->applyFromArray([
                    'borders' => [
                        'left' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $event->sheet->getStyle('A3:D3')->applyFromArray([
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }

    public function drawings() {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is imss logo');
        $drawing->setPath(public_path('resources/img/imss.png'));
        $drawing->setHeight(60);
        $drawing->setCoordinates('D1');
        $drawing->setOffsetX(5);

        return $drawing;
    }
}
