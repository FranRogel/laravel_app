<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
     protected $table = 'tags';
         protected $fillable = [ 
        'nombre'
     ];
     
     public function tareas()
      {
        return $this->hasMany(Tarea::class, 'tag_id');
      }
}
