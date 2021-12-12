<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table class="table table-hover p-0 mb-0">
    <thead class="thead-light">
        <tr>
          <th scope="col">Asunto</th>
          <th scope="col">Paciente</th>
          <th scope="col">Medico</th>
          <th scope="col">Fecha/Hora</th>
        </tr>
      </thead>
      <tbody>
        @foreach($appointments as $appointment)
        <tr>
          <th>{{$appointment->type}}</th>
          <td>{{$appointment->patient->name.' '.$appointment->patient->lastname}}</td>
          <td>{{$appointment->user->name.' '.$appointment->user->lastname}}</td>
          <td>{{$appointment->datetime->format('d-m-Y H:i')}}</td>
        </tr>
        @endforeach
      </tbody>
</table>
</html>