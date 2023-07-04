<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudio extends Model
{
    protected $table = 'estudios';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'idcliente',
        'carrera',
        'tipoestudio',
        'estadoestudio',
        'fechainicio',
        'fechafinalizacion',
        'estado',
    ];

    protected $hidden = [
        'userinsert',
        'dateinsert',
        'userupdate',
        'dateupdate',
    ];

    protected $casts = [
        'fechainicio' => 'datetime:Y-m-d H:i:s',
        'fechafinalizacion'=> 'datetime:Y-m-d H:i:s',
    ];

    protected $appends = [
        'fechainicioFormated',
        'fechafinFormated'
    ];

    public function getFechainicioFormatedAttribute()
    {
        return optional($this->fechainicio)->format('Y-m');
    }

    public function getFechafinFormatedAttribute()
    {
        return optional($this->fechafinalizacion)->format('Y-m');
    }
}
