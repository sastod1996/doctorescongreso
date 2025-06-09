<!DOCTYPE html>
<html lang="es">
    <head>
    <title>Grobdi - doctores</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>

    <div class="container">
        <h2>Buscador de CMP</h2>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('dashboard.index')}}"><i class="fa fa-arrow-left"></i> Atrás</a>
        </div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('doctor.show') }}">
            <div class="mb-3">
                <label for="cmp">CMP Doctor:</label>
                <input type="text" class="form-control" id="cmp" placeholder="Buscar CMP del doctor" name="cmp">
                <input type="hidden" name="evento" value="{{ request()->get('evento') }}">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
            <button class="btn btn-link" type="button" id="mostrarFormulario">Registrar otra persona</button>
        </form>
        <br>
        @if(is_array($datos))
            <form action="{{ route('doctor.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <small>Doctor registrado de: <span class="badge bg-success">{{ isset($doctor->evento->nombre)?$doctor->evento->nombre:'' }}</span></small>
                </div>
                <div class="mb-3 row">
                    <label for="cmp" class="col-sm-2 col-form-label">CMP</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="cmp" name="cmp"  aria-describedby="emailHelp" value="{{ $datos[1] }}" tabindex="-1" readonly >
                        <input type="hidden" name="evento" value="{{ request()->get('evento') }}">
                    </div>
                    <label for="name" class="col-sm-2 col-form-label">Nonbres</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="name" name="nombre" value="{{ $datos[4] }}" tabindex="-1" readonly>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="apepaterno" class="col-sm-2 col-form-label">Apellido Paterno</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="apepaterno" name="apepaterno" value="{{ $datos[2] }}" tabindex="-1" readonly>
                    </div>
                    <label for="apematerno" class="col-sm-2 col-form-label">Apellido Materno</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="apematerno" name="apematerno" value="{{ $datos[3] }}" tabindex="-1" readonly>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="telefono" class="col-sm-2 col-form-label">Telefono</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ isset($doctor->telefono)?$doctor->telefono:'' }}" placeholder="Ingresar el numero de telefono">
                        @error('telefono')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <label for="fechanacimiento" class="col-sm-2 col-form-label">Fecha Nacimiento</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control @error('fechanacimiento') is-invalid @enderror" id="fechanacimiento" name="fechanacimiento" value="{{ isset($doctor->fechanacimiento)?$doctor->fechanacimiento:'' }}">
                        @error('fechanacimiento')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="centrosalud" class="col-sm-2 col-form-label">Centro de Salud</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('centrosalud') is-invalid @enderror" id="centrosalud" name="centrosalud" value="{{ isset($doctor->centrosalud)?$doctor->centrosalud:'' }}" placeholder="Ingresar el centro de salud donde labora">
                        @foreach ($errors->get('centrosalud') as $error)
                            <div class="form-text text-danger">{{ $error }}</div>
                        @endforeach
                    </div>
                    <div class="col-sm-2">
                        <select class="form-select" id="selectLugar" name="provincia">
                            <option value="">Seleccione provincia</option>
                            <option value="LIMA" {{ isset($doctor->provincia)&&$doctor->provincia==='LIMA'?'selected':'' }}>Lima</option>
                            <option value="PROVINCIA" {{ isset($doctor->provincia)&&$doctor->provincia==='PROVINCIA'?'selected':'' }}>Provincia</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-select" name="distrito" id="comboInput"  style="display: none;">
                            <option value="" selected>Seleccione Distrito</option>
                            @foreach ($distritos as $distrito )
                                <option value="{{ $distrito }}" {{ isset($doctor->distrito)&&$doctor->distrito==$distrito?'selected':'' }}>{{ $distrito }}</option>
                            @endforeach
                        </select>
                        <input class="form-control" name="distrito2" value="{{ isset($doctor->distrito)?$doctor->distrito:'' }}" id="textInput" style="display: none;">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="observaciones" class="col-sm-2 col-form-label">observaciones</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="observaciones" name="observaciones">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="especilidad" class="col-sm-2 col-form-label">Especialidad</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="especialidad" name="especialidad" value="{{ isset($doctor->especialidad)?$doctor->especialidad:$datos[5] }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        @elseif(isset($error))
            <p style="color:red">{{ $error }}</p>
        @endif
        <br>
        <div id="formularioRegistro" style="display: none;">
            <h4>Formulario de otra Persona</h4>
            <form action="{{ route('doctor.guardarotros') }}" method="post">
                @csrf
                <div class="mb-3 row">
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="tipo_documento" name="tipo_documento"  aria-describedby="emailHelp" value="" placeholder="Tipo de documento" required>
                        <input type="hidden" name="evento" value="{{ request()->get('evento') }}">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="nro_documento" name="nro_documento"  aria-describedby="emailHelp" value="" placeholder="Ingresar Nro de documento" required>
                    </div>
                    <label for="name" class="col-sm-2 col-form-label">Nonbres</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" name="nombre" >
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="apepaterno" class="col-sm-2 col-form-label">Apellido Paterno</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="apepaterno" name="apepaterno" >
                    </div>
                    <label for="apematerno" class="col-sm-2 col-form-label">Apellido Materno</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="apematerno" name="apematerno">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="telefono" class="col-sm-2 col-form-label">Telefono</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="telefono" name="telefono" pattern="^9\d{8}$">
                    </div>
                    <label for="fechanacimiento" class="col-sm-2 col-form-label">Fecha Nacimiento</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento">
                    </div>
                    @error('fechanacimiento')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 row">
                    <label for="centrosalud" class="col-sm-2 col-form-label">Centro de Salud</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="centrosalud" name="centrosalud">
                    </div>
                    @foreach ($errors->get('centrosalud') as $error)
                        <div class="form-text text-danger">{{ $error }}</div>
                    @endforeach
                    <div class="col-sm-2">
                        <select class="form-select" id="selectLugar" name="provincia">
                            <option value="">Seleccione provincia</option>
                            <option value="LIMA">Lima</option>
                            <option value="PROVINCIA">Provincia</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <input class="form-control" name="distrito" id="textInput" placeholder="Ingresar distrito...">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="observaciones" class="col-sm-2 col-form-label">observaciones</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="observaciones" name="observaciones">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>

    </body>
</html>
<script>
    function actualizarCampos() {
        const comboDiv = document.getElementById('comboInput');
        const textDiv = document.getElementById('textInput');
        const selector = document.getElementById('selectLugar');
        const value = selector.value;

        if (value === 'LIMA') {
            comboDiv.style.display = 'block';
            textDiv.style.display = 'none';
        } else if (value === 'PROVINCIA') {
            comboDiv.style.display = 'none';
            textDiv.style.display = 'block';
        } else {
            comboDiv.style.display = 'none';
            textDiv.style.display = 'none';
        }
    }
    document.getElementById('selectLugar').addEventListener('change', actualizarCampos);
    document.getElementById('mostrarFormulario').addEventListener('click', function () {
        const formDiv = document.getElementById('formularioRegistro');
        formDiv.style.display = 'block';
    });
    // Ejecutar al cargar la página
    window.addEventListener('DOMContentLoaded', actualizarCampos);
</script>