<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table class="table table-hover p-0 mb-0">
    <tr>
        <th colspan="4" style="text-align:center;">Instituto Mexicano del Seguro Social</th>
        <th rowspan="3"></th>
    </tr>
    <tr>
        <th colspan="4" style="text-align:center;">Programa IMSS prospera</th>
    </tr>
    <tr>
        <th colspan="4" style="text-align:center;">UMR 119, San Juan Teponaxtla</th>
    </tr>
    <tr>
        <th colspan="5" style="text-align:center;"></th>
    </tr>
    <tr>
        <th colspan="5" style="text-align:center;"></th>
    </tr>
    <tr>
        <th colspan="5" style="text-align:center;"></th>
    </tr>
    <thead class="thead-light">
        <tr>
          <th scope="col">Asunto</th>
          <th scope="col">Paciente</th>
          <th scope="col">Medico</th>
          <th scope="col" colspan="2">Fecha/Hora</th>
        </tr>
      </thead>
      <tbody>
        @foreach($appointments as $appointment)
        <tr>
          <th>{{$appointment->type}}</th>
          <td>{{$appointment->patient->name.' '.$appointment->patient->lastname}}</td>
          <td>{{$appointment->user->name.' '.$appointment->user->lastname}}</td>
          <td  colspan="2">{{$appointment->datetime->format('d-m-Y g:i A')}}</td>
        </tr>
        @endforeach
      </tbody>
</table>
</html>