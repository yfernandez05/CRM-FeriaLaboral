<?php

namespace App\Imports;

use App\Models\Cliente;
use App\Models\Evento;
use App\Models\EventoCliente;
use App\Models\Importacion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ClientesImport implements ToModel, WithStartRow
{
    private $rows = 0;

    public function __construct(Importacion $importacion, $evento){
        $this->importacion = $importacion; 
        $this->evento = $evento;
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

        return  new Cliente([
            'nombres' => $row[0], 
            'apellidos' => $row[1], 
            'email' => $row[2], 
            'telefono' => $row[3], 
            'dni' => $row[4], 
            'idcampania' => $this->importacion->idcampania, 
            //'idcampania' => $row[5], 
            //'idevento' => $row[5], 
            'fecharegistro' => $row[5], 
            'coddistrito' => $row[6], 
            'carrera' => $row[7], 
            //'evento' => $row[9], 
            'tipoparticipante' => $row[8], 
            'edad'=> $row[9],
            'grado'=>$row[10], 
            'colegio' => $row[11], 
            'anioegreso' => $row[12],
            'procedencia' => $row[13],
            'utm' => $row[14], 
            'campaign_content' => $row[15],
            'campaign_medium' => $row[16],
            'campaign_name' => $row[17],
            'campaign_source' => $row[18],
            'campaign_term' => $row[19],
            'uuidimportacion' => $this->importacion->uuidimportacion,
        ]);

        /* $eventos = new EventoCliente([
            'idcliente' => $cliente->idcliente,
            'idevento' => $this->evento,            
        ]); */
        
        //return dd([$cliente->idcliente, $eventos]);

        //return dd($this->idevento);
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
