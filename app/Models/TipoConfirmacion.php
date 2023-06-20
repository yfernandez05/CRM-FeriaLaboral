<?php

namespace App\Models;

use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;

class TipoConfirmacion extends Model
{
    protected $table = 'tipoconfirmacionInstitucion';
    protected $primaryKey ='idtipoconfirmacion';
    public $timestamps = false;

    protected $fillable = [
        'tipoconfirmacion',
        'color',
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
