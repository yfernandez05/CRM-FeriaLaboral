<?php

namespace App\Models;

use App\User;
use App\Util\RuleManager;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Invitacion extends Model
{
    protected $table = 'invitaciones';
    protected $primaryKey = 'idinvitacion';
    public $timestamps = false;

    protected $fillable = [
        'nombreinstitucion', 
        'nombreencargado',
        'fecharegistro',
        'idinstitucion',
        'iduser',
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
        'fecha',
        'fechaes',
        'isactive',
        'statename',
    ];

    public function getIsactiveAttribute(){
        return RuleManager::getIsActive($this->estado);
    }

    public function getStatenameAttribute(){
        return RuleManager::getStateName($this->estado);
    }

    public function getFechaAttribute()
    {
        return optional($this->fecharegistro)->format('d-m-Y');
    }

    public function getFechaesAttribute()
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        //return optional($this->fecharegistro)->format('d-m-Y');
        $fecha = Carbon::parse($this->fecharegistro);
        $mes = $meses[($fecha->format('n')) - 1];
        return  $fecha->format('d') . ' de ' . $mes . ' del ' . $fecha->format('Y');

    }

    public function user(){
        return $this->belongsTo(User::class, 'iduser', 'id');
    }


}
