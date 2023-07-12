<?php

namespace App\Models;

use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empleo;

class Carrera extends Model
{
    protected $table = 'carreras';
    protected $primaryKey = 'idcarrera';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
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
        return $this->belongsToMany(Empleo::class, 'empleo_carrera', 'id_carrera', 'id_empleo');
    }
}
