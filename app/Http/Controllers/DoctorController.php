<?php

namespace App\Http\Controllers;

use App\Exports\DoctoresExport;
use App\Imports\DoctoresImport;
use App\Models\Doctor;
use App\Models\Evento;
use GuzzleHttp\Client;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\DomCrawler\Crawler;

class DoctorController extends Controller
{
    public function index(Request $request){
        $datos = "";
        return view('index',compact('datos'));
    }
    public function lista(Request $request){
        $doctores = Doctor::orderBy('updated_at','desc')->get();
        return view('doctor.index',compact('doctores'));
    }
    public function show(Request $request)
    {
        $request->validate([
            'cmp' => 'required|numeric',
        ]);

        $cmp = $request->input('cmp');

        // Realizar una solicitud POST al formulario del CMP
        $datos = Doctor::ScrappingDoctor($cmp);
        $doctor = Doctor::where('nro_documento',(int)$cmp)->first();
        if(isset($datos[1])){
            $datos = $datos[1];
            $especialidad = isset($datos['tabla_interna'][7])?$datos['tabla_interna'][7][0]:'';
            array_push($datos['cols'],$especialidad);
            $datos = $datos['cols'];
        }
        else{
            $datos = '';
        }
        $distritos = ["CALLAO", "BELLAVISTA","CARMEN DE LA LEGUA REYNOSO","LA PERLA","LA PUNTA","VENTANILLA", "MI PERU","LIMA","ANCON","ATE","BARRANCO","BREÑA","CARABAYLLO","CHACLACAYO","CHORRILLOS","CIENEGUILLA","COMAS","EL AGUSTINO","INDEPENDENCIA","JESUS MARIA","LA MOLINA","LA VICTORIA","LINCE","LOS OLIVOS", "LURIGANCHO","LURIN", "MAGDALENA DEL MAR","PUEBLO LIBRE","MIRAFLORES","PACHACAMAC","PUCUSANA","PUENTE PIEDRA","PUNTA HERMOSA","PUNTA NEGRA","RIMAC","SAN BARTOLO","SAN BORJA","SAN ISIDRO","SAN JUAN DE LURIGANCHO","SAN JUAN DE MIRAFLORES","SAN LUIS", "SAN MARTIN DE PORRES","SAN MIGUEL","SANTA ANITA","SANTA MARIA DEL MAR","SANTA ROSA","SANTIAGO DE SURCO","SURQUILLO","VILLA EL SALVADOR","VILLA MARIA DEL TRIUNFO"];

        return view('index', compact('datos','doctor','distritos'));
    }
    public function store(Request $request){
        
        $request->validate([
            'cmp' => 'required|unique:doctores,nro_documento|max:255',
            'telefono' => 'required|numeric',
            'fechanacimiento' => 'required',
            'centrosalud' => 'required',
        ]);
        $cmp =  (int) $request->cmp;
        $doctor = Doctor::where('nro_documento',$cmp)->first();
        if(!isset($doctor)){
            $doctor = new Doctor();
            $doctor->tipo_documento = 'CMP';
            $doctor->nro_documento = $cmp;
            $doctor->evento_id = $request->evento;
        }
        $doctor->nombre = $request->nombre;
        $doctor->apepaterno = $request->apepaterno;
        $doctor->apematerno = $request->apematerno;
        $doctor->telefono = $request->telefono;
        $doctor->fechanacimiento = $request->fechanacimiento;
        $doctor->centrosalud = $request->centrosalud;
        $doctor->provincia = $request->provincia;
        $doctor->distrito = $request->distrito?$request->distrito:$request->distrito2;
        $doctor->observaciones = $request->observaciones;
        $doctor->especialidad = $request->especialidad;
        $doctor->save();
        return redirect()->route('doctor.index',['evento'=>$request->evento])->with('success','Doctor Registrado Exitosamente');
    }
    public function guardarotros(Request $request){
        $doctor = new Doctor();
        $doctor->tipo_documento = $request->tipo_documento;
        $doctor->nro_documento = $request->nro_documento;
        $doctor->nombre = $request->nombre;
        $doctor->apepaterno = $request->apepaterno;
        $doctor->apematerno = $request->apematerno;
        $doctor->telefono = $request->telefono;
        $doctor->fechanacimiento = $request->fechanacimiento;
        $doctor->centrosalud = $request->centrosalud;
        $doctor->provincia = $request->provincia;
        $doctor->distrito = $request->distrito;
        $doctor->observaciones = $request->observaciones;
        $doctor->evento_id = $request->evento;
        $doctor->save();
        return redirect()->route('doctor.index')->with('success','Persona Registrada Exitosamente');
    }
    public function cargamasiva(Request $request){
        $request->validate([
            'doctores' => 'required|mimes:xlsx,xls',
        ]);
        $file = $request->file('doctores');
        $doctoresImport = new DoctoresImport;
        $excel = Excel::import($doctoresImport, $file);
        return back()->with($doctoresImport->key, $doctoresImport->data);

    }
    public function update(Request $request, $id){
        $evento = Evento::find($id);
        $evento->nombre = $request->nombre;
        $evento->descripción = $request->descripción;
        $evento->save();

        return redirect()->route('evento.index')->with('success','evento modificado exitosamente');
    }
    public function export()
{
    return Excel::download(new DoctoresExport, 'medicos.xlsx');
}
}
