<?php

namespace App\Models;

use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;

class HistorialLaboral extends Model
{
    protected $table = 'historial_laboral';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'idcliente',
        'nombre',
        'empresa',
        'actividad',
        'puesto',
        'nivel',
        'area',
        'fechainicio',
        'fechafinalizacion',
        'fechapresente',
        'descripcion',
        'personaacargo',
        'estado',
    ];
    
    protected $hidden = [
        'userinsert', 
        'dateinsert', 
        'userupdate', 
        'dateupdate',
    ];

    protected $appends = [
        'fechainicioFormated',
        'fechapresentename',
    ];

    protected $casts = [
        'fechainicio' => 'datetime:Y-m-d H:i:s',
        'fechafinalizacion'=> 'datetime:Y-m-d H:i:s',
    ];

    public function getFechainicioFormatedAttribute()
    {
        return optional($this->fechainicio)->format('Y-m');
    }


    public function getFechapresentenameAttribute()
    {
        return $this->fechapresente == 1 ? 'Actualidad' : $this->fechafinalizacion->format('Y-m');
    }

}
