<?php

namespace App\Exports;

use App\Consultation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class ConsultationExport  extends BaseExport implements FromView  {
    private $creation = null;
    private $week = null;
    function __construct($creation, $week) {
        parent::_construct('A1:D1');
        $this->creation = $creation;
        $this->week = $week;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View {
        if(!$this->week)
        return view('consultations.report', [
            'consultations' => Consultation::select('*')
                ->where('created_at', 'like', '%'.$this->creation.'%')
                ->get()
        ]);
        $from = Carbon::parse($this->creation);
        $to = Carbon::parse($this->creation)->addDays(6);
        return view('consultations.report', [
            'consultations' => Consultation::select('*')
                ->whereBetween('created_at', [$from, $to])
                ->get()
        ]);
    }
}
