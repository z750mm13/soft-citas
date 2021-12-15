<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <table class="table table-hover p-0 mb-0">
        <tr>
            <th colspan="3" style="text-align:center;">Instituto Mexicano del Seguro Social</th>
            <th rowspan="3"></th>
        </tr>
        <tr>
            <th colspan="3" style="text-align:center;">Programa IMSS prospera</th>
        </tr>
        <tr>
            <th colspan="3" style="text-align:center;">UMR 119, San Juan Teponaxtla</th>
        </tr>
        <tr>
            <th colspan="3" style="text-align:center;"></th>
        </tr>
        <tr>
            <th colspan="4" style="text-align:right;">{{$consultation->created_at->format('d/m/Y')}}</th>
        </tr>
        <tr>
            <th colspan="4">
                <h5 class="card-title mt-1">Medico</h5>
                <p class="card-text">{{$consultation->appointment->user->name. ' ' .$consultation->appointment->user->lastname}}</p>
            </th>
        </tr>
        <tr>
            <th colspan="4">
                <h5 class="card-title mt-1" style="text-align:right;">Paciente</h5>
                <p class="card-text">{{$consultation->appointment->patient->name. ' ' .$consultation->appointment->patient->lastname}}</p>
            </th>
        </tr>
        <tr>
            <th colspan="4"></th>
        </tr>
        <tr>
            <th colspan="4">{{$consultation->description}}</th>
        </tr>
        <tr>
            <th colspan="4"></th>
        </tr>
        <tbody>
            @foreach($consultation->prescriptions as $prescription)
            <tr>
                <th colspan="4">{{$prescription->medicine->name}}: {{$prescription->dose}}{{$prescription->description?', '.$prescription->description:''}}.</th>
            </tr>
            @endforeach
        </tbody>
    </table>
</html>