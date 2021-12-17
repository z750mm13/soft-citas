<?php

namespace App\Exports;

use App\Medicine;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;

class MedicineExport extends BaseExport implements FromView {
    function __construct($pdf = false) {
        parent::_construct(
            'A1:D1', [
                [
                    'name' => 'A',
                    'value' => 40
                ],[
                    'name' => 'B',
                    'value' => 13.38
                ],[
                    'name' => 'C',
                    'value' => 17
                ],[
                    'name' => 'D',
                    'value' => 7.38
                ],
            ], $pdf
        );
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View {
        return view('medicines.report', [
            'medicines' => Medicine::all()
        ]);
    }
    
    public function _registerEvents(): array {
        return parent::registerEvents()+[
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(13.38);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(17);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(7.38);
            },
        ];
    }
}
