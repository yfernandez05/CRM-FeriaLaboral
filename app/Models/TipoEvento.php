<?php

namespace App\Models;

use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;

class TipoEvento extends Model
{
    protected $table = 'tipoeventos';
    protected $primaryKey ='idtipoevento';
    public $timestamps = false;

    protected $fillable = [
        'tipoevento',
        'backgroundColor',
        'textColor',
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
