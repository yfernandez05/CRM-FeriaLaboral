<?php

namespace App\Models;

use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;

class Files extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'cliente_id', 
        'nombre', 
        'url',
        'fecharegistro',
        'estado',
    ];

    protected $hidden = [
        'userinsert', 
        'dateinsert', 
        'userupdate', 
        'dateupdate',
    ];

    protected $casts = [
        'fecharegistro' => 'datetime:Y-m-d H:i:s',
    ];
    
    protected $appends = [
        'isactive',
        'statename',
        'fecharegistro',
    ];

    public function getIsactiveAttribute(){
        return RuleManager::getIsActive($this->estado);
    }

    public function getStatenameAttribute(){
        return RuleManager::getStateName($this->estado);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idcliente');
    }
    
    public function getFecharegistroAttribute()
    {
        return optional($this->fecharegistro)->format('d-m-Y');
    }
}
