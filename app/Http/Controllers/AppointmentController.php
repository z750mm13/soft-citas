<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\User;
use App\Patient;
use App\Exports\AppointmentExport;
use Maatwebsite\Excel\Facades\Excel;

class AppointmentController extends Controller {
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $patient_id = $request->input('patient_id');
        $user_id = $request->input('user_id');
        $date = $request->input('date');

        $appointments = Appointment::select('*');
        if($patient_id)$appointments->where('patient_id', $patient_id);
        if($user_id)$appointments->where('user_id', $user_id);
        if($date)$appointments->where('datetime', 'like', $date.'%');
        $appointments=$appointments->get();

        $doctors = User::all();
        $patients = Patient::all();
        return view('appointments.index', compact('appointments','doctors','patients', 'patient_id','user_id','date'));
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
            'Medicamentos '.$request->input('date').'.xlsx'
        );
        else if ($type=='pdf')return Excel::download(
            new AppointmentExport($request->input('date'),$request->input('datatype')=='Semana'),
            'Medicamentos '.$request->input('date').'.pdf',\Maatwebsite\Excel\Excel::MPDF
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
