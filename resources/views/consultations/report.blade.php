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