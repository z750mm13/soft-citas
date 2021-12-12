<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medicine;

use App\Exports\MedicineExport;
use Maatwebsite\Excel\Facades\Excel;

class MedicineController extends Controller {
    /**
     * Display a listing of the resource. Das medicine.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $medicines = Medicine::all();
        return view('medicines.index', compact('medicines'));
    }

    /**
     * Generate a file with listing of the resource. Das medicine.
     *
     * @return \Illuminate\Http\Response
     */
    public function report($type) {
        if($type=='excel')
        return Excel::download(new MedicineExport, 'Medicamentos.xlsx');
        else if ($type=='pdf')return Excel::download(new MedicineExport, 'Medicamentos.pdf',\Maatwebsite\Excel\Excel::DOMPDF);
        else abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        Medicine::create($request->all());
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
        Medicine::findOrFail($id)->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Medicine::findOrFail($id)->delete();
        return redirect()->back();
    }
}
