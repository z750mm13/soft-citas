<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Appointment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AppointmentExport extends BaseExport implements FromView {
    private $creation = null;
    function __construct($creation) {
        parent::_construct('A1:D1');
        $this->creation = $creation;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View {
        return view('appointments.report', [
            'appointments' => Appointment::select('*')
                ->where('datetime', 'like', '%'.$this->creation.'%')
                ->get()
        ]);
    }
}
