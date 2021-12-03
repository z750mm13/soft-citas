<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consultation;
use App\Appointment;
use App\Medicine;
use App\Prescription;
use Illuminate\Support\Facades\Hash;

class ConsultationController extends Controller {
    /**
     * Display a listing of the resource. Das consultation.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $consultations = Consultation::all();
        return view('consultations.index', compact('consultations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($appointment_id = null) {
        $appointment = Appointment::findOrFail($appointment_id);
        $medicines = Medicine::all();
        return view('consultations.create', compact('appointment_id','appointment','medicines'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $medicamentos = $request->get('medicamentos');
        $dosis = $request->get('dosis');
        $indicaciones = $request->get('indicaciones');

        $consultation = Consultation::create($request->all());
        for ($i = 0; $i < count($medicamentos); $i++) {
            if($medicamentos[$i] != "null") {
                Prescription::create([
                    "dose" => $dosis[$i],
                    "description" => $indicaciones[$i],
                    "consultation_id" => $consultation->id,
                    "medicine_id" => $medicamentos[$i]
                ]);
            }
        }
        return redirect()->route('consultations.show',compact('consultation'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $consultation = Consultation::findOrFail($id);
        return view('consultations.show', compact('consultation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //dd(Hash::check('holamundo', \App\User::findOrFail(1)->password));
        $consultation = Consultation::findOrFail($id);
        return view('consultations.edit', compact('consultation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        Consultation::findOrFail($id)->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Consultation::findOrFail($id)->delete();
        return redirect()->route('consultations.index');
    }
}
