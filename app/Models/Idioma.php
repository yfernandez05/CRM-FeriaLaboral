<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    protected $table = 'idiomas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'idcliente',
        'nombre',
        'estado',
    ];
    
    protected $hidden = [
        'userinsert', 
        'dateinsert', 
        'userupdate', 
        'dateupdate',
    ];
}
