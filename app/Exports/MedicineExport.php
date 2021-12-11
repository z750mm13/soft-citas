<?php

namespace App\Exports;

use App\Medicine;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class MedicineExport implements FromView, ShouldAutoSize, WithEvents {
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('medicines.report', [
            'medicines' => Medicine::all()
        ]);
    }
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
