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
            <div class="row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('doctor.index') }}">
                                <h5 class="card-title">Eventos</h5>
                                <select name="evento" class="form-select">
                                    <option disabled>Ingresar a Evento</option>
                                    @foreach ($eventos as $evento)
                                        <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                                    @endforeach
                                </select>
                                <br>
                                <button type="input" class="btn btn-primary">Entrar</button>
                                <a href="{{ route('evento.index') }}">crear nuevo evento</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('doctor.cargamasiva') }}" enctype="multipart/form-data">
                                @csrf
                                <h5 class="card-title">Cargar Doctores</h5>
                                <input class="form-control" type="file" name="doctores" accept=".xlsx, .csv" disabled>
                                @foreach ($errors->all() as $error)
                                    <p style="color: red;">{{ $error }}</p>
                                @endforeach
                                <br>
                                <button type="input" class="btn btn-primary" disabled>Cargar</button>
                                <a href="{{ route('doctor.lista') }}">Ver Doctores</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>