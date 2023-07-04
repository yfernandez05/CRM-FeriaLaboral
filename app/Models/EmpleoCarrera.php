<?php

namespace App\Models;

use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;

class EmpleoCarrera extends Model
{
    protected $table = 'empleo_carrera';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_empleo',
        'id_carrera',
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

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idempresa')->withDefault([
            'empresa' => '',
        ]);
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'idcarrera')->withDefault([
            'nombre' => '',
        ]);
    }

    public function getIsactiveAttribute(){
        return RuleManager::getIsActive($this->estado);
    }

    public function getStatenameAttribute(){
        return RuleManager::getStateName($this->estado);
    }
}
