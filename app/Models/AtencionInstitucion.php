<?php

namespace App\Models;

use App\User;
use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;

class AtencionInstitucion extends Model
{
    protected $table = 'atencionesInstitucion';
    protected $primaryKey = 'idatencion';
    public $timestamps = false;

    protected $fillable = [
        'iduser',
        'idinstitucion',
        'fechaatencion',
        'comentario',
        'idtipoconfirmacion',
        'idcampania',
        'estado'
    ];

    protected $hidden = [
        'userinsert', 
        'dateinsert', 
        'userupdate', 
        'dateupdate',
    ];
    protected $casts = [
        'fechaatencion' => 'datetime:Y-m-d H:i:s',
    ];

    protected $appends = [
        'isactive',
        'statename',
        'fecha',
        'isattended',
    ];

    public function getIsactiveAttribute(){
        return RuleManager::getIsActive($this->estado);
    }

    public function getStatenameAttribute(){
        return RuleManager::getStateName($this->estado);
    }
    
    public function getIsattendedAttribute(){
        $attended = false;

        if($this->idatencion != null && $this->idatencion != '')
            $attended = true;

        return $attended;
    }

    public function getFechaAttribute()
    {
        return optional($this->fechaatencion)->format('d-m-Y');
    }

    public function user(){
        return $this->belongsTo(User::class, 'iduser', 'id');
    }
    public function tipoatencion(){
        return $this->belongsTo(TipoConfirmacion::class, 'idtipoconfirmacion', 'idtipoconfirmacion');
    }
    public function institucion(){
        return $this->belongsTo(Institucion::class, 'idinstitucion', 'idinstitucion');
    }
    public function campania(){
        return $this->belongsTo(Campania::class, 'idcampania', 'idcampania');
    }   
    
}
