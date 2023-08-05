<?php

namespace App\Models;

use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;

class DescargaHistorial extends Model
{
    protected $table = 'descargahistoriales';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'tipodocumento_id',
        'fecha_descarga',
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

    /* public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idempresa', 'empresa_id')->withDefault([
            'empresa' => '',
        ]);
    } */


    public function getIsactiveAttribute(){
        return RuleManager::getIsActive($this->estado);
    }

    public function getStatenameAttribute(){
        return RuleManager::getStateName($this->estado);
    }
}
