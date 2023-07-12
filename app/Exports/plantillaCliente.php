<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class plantillaCliente implements WithHeadings, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        $cabecera = [
            'Nombre',
            'Apellidos',
            'Correo',
            'Telefono',
            'Dni',
            //'Codigo Campaña',
            'Fecha_Registro',
            'Distrito',
            'Carreras',
            'Tipo participante',
            'Edad',
            'Grado',
            'Colegio',
            'Egreso',
            'Procedencia',
            'Utm',
            'campaign_content',
            'campaign_medium',
            'campaign_name',
            'campaign_source',
            'campaign_term',
        ];

        $guia = [
            'Laura Elizabeth',
            'Flores Martinez',
            'Correo@gmail.com',
            '999999999',
            '78945612',
            //'1',
            '2022-04-28',
            ' ',
            'Administración y Dirección de Empresas',
            'Postulante',
            '23',
            'Egresado',
            '',
            '0',
            'Orgánico',
            '',
            '',
            '',
            '',
            '',
            '',
        ];

        return array($cabecera,$guia);
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
                    'color' => ['argb' => '00b7bd'],
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
