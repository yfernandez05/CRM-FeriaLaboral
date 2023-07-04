<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Cliente;
use App\Models\Campania;
use App\Util\RuleManager;
use App\Util\FilterManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
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
        $userlogeo = Auth::user();
        $filters = FilterManager::getFilters($this->request, new Cliente());
        $filtersCampania = FilterManager::getFilters($this->request, new Campania());
        $consultas =  Cliente::where($filters)
        ->with('eventoCliente','campania','distrito','empleosPostulados');
        // ->whereHas('campania', function ($query) use ($filterCampania) {
        //     $query->where($filterCampania);
        // })

        $idcarrera = $this->request->idcarrera;
            if ($idcarrera) {
                $consultas->whereHas('empleosPostulados.carreras', function ($query) use ($idcarrera) {
                    // Realizar la comparación con el valor de idcarrera
                    $query->where('idcarrera', $idcarrera);
                });
            }


            // Filtro para usuarios que no son administradores

        if ($userlogeo->idcuenta != RuleManager::SYSTEM_COMPANY_ACCOUNT || !in_array($userlogeo->idrol, RuleManager::ADMINISTRATORS_ACCESS)) {
             //dd($userlogeo->idcuenta);
            // Filtro para usuarios que no son administradores
            $consultas->where(function ($query) use ($userlogeo) {
                $query->whereHas('campania', function ($query) use ($userlogeo) {
                    $query->where('idcuenta', '=', $userlogeo->idcuenta);
                })
                ->whereHas('empleosPostulados', function ($query) use ($userlogeo) {
                    $query->where('idempresa', '=', $userlogeo->idempresa);
                });
            })
             ->with(['empleosPostulados' => function ($query) use ($userlogeo) {
            $query->where('idempresa', $userlogeo->idempresa);
             }]);

        }

         //filtro de fechas input buscar por fechas
         if ($this->request->exists('fechadesde')) {
            $fechadesde = Carbon::createFromFormat('d-m-Y', $this->request->fechadesde)->toDateString();
            $consultas->whereDate('fecharegistro', '>=', $fechadesde); //pasamos como consulta el campo fecharegistro
        }
        if ($this->request->exists('fechahasta')) {
            $fechahasta = Carbon::createFromFormat('d-m-Y', $this->request->fechahasta)->toDateString();
            $consultas->whereDate('fecharegistro', '<=', $fechahasta); //pasasmos como consulta el campos fecharegistro
        }


        // dump( $consultas->whereHas('campania', function ($query) use ($userlogeo) {
        //     $query->where('idcuenta','=',$userlogeo->idcuenta);
        // }));
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
        //emplos postulaos
        $empPost='';
       foreach( $model->empleosPostulados as $item ){
            $empPost = $empPost .''. $item->titulo .'; ';
        }
        
        //estudios
        $profileEstudios = '';
        foreach( $model->estudios as $item ){
            $profileEstudios = $profileEstudios .''. $item->carrera .' - '. $item->tipoestudio .' - '. $item->estadoestudio .' - '. $item->fechainicioFormated .' - '. $item->fechafinFormated .'; ';
        }

        //adjuntos CV
        $profileFiles = '';
        foreach( $model->files as $item ){
            $profileFiles = $item->url_patch;
        }

        //dump($profileFiles);

        //dump($empPost);
        return [
            $model->idcliente,
            $model->nombres,
            $model->apellidos,
            $model->email,
            $model->telefono,
            $model->direccion,
            $model->dni,
            $empPost,            
            $model->fecha,
            $model->asistencianame,
            $model->fechapresencia,
            // $model->coddistrito,
            //$model->carrera,
            //$model->tipoparticipante,
            $model->edad,
            $model->minsalarial .' - '. $model->maxsalarial,
            $model->descripcion,
            $profileEstudios,
            $profileFiles,
            //$model->grado,
            //$model->colegio,
            //$model->anioegreso,
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
            $model->campania->nombrecampania,
           // $model->eventoCliente->evento['nombreevento'],
           // $model->distrito->nombreubigeo,
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
            'Direccion',
            'Dni',
            'Empleos postulados',
            // 'fecharegistro',
            'Fecha Registro',
            'Asistencia',
            'Fecha Asistencia',
            // 'coddistrito',
            //'Carrera',
            //'Tipoparticipante',
            'Edad',
            'Expectativa Salarial Minima - Maxima',
            'Descripcion',
            'Estudios Carreras / Titulos',
            'Curriculum vitae',
            //'Grado',
            //'Colegio',
            //'Año de Egreso',
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
            'Campaña',
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
        return "Campaña";
    }
}
