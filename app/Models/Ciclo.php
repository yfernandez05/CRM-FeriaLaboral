<?php

namespace App\Models;

use App\Models\Empleo;
use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    protected $table = 'ciclo';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
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

    public function empleos()
    {
        return $this->belongsToMany(Empleo::class, 'empleo_ciclo', 'ciclo_id', 'id_empleo');
    }

}
