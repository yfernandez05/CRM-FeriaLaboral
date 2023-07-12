<?php

namespace App\Models;

use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;

class Moderador extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'idcliente';
    public $timestamps = false;

    protected $fillable = [
            'nombres', 
            'apellidos', 
            'email', 
            'telefono', 
            'dni',
            'edad', 
            'moderador',
            'estado', 

    ];

    protected $hidden = [
        'userinsert', 
        'dateinsert', 
        'userupdate', 
        'dateupdate',
    ];

    protected $appends = [
        'isactive',
        'statename',
    ];

    public function getIsactiveAttribute(){
        return RuleManager::getIsActive($this->estado);
    }

    public function getStatenameAttribute(){
        return RuleManager::getStateName($this->estado);
    }

    //para mostrar el nombre y ya no el id en el listado 
    public function campania(){
        return $this->belongsTo(Campania::class, 'idcampania', 'idcampania')
            ->with('cuenta');
            //->with('evento','cuenta');
    }
}
