<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class plantillaEmpleo implements WithHeadings, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        $cabecera = [
            'Nombre Empleo',
            'Requerimiento ',
            'Descripción',

        ];

        $guia = [
            'Administracion',
            'Lorem Ipsum is of the printing and typesetting industry. Lorem Ipsum has been the industry',
            'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry of the printing and typesetting industry. Lorem Ipsum has been the industry',
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
