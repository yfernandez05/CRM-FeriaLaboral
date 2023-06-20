<?php

namespace App\Exports;

use App\Models\Evento;
use App\Models\EventoCliente;
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

class ClienteEventoSheet implements FromCollection,WithStyles, ShouldAutoSize, WithMapping, WithHeadings, WithTitle
{
    public function __construct(Request $request){
        $this->request = $request;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        /* $filtersEvento = FilterManager::getFilters($this->request, new Evento());
        $consultas =  EventoCliente::where('idevento', $this->request->idevento)
            ->with('evento') */
            //agregamos filtro adicionales
             /* ->whereHas('evento', function ($query) use ($filtersEvento) {
                $query->where($filtersEvento);
            }) */
        
        
        /* ->orderBy('ideventocliente', 'DESC')
        ->get();
        return $consultas; */
        //dd($consultas);
        if($this->request->idevento){
            $consulta = EventoCliente::where('idevento','=', $this->request->idevento)
            ->with('evento')            
            ->get();
        }
        else{
        $filters = FilterManager::getFilters($this->request, new EventoCliente());
        //agregamos el modelo EVENTO adicionales en cliente + evento, hace el filtro de busqueda en Cliente + Evento 
        $filtersEvento = FilterManager::getFilters($this->request, new Evento());

        $querycliente = EventoCliente::where($filters)
            ->with('evento','distrito')
             ->whereHas('evento', function ($query) use ($filtersEvento) {
                $query->where($filtersEvento);
            });
            

            $consulta = $querycliente->orderBy('ideventocliente', 'DESC')->get();

        }


        return $consulta;
    }

    public function map($model): array
    {        

        return [
            $model->idcliente,
            $model->evento->campania->idcampania,
            $model->evento->campania->nombrecampania,
            $model->idevento,
            $model->evento->nombreevento,
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
            //$model->idcampania,
            //$model->campania->nombrecampania,
            //$model->eventoCliente->evento['nombreevento'],
            //$model->distrito->nombreubigeo,
        ];
        return dd($model);
    }

    public function headings(): array
    {
        return [
            'Codigo',
            'cod Campaña',
            'Campaña',
            'cod Evento',
            'Evento',
            'Nombres',
            'Apellidos',
            'Email',
            'Telefono',
            'Dni',
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
            //'idcampania',            
            //'Evento',
            //'Distrito',
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
        return "Eventos";
    }
}
