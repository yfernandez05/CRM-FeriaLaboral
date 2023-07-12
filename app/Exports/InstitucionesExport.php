<?php

namespace App\Exports;

use App\Models\Institucion;
use App\Models\Institucion as ModelsInstitucion;
use App\Util\FilterManager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InstitucionesExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{

    public function __construct(Request $request){
        $this->request = $request;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $filters = FilterManager::getFilters($this->request, new Institucion());
        $consultas =  Institucion::where($filters)
        ->with('user','ultimaatencion');

         //filtro de fechas input buscar por fechas
         if ($this->request->exists('fechadesde')) {
            $fechadesde = Carbon::createFromFormat('d-m-Y', $this->request->fechadesde)->toDateString();
            $consultas->whereDate('fecharegistro', '>=', $fechadesde); //pasamos como consulta el campo fecharegistro
        }
        if ($this->request->exists('fechahasta')) {
            $fechahasta = Carbon::createFromFormat('d-m-Y', $this->request->fechahasta)->toDateString();
            $consultas->whereDate('fecharegistro', '<=', $fechahasta); //pasasmos como consulta el campos fecharegistro
        } 
        
        return $consultas
        ->orderBy('idinstitucion', 'DESC')
        ->get();

    }

     //cabecera del excel la primera fila titulos
     public function headings(): array
     {
        return [
            'Nombre Encargado',
            'Apellido Encargado',
            'Nombre Institución',
            'Correo',
            'Celular',
            'Telefono',
            'Cargo',
            'Departamento',
            'Distrito',
            'Sede',
            'Dirección',
            'Pagina Web',
            'Tipo Institución',
            'Procedencia',
            'Contacto Alterno',
            'Correo Alterno',
            'Cargo Alterno',
            'Celular Alterno',
            'Telefono Alterno',
            'Confirmacion',
            'Asesor Asignado',
        ];
     }
 
     //cuerpo de contenido asigando a cada cabecera de la columna excel
     public function map($model): array
     {
        $confirmacion =' ' ;

        if(!empty($model->ultimaatencion->tipoatencion->tipoconfirmacion)){
            $confirmacion =  $model->ultimaatencion->tipoatencion->tipoconfirmacion; 
        }
        
          return [
             $model->nombresdirector,
             $model->apellidosdirector,
             $model->institucion,
             $model->email,
             $model->celular,
             $model->telefono,
             $model->cargo,
             $model->departamento,
             $model->distrito,            
             $model->sede,
             $model->direccion,
             $model->paginaweb,
             $model->tipoinstitucion,           
             $model->procedencia,           
             $model->contactoalterno,           
             $model->correoalterno,           
             $model->cargoalterno,           
             $model->celularalterno,           
             $model->telefonoalterno,
             $confirmacion,
             $model->user->name,
         ]; 
         //return dd($model);
     }   

     //darle stylo a las columnas o filas
    public function styles(Worksheet $sheet)
    {
        return [
            1    => [
                'font' => [
                    'bold' => true,                   
                ],          
            ],                
         ];
    }

    //dar un tamaño de espacio automatico a cada columna del excel
    public function AutoSize(): array
    {
        return [];
    }
 
}
