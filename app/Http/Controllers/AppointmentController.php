<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Appointment;
use App\User;
use App\Patient;
use App\Exports\AppointmentExport;
use Maatwebsite\Excel\Facades\Excel;

class AppointmentController extends Controller {

    function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        // Filtrer requests params
        $patient_id = $request->input('patient_id');
        $user_id = $request->input('user_id');
        $date = $request->input('date');
        // Filter requests chart
        $statisticDate = $request->input('statisticDate');
        $dateState = $request->input('dateState');
        $statisticYear = $request->input('statisticYear');
        if(!$statisticYear) $statisticYear = now()->format('Y');
        // Output chart data
        $data = array();
        if ($dateState == 'Dia') $data = $this->appointmentsDay($statisticDate);
        elseif ($dateState == 'Mes') $data = $this->appointmentsMounth($statisticDate);
        else $data = $this->appointmentsYear($statisticYear);

        $appointments = Appointment::select('*');
        if($patient_id)$appointments->where('patient_id', $patient_id);
        if($user_id)$appointments->where('user_id', $user_id);
        if($date)$appointments->where('datetime', 'like', $date.'%');
        $appointments=$appointments->orderByDesc('datetime')->get();

        $doctors = User::all()->where('rol', 'Encargado de la unidad');
        $patients = Patient::all();
        return view('appointments.index', compact('appointments','doctors','patients',
            'patient_id','user_id','date', 'statisticDate', 'dateState', 'statisticYear', 'data'
        ));
    }

    /**
     * Query to get report of days in array data format
     * @param  String
     * @return Array
     */
    private function appointmentsDay($selectedDay = null) {
        $data = array(3, 1, 2, 5, 2, 6, 3, 4);
        $appointments = Appointment::select(DB::raw('count(id)'))
        ->where('datetime', 'like', $selectedDay.'%');
        return $data;
    }

    /**
     * Query to get report of mounth in array data format
     * @param  String
     * @return Array
     */
    private function appointmentsMounth($selectedDay = null) {
        $data = array(3, 1, 2, 5, 2, 6, 3);
        $appointments = Appointment::select(DB::raw('count(id)'))
        ->where('datetime', 'like', $selectedDay.'%');
        return $data;
    }

    /**
     * Query to get report of mounth in array data format
     * @param  String
     * @return Array
     */
    private function appointmentsYear($statisticDate) {
        $data = array(3, 1, 2, 6, 3);
        $appointments = Appointment::select(DB::raw('count(id)'))
        ->where('datetime', 'like', $statisticDate.'%');
        return $data;
    }

    /**
     * Generate a file with listing of the resource. Das Appountment.
     *
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request, $type) {
        if($type=='excel')
        return Excel::download(
            new AppointmentExport($request->input('date'),$request->input('datatype')=='Semana'),
            'Citas '.$request->input('date').'.xlsx'
        );
        else if ($type=='pdf')return Excel::download(
            new AppointmentExport($request->input('date'),$request->input('datatype')=='Semana',true),
            'Citas '.$request->input('date').'.pdf',\Maatwebsite\Excel\Excel::MPDF
        );
        else abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        Appointment::create($request->all());
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        Appointment::findOrFail($id)->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Appointment::findOrFail($id)->delete();
        return redirect()->back();
    }
}
