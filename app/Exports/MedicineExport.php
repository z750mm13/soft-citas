<?php

namespace App\Exports;

use App\Medicine;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MedicineExport extends BaseExport implements FromView {
    function __construct() {
        parent::_construct('A1:D1');
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('medicines.report', [
            'medicines' => Medicine::all()
        ]);
    }
}
