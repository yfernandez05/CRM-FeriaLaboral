<?php

namespace App\Models;

use App\User;
use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $table = 'instituciones';
    protected $primaryKey = 'idinstitucion';
    public $timestamps = false;

    protected $fillable = [
        'nombresdirector', 
        'apellidosdirector',
        'institucion',
        'email',
        'celular',
        'telefono',
        'cargo',
        'pkubigeo',
        'departamento',
        'distrito',
        'sede',
        'direccion',
        'paginaweb',
        'tipoinstitucion',
        'procedencia',
        'contactoalterno',
        'correoalterno',
        'cargoalterno',
        'celularalterno',
        'telefonoalterno',
        'iduser',
        'idtipoconfirmacion',
        'idcampania',
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

    //para mostrar el nombre y ya no el id en el listado 
    public function campania(){
        return $this->belongsTo(Campania::class, 'idcampania', 'idcampania')
            ->with('cuenta');
    }

    public function distrito(){
        return $this->belongsTo(Ubigeo::class, 'pkubigeo', 'pkubigeo')
            ->withDefault([
                'pkubigeo'=>'',
                'fkubigeo'=>'',
                'nombreubigeo'=> '',
                'nivel' => -1,
                'nombrecompleto'=>'',
            ]);
    }


    public function ultimaatencion()
    {
        //agregams una data intenra con valores por dfecto evitando que muestre null y no reconozca en el index de vue
        return $this->hasOne(AtencionInstitucion::class, 'idinstitucion', 'idinstitucion')
            ->withDefault([
                'idinstitucion'=>'',
                'idtipoconfirmacion'=>1,
                'comentario'=> '',
                'idcampania'=>'',
                'tipoatencion'=>[
                    'tipoconfirmacion' => 'Sin Confirmar',
                    'color' => 'badge-info',
                    'idtipoconfirmacion' => 1
                ],
                'campania'=>[
                    'nombrecampania' => '',
                ]
            ])
            ->with('tipoatencion','campania')
            ->orderBy('idatencion', 'desc');
    }

    public function user(){
        return $this->belongsTo(User::class, 'iduser', 'id');
    }

}
