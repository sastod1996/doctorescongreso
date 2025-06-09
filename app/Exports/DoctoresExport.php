<?php

namespace App\Exports;

use App\Models\Doctor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DoctoresExport implements FromCollection, WithHeadings, WithMapping

{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Doctor::with('evento')->get();
    }

    /**
     * Definir las cabeceras de la exportación (opcional)
     *
     * @return array
     */
    public function headings(): array
    {
        return ['Tipo de documento', 'Nro de documento', 'Nombre', 'Apellido Paterno', 'Apellido Materno','Telefono','Centro de salud','Provincia','Distrito','observaciones','Evento'];
    }
        /**
     * Mapeo de los datos de cada fila
     * 
     * @param  Doctor  $doctor
     * @return array
     */
    public function map($doctor): array
    {
        return [
            $doctor->tipo_documento,
            $doctor->nro_documento,
            $doctor->nombre,
            $doctor->apepaterno, 
            $doctor->apematerno,
            $doctor->telefono,
            $doctor->centrosalud,
            $doctor->provincia,
            $doctor->distrito,
            $doctor->observaciones,
            $doctor->evento->nombre,
        ];
    }
}
