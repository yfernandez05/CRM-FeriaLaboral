<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class plantillaInstitucion  implements WithHeadings, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {

        /* $usuario = new User();
        $datosusuario = $usuario->cuenta(); */

        $cabecera = [
            'Nombres',
            'Apellidos',
            'Institución',
            'Correo',
            'Celular',
            'Telefono', 
            'Cargo',
            //'pkubigeo'
            'Departamento', 
            'Distrito',        
            'Sede',
            'Direccion', 
            'Pagina Web', 
            'Tipo de Inistitución', 
            'Procedencia', 
            'Contacto alterno', 
            'Correo alterno', 
            'Cargo alterno',          
            'Celular alterno',          
            'Telefono alterno',          
            //'Codigousuario - NO CAMBIAR',
        ];
        $guia = [
            'Jesus Enrique (OBLIGATORIO)',
            'Vicente Edelmiro (OBLIGATORIO)',
            'I.E Ricardo Palma (OBLIGATORIO)',
            'Correo@descubretuvocacion.com',
            '912345678 ó 0 (OBLIGATORIO)',
            '2781545',
            'Director General',
            'Miraflores',
            'Lima',
            '',
            'Av Nicolás de Piérola N°550 Cercado de Lima.',
            'https://www.descubretuvocacion.pe/',
            'Privado',
            'Base Usuario Adminstrador',
            '',
            '',
            '',
            '0 (OBLIGATORIO)',
            '',
            //Auth::user()->idcuenta,
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
                    'color' => ['argb' => '0688c2'],
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
