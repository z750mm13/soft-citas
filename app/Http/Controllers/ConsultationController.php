<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Consultation;
use App\Appointment;
use App\Medicine;
use App\Prescription;
use Illuminate\Support\Facades\Hash;
use App\Exports\ConsultationExport;
use App\Exports\PrescriptionExport;
use Maatwebsite\Excel\Facades\Excel;

class ConsultationController extends Controller {

    function __construct() {
        $this->middleware('auth');
        $this->middleware('role')->only(['create', 'store']);
    }
    /**
     * Display a listing of the resource. Das consultation.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        // Filter requests chart
        $statisticDate = $request->input('statisticDate');
        $dateState = $request->input('dateState');
        $statisticYear = $request->input('statisticYear');
        if(!$statisticYear) {
            $statisticYear = now()->format('Y');
            if (!$statisticDate) $dateState = null;
        }
        // Output chart data
        $data = array();
        if ($dateState == 'Dia') $data = $this->consultationsDay($statisticDate);
        elseif ($dateState == 'Mes') $data = $this->consultationsMounth($statisticDate);
        else $data = $this->consultationsYear($statisticYear);

        $consultations = Consultation::all();
        return view('consultations.index', compact(
            'consultations', 'statisticDate', 'dateState', 'statisticYear', 'data'
        ));
    }

    /**
     * Query to get report of days in array data format
     * @param  String
     * @return Array
     */
    private function consultationsDay($selectedDay = null) {
        $consultations = null;
        for ($starhour = 0; $starhour < 24; $starhour += 3) {
            $nextAppointment = Consultation::select(DB::raw('count(id), '.$starhour.' as hour'))
            ->where([
                ['created_at', '>=', $selectedDay. ' ' .$starhour. ':00:00'],
                ['created_at', '<',  $selectedDay. ' ' .($starhour + 3). ':00:00']
            ]);
            if ($starhour) $consultations = $nextAppointment->union($consultations);
            else $consultations = $nextAppointment;
        }
        $consultations = $consultations->orderBy('hour')->get();
        return $consultations->pluck('count');
    }

    /**
     * Query to get report of mounth in array data format
     * @param  String
     * @return Array
     */
    private function consultationsMounth($selectedDay = null) {
        $consultations = null;
        foreach (range(0, 6) as $numberDay) {
            $nextAppointment = Consultation::select(DB::raw('count(id), '.$numberDay.' as day'))
            ->where(DB::raw("date_part('dow',created_at) = " .$numberDay. "and null"));
            if ($numberDay) $consultations = $nextAppointment->union($consultations);
            else $consultations = $nextAppointment;
        }
        $consultations = $consultations->orderBy('day')->get();
        return $consultations->pluck('count');
    }

    /**
     * Query to get report of mounth in array data format
     * @param  String
     * @return Array
     */
    private function consultationsYear($yearSelected) {// cuartos para gente sola
        $consultations = null;
        foreach (range($yearSelected-2, $yearSelected+2) as $index => $numberYear) {
            $nextAppointment = Consultation::select(DB::raw('count(id), '.$numberYear.' as year'))
            ->where('created_at','like', $numberYear.'%');
            if ($index) $consultations = $nextAppointment->union($consultations);
            else $consultations = $nextAppointment;
        }
        $consultations = $consultations->orderBy('year')->get();
        return $consultations->pluck('count');
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
            new ConsultationExport($request->input('date'),$request->input('datatype')=='Semana',true),
            'Consultas '.$request->input('date').'.pdf',\Maatwebsite\Excel\Excel::MPDF
        );
        else abort(404);
    }

    /**
     * Generate a file with listing of the resource. Das Appountment.
     *
     * @return \Illuminate\Http\Response
     */
    public function prescriptionReport($consultation_id) {
        return Excel::download(
            new PrescriptionExport($consultation_id),
            'Receta '.$consultation_id.'.pdf',\Maatwebsite\Excel\Excel::MPDF
        );
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
