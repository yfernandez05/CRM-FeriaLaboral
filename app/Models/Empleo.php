<?php

namespace App\Models;

use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;

class Empleo extends Model
{
    protected $table = 'empleos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'idempresa',
        'titulo',
        'descripcion',
        'requisitos',
        'fecha_publicacion', 
        'fecha_cierre', 
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

    public function getIsactiveAttribute(){
        return RuleManager::getIsActive($this->estado);
    }

    public function getStatenameAttribute(){
        return RuleManager::getStateName($this->estado);
    }

}
