<?php
namespace App\Imports;

use App\Models\Importacion;
use App\Models\Institucion;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class InstitucionesImport  implements ToModel, WithStartRow
{

    private $rows = 0;

    public function __construct(Importacion $importacion, $idasesor){
        $this->importacion = $importacion;
        $this->asesor = $idasesor;
    }
    

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
 

    public function model(array $row)
    {

        if (!isset($row[0])) {
            return null;
        }

        ++$this->rows;

        return new Institucion([            
            'nombresdirector' => $row[0], 
            'apellidosdirector' => $row[1], 
            'institucion' => $row[2], 
            'email' => $row[3],
            'celular' => $row[4],
            'telefono' => $row[5], 
            'cargo' => $row[6], 
            //'pkubigeo' => $row[3],
            'departamento' => $row[7], 
            'distrito' => $row[8],             
            'sede' => $row[9],  
            'direccion' => $row[10], 
            'paginaweb' => $row[11], 
            'tipoinstitucion' => $row[12], 
            'procedencia' => $row[13], 
            'contactoalterno' => $row[14], 
            'correoalterno' => $row[15], 
            'cargoalterno' => $row[16],            
            'celularalterno' => $row[17],            
            'telefonoalterno' => $row[18],            
            'iduser'=> $this->asesor,
            'uuidimportacion' => $this->importacion->uuidimportacion,
        ]);
        
        /* 'idcuenta'=> $this->importacion->iduser,
            'uuidimportacion' => $this->importacion->uuidimportacion, */
    }

    public function startRow(): int
    {
        return 2;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

}
