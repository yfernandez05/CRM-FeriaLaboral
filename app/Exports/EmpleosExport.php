<?php

namespace App\Exports;

use App\Models\Empleo;
use Illuminate\Support\Facades\Auth;
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

class EmpleosExport implements FromCollection,WithStyles, ShouldAutoSize, WithMapping, WithHeadings, WithTitle
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
        $filters = FilterManager::getFilters($this->request, new Empleo());

        $query = Empleo::where($filters)
            ->with('empresa','experiencia','carreras','ciclos');

        // Verificar si el usuario tiene el rol y el idempresa específicos
        if ($userlogeo->idrol == '6') {
            $query->where('idempresa', $userlogeo->idempresa);
        }

        if ($this->request->exists('fechadesde')) {
            $fechadesde = Carbon::createFromFormat('d-m-Y', $this->request->fechadesde)->toDateString();
            $query->whereDate('fecha_publicacion', '>=', $fechadesde);
        }

        if ($this->request->exists('fechahasta')) {
            $fechahasta = Carbon::createFromFormat('d-m-Y', $this->request->fechahasta)->toDateString();
            $query->whereDate('fecha_publicacion', '<=', $fechahasta);
        }

        $empleo = $query->orderBy('id', 'DESC')
            ->get();

        return $empleo;
    }

    public function map($model): array
    {
        $carreraEmpleo = '';
        foreach( $model->carreras as $item ){
            $carreraEmpleo = $carreraEmpleo .''. $item->nombre.'; ';
        }

        $ciclosEmpleo = '';
        foreach( $model->ciclos as $item ){
            $ciclosEmpleo = $ciclosEmpleo.''. $item->nombre.'; ';
        }

        return [
            $model->empresa->empresa,
            $model->titulo,
            $carreraEmpleo,
            $ciclosEmpleo,
            $model->experiencia->nombre,
            $model->vacantes,
            $model->preciopromedio,
            $model->fecharegistro,            
            
        ];
        //return dd($model);
    }

    public function headings(): array
    {
        return [
            'Empresa',
            'Cargo',
            'Carreras',
            'Ciclos',
            'Tiempo experiencia ',
            'Vacantes',
            'Sueldo promedio',
            'Fecha publicacion',            
        ];
    }

    //darle stylo a las columnas o filas
    public function styles(Worksheet $sheet)
    {
        return [
            1    => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'ffffff'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => '1c1c1e'],
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
        return "Empleos";
    }
}
