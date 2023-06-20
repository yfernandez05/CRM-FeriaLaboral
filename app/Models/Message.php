<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
            'idcliente', 
            'chat_id', 
            'message', 
            'estado',
    ];

    protected $hidden = [
        'created_at', 
        'updated_at',
    ];
}
