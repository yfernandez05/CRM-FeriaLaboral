<?php

namespace App\Models;

use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    protected $primaryKey = 'idempresa';
    public $timestamps = false;

    protected $fillable = [
        'empresa',
        'ruc',
        'razonsocial',
        'estado'    
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
