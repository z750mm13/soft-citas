<?php

namespace App\Exports;

use App\Appointment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class AppointmentExport extends BaseExport implements FromView {
    private $creation = null;
    private $week = null;
    function __construct($creation, $week, $pdf = false) {
        parent::_construct('A1:D1',[
            [
                'name' => 'A',
                'value' => 17
            ],[
                'name' => 'B',
                'value' => 18
            ],[
                'name' => 'C',
                'value' => 18
            ],[
                'name' => 'D',
                'value' => 17.5
            ],
        ], $pdf);
        $this->creation = $creation;
        $this->week = $week;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View {
        if(!$this->week)
        return view('appointments.report', [
            'appointments' => Appointment::select('*')
                ->where('datetime', 'like', '%'.$this->creation.'%')
                ->get()
        ]);
        $from = Carbon::parse($this->creation);
        $to = Carbon::parse($this->creation)->addDays(6);
        return view('appointments.report', [
            'appointments' => Appointment::select('*')
                ->whereBetween('datetime', [$from, $to])
                ->get()
        ]);
    }
}
