<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
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
        <th colspan="4" style="text-align:center;"></th>
    </tr>
    <tr>
        <th colspan="4" style="text-align:center;"></th>
    </tr>
    <thead>
        <tr>
          <th scope="col">Asunto</th>
          <th scope="col">Paciente</th>
          <th scope="col">Medico</th>
          <th scope="col">Fecha/Hora</th>
        </tr>
      </thead>
      <tbody>
        @foreach($consultations as $consultation)
        <tr>
          <th>{{$consultation->appointment->type}}</th>
          <td>{{$consultation->appointment->patient->name.' '.$consultation->appointment->patient->lastname}}</td>
          <td>{{$consultation->appointment->user->name.' '.$consultation->appointment->user->lastname}}</td>
          <td>{{$consultation->created_at->format('d-m-Y H:i')}}</td>
        </tr>
        @endforeach
      </tbody>
</table>
</html>