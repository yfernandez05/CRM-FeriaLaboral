<?php

namespace App\Imports;

use App\Models\Empleo;
use App\Models\Importacion;
use App\Models\EventoCliente;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EmpleosImport implements ToModel, WithStartRow
{
    private $rows = 0;

    public function __construct(Importacion $importacion,$idempresa){
        $this->importacion = $importacion;
        $this->empresa = $idempresa;
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

        return  new Empleo([
            'titulo' => $row[0],
            'requisitos' => $row[1],
            'descripcion' => $row[2],
            'idempresa'=> $this->empresa,
            'uuidimportacion' => $this->importacion->uuidimportacion,
        ]);


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
