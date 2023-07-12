<?php

namespace App\Models;

use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;

class ConexionSocket extends Model
{
    protected $table = 'conectionchat';
    protected $primaryKey = 'idconexion';
    public $timestamps = false;

    protected $fillable = [
        'nombre', 
        'descripcion', 
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
    
}
