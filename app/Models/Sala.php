<?php

namespace App\Models;

use App\Util\RuleManager;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $table = 'chats';
    protected $primaryKey = 'chat_id';
    public $timestamps = false;

    protected $fillable = [
        'nombresala',
        'datofijado',
        'descripcion',
        'idtiposala',
        'estado'    
    ];

    protected $hidden = [
        'updated_at', 
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
