<?php

namespace App\Models;

use App\Util\RuleManager;
use App\Models\Carrera;
use App\Models\Experiencia;
use App\Models\Ciclo;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Model;

class Empleo extends Model
{
    protected $table = 'empleos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'idempresa',
        'titulo',
        'vacantes',
        'preciopromedio',
        'idexperiencia',
        'descripcion',
        'requisitos',
        'beneficios',
        'fecha_publicacion', 
        'fecha_cierre', 
        'estado',
    ];
    
    protected $hidden = [
        'userinsert', 
        'dateinsert', 
        'userupdate', 
        'dateupdate',
    ];

    protected $casts = [
        'fecha_publicacion' => 'datetime:Y-m-d H:i:s',
    ];

    protected $appends = [
        'isactive',
        'statename',
        'fecharegistro',
    ];   
    
    public function getPreciopromedioAttribute($value)
    {
        return $value ?? 0;
    }
    
    public function getIdexperienciaAttribute($value)
    {
        return $value ?? '';
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idempresa')->withDefault([
            'empresa' => '',
        ]);
    }
    public function experiencia()
    {
        return $this->belongsTo(Experiencia::class, 'idexperiencia', 'id')->withDefault([
            'nombre' => '',
        ]);
    }

    public function getIsactiveAttribute(){
        return RuleManager::getIsActive($this->estado);
    }

    public function getStatenameAttribute(){
        return RuleManager::getStateName($this->estado);
    }
    public function getFecharegistroAttribute()
    {
        return optional($this->fecha_publicacion)->format('d-m-Y');
    }

    public function carreras()
    {
        return $this->belongsToMany(Carrera::class, 'empleo_carrera', 'id_empleo', 'id_carrera');
    }

    public function ciclos()
    {
        return $this->belongsToMany(Ciclo::class, 'empleo_ciclo', 'id_empleo', 'ciclo_id');
    }

}
