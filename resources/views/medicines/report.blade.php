<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table class="table table-hover p-0 mb-0">
    <thead class="thead-light">
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">Caducidad</th>
          <th scope="col">C. barras</th>
          <th scope="col">Stock</th>
        </tr>
      </thead>
      <tbody>
        @foreach($medicines as $medicine)
        <tr>
          <th>{{$medicine->name}}</th>
          <td>{{$medicine->expiration}}</td>
          <td>{{$medicine->barcode}}</td>
          <td>{{$medicine->stock}}</td>
        </tr>
        @endforeach
      </tbody>
</table>
</html>