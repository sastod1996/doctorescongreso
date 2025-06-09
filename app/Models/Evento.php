<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
        public function doctores()
    {
        return $this->hasMany(Doctor::class); 
    }
    public $timestamps = false;
}
