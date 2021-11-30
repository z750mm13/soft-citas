<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\User;
use App\Patient;

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
