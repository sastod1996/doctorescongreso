<!DOCTYPE html>
<html lang="es">
    <head>
    <title>Dashboard - Grobdi</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <div class="container">
            <h2>Doctores</h2>
            <div class="mb-3">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-primary btn-sm" href="{{ route('dashboard.index')}}"><i class="fa fa-arrow-left"></i> Atrás</a>
                </div>
            </div>
            <div class="mb-3">
                <input class="form-control" onkeyup="searchTable()" type="text" placeholder="buscar..." id="myInput">
            </div>
            <div class="mb-3 d-md-flex justify-content-md-end">
                <a class="btn btn-success" href="{{ route('doctor.export') }}">Descargar Excel</a>
            </div>
            <div class="table table-responsive" id="myTable">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Tipo de documento</th>
                        <th scope="col">Nro de documento</th>
                        <th scope="col">Nombre y apellidos</th>
                        <th scope="col">especialidad</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">centro de salud</th>
                        <th scope="col">Provincia</th>
                        <th scope="col">Distrito</th>
                        <th scope="col">Observaciones</th>
                        <th scope="col">Evento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($doctores as $doctor)
                        <tr>
                            <td>{{ $doctor->tipo_documento }}</td>
                            <td>{{ $doctor->nro_documento }}</td>
                            <td>{{$doctor->nombre}} {{$doctor->apepaterno}} {{$doctor->apematerno}}</td>
                            <td>{{$doctor->especialidad}}</td>
                            <td>{{$doctor->telefono}}</td>
                            <td>{{$doctor->centrosalud}}</td>
                            <td>{{$doctor->provincia}}</td>
                            <td>{{$doctor->distrito}}</td>
                            <td>{{$doctor->observaciones}}</td>
                            <td>{{$doctor->evento->nombre}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
<script>
    function searchTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById('myInput');
        filter = input.value.toUpperCase();
        table = document.getElementById('myTable');
        tr = table.getElementsByTagName('tr');

        // Iterar sobre las filas de la tabla
        for (i = 1; i < tr.length; i++) { // Empieza en 1 para no incluir el encabezado
            td = tr[i].getElementsByTagName('td');
            let found = false;
            
            // Iterar sobre las celdas de cada fila
            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                    }
                }
            }
            
            // Si alguna celda de la fila contiene el texto, mostrarla, sino ocultarla
            tr[i].style.display = found ? "" : "none";
        }
    }
</script>