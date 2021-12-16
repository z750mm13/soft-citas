<?php

namespace App\Exports;

use App\Consultation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PrescriptionExport implements FromView, WithEvents, WithDrawings {
    protected $cellRange = 'A1:W1';
    private $consultation_id = null;
    function __construct($consultation_id) {
        $this->cellRange = 'A1:D1';
        $this->consultation_id = $consultation_id;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View {
        return view('consultations.prescriptions.report', [
            'consultation' => Consultation::findOrFail($this->consultation_id)
        ]);
    }

    /**
     * @return array
     */
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = $this->cellRange; // All headers
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(70);
                $event->sheet->getDelegate()->getRowDimension('7')->setRowHeight(9);
                $event->sheet->getDelegate()->getRowDimension('10')->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension('12')->setRowHeight(30);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle(str_replace($cellRange, '1', '2'))->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle(str_replace($cellRange, '1', '3'))->getFont()->setSize(12);
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
