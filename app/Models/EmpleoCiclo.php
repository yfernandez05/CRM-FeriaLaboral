<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpleoCiclo extends Model
{
    protected $table = 'empleo_ciclo';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_empleo',
        'ciclo_id',  
    ];

    /* public function ciclo()
    {
        return $this->belongsTo(ciclo::class, 'id')->withDefault([
            'nombre' => '',
        ]);
    } */
}
