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
            <th></th>
        </tr>
        <tr>
            <th colspan="2"><b><h4>Médico</h4></b></th>
            <th colspan="2" style="text-align:right;"><b><h4>Paciente</h4></b></th>
        </tr>
        <tr>
            <th colspan="2">
                <p>{{$consultation->appointment->user->name. ' ' .$consultation->appointment->user->lastname}}</p>
            </th>
            <th colspan="2" style="text-align:right;">
                <p>{{$consultation->appointment->patient->name. ' ' .$consultation->appointment->patient->lastname}}</p>
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
            <?php $line = 0; ?>
            @foreach($consultation->prescriptions as $prescription)
            <tr>
                <th colspan="4"><b>{{$prescription->medicine->name??null}}</b>:</th>
                <?php $line++; ?>
            </tr>
            @if($prescription->dose || $prescription->description || $prescription->medicine->details )
            <tr>
                <th>{{$prescription->dose}}{{$prescription->description?', '.$prescription->description:''}}{{$prescription->medicine->details??null?', '.$prescription->medicine->details??null:''}}.</th>
                <?php $line++; ?>
            </tr>
            @endif
            @endforeach
            <tr>
                <th colspan="4" style="text-align:right;">___________________________</th>
            </tr>
            <tr>
                <th colspan="4" style="text-align:right;">FIRMA DEL MEDICO</th>
            </tr>
        </tbody>
    </table>
</html>