<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
    <tr>
        <th><img src="{{ asset('resources/img/Salud.jpg') }}" alt="Salud" width="153" height="83"></th>
        <th colspan="2" style="text-align:center;">San Juan Teponaxtla</th>
        <th><img src="{{ asset('resources/img/imss.png') }}" alt="Salud" width="83" height="83"></th>
    </tr>
    <tr>
        <th colspan="4" style="text-align:center;">Unidad rural</th>
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