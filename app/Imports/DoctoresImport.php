<?php

namespace App\Imports;

use App\Models\Doctor;
use App\Models\Evento;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DoctoresImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public $data;
    public $key;
    public function startRow(): int
    {
        return 2; // Empezamos a leer a partir de la fila 2 (después de las dos filas de cabecera)
    }
    public function collection(Collection $collection)
    {
        set_time_limit(3600);
        $nombreevento = "Carga subida por excel";
        $contadorexist = 0;
        $contadornoexist = 0;
        $contador = 0;
        foreach ($collection as $key => $value) {
            $doctorexist = Doctor::where('tipo_documento','CMP')->where('nro_documento',$value[3])->first();
            if(!$doctorexist){
                $cmp = $value[3];
                $datos = Doctor::ScrappingDoctor($cmp);
                if(isset($datos[1])){
                    $doctorconsultado = $datos[1];
                    $doctor = new Doctor();
                    $doctor->cmp = (int)$doctorconsultado[1];
                    $doctor->apepaterno = $doctorconsultado[2];
                    $doctor->apematerno = $doctorconsultado[3];
                    $doctor->nombre = $doctorconsultado[4];
                    $doctor->telefono = $value[4]?$value[4]:'0'; 
                    $doctor->fechanacimiento = date('Y-m-d');
                    $doctor->observaciones = $value[8]; 
                    $doctor->distrito = $value[11]; 
                    $doctor->centrosalud = $value[12]?$value[12]:'No tiene centro de salud'; 
                    $evento = Evento::where('nombre',$nombreevento)->first();
                    if(!$evento){
                        $evento = new Evento();
                        $evento->nombre = $nombreevento;
                        $evento->descripción = "La carga se subió desde un archivo excel";
                        $evento->save();
                    }
                    $doctor->evento_id = $evento->id;
                    $doctor->save();
                    ++$contador;
                }else{
                    ++$contadornoexist;
                }
            }
            else{
                ++$contadorexist;
            }
        }
        $this->data = "Doctores registrados: ".$contador." Existentes: ".$contadorexist."  No Existentes: ".$contadornoexist;
        $this->key = 'success';
    }
}
