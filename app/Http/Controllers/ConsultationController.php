<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consultation;
use App\Appointment;
use App\Medicine;
use App\Prescription;
use Illuminate\Support\Facades\Hash;
use App\Exports\ConsultationExport;
use Maatwebsite\Excel\Facades\Excel;

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
     * Generate a file with listing of the resource. Das Appountment.
     *
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request, $type) {
        if($type=='excel')
        return Excel::download(
            new ConsultationExport($request->input('date'),$request->input('datatype')=='Semana'),
            'Consultas '.$request->input('date').'.xlsx'
        );
        else if ($type=='pdf')return Excel::download(
            new ConsultationExport($request->input('date'),$request->input('datatype')=='Semana'),
            'Consultas '.$request->input('date').'.pdf',\Maatwebsite\Excel\Excel::MPDF
        );
        else abort(404);
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
                $medicine = Medicine::findOrFail($medicamentos[$i]);
                $medicine->stock = $medicine->stock - 1;
                $medicine->save();
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
    public function edit(Request $request, $id) {
        if(!Hash::check($request->get('password'), \App\User::findOrFail(1)->password))
        return redirect()->route('consultations.index')->with('error','Contraseña incorrecta');
        $consultation = Consultation::findOrFail($id);
        $medicines = Medicine::all();
        return view('consultations.edit', compact('consultation', 'medicines'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $data = $request->all();
        $consultation = Consultation::findOrFail($id);
        $consultation->update($data);

        foreach($data['ids'] as $i => $id){
            if(!$id) { //Nuevo medicamento
                if($data['medicamentos'][$i]) Prescription::create([
                    "dose" => $data['dosis'][$i],
                    "description" => $data['indicaciones'][$i],
                    "consultation_id" => $consultation->id,
                    "medicine_id" => $data['medicamentos'][$i]
                ]);
            } else if(!$data['medicamentos'][$i] || $data['medicamentos'][$i]=="null") //Eliminacion de medicamento
            Prescription::findOrFail($id)->delete();
            else Prescription::findOrFail($id)->update([ //Edicion de medicamento
                "dose" => $data['dosis'][$i],
                "description" => $data['indicaciones'][$i],
                "consultation_id" => $consultation->id,
                "medicine_id" => $data['medicamentos'][$i]
            ]);
        }
        Prescription::whereNotIn('id', $data['ids'])->delete();

        return redirect()->route('consultations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        if(!Hash::check($request->get('password'), \App\User::findOrFail(1)->password))
            return redirect()->back()->with('error','Contraseña incorrecta');
        $consultation=Consultation::findOrFail($id);
        foreach ($consultation->prescriptions as $presescription) {
            $presescription->delete();
        }
        $consultation->delete();
        return redirect()->route('consultations.index');
    }
}
