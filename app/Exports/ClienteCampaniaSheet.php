<?php

namespace App\Exports;

use App\Models\Campania;
use App\Models\Cliente;
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

class ClienteCampaniaSheet implements FromCollection,WithStyles, ShouldAutoSize, WithMapping, WithHeadings, WithTitle
{
    public function __construct(Request $request){
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $filters = FilterManager::getFilters($this->request, new Cliente());
        $filtersCampania = FilterManager::getFilters($this->request, new Campania());
        $consultas =  Cliente::where($filters)
        ->with('eventoCliente','campania','distrito')
        /*Cmbiar momentaneo*/
        //->where('idcampania','=',10)
        
        ->whereHas('campania', function ($query) use ($filtersCampania) {
            $query->where($filtersCampania);
        });

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
        ->orderBy('idcliente', 'DESC')
        ->get();
        //return Cliente::all();
    }

    /**
    * @var Invoice $invoice
    */
    public function map($model): array
    {        

        return [
            $model->idcliente,
            $model->nombres,
            $model->apellidos,
            $model->email,
            $model->telefono,
            $model->dni,            
            // $model->fecharegistro,
            $model->fecha,
            $model->asistencianame,
            $model->fechapresencia,
            // $model->coddistrito,            
            $model->carrera,
            $model->tipoparticipante,
            $model->edad,
            $model->grado,
            $model->colegio,
            $model->anioegreso,
            $model->procedencia,
            $model->utm,
            $model->campaign_content,
            $model->campaign_medium,
            $model->campaign_name,
            $model->campaign_source,
            $model->campaign_term,
            // $model->estado,
            $model->statename,
            $model->idcampania,
            $model->campania->nombrecampania,
            //$model->eventoCliente->evento['nombreevento'],
            $model->distrito->nombreubigeo,
        ];
        //return dd($model);
    }

    public function headings(): array
    {
        return [
            'Codigo',
            'Nombres',
            'Apellidos',
            'Email',
            'Telefono',
            'Dni',
            // 'fecharegistro',
            'Fecha Registro',
            'Asistencia',
            'Fecha Asistencia',
            // 'coddistrito',            
            'Carrera',            
            'Tipoparticipante',
            'Edad',
            'Grado',
            'Colegio',
            'Año de Egreso',
            //'uuidimportacion',
            'Procedencia',
            'Utm',
            'Campaign_content',
            'Campaign_medium',
            'Campaign_name',
            'Campaign_source',
            'Campaign_term',
            // 'estado',
            'Estado',
            'idcampania',
            'Campaña',
            //'Evento',
            'Distrito',
        ];
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

    public function title(): string
    {
        return "Campaña";
    }
}
