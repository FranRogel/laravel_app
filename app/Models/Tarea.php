<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;
    protected $table = 'tareas';
    
    
    protected $fillable = [ 
        'nombre',
        'descripcion',
        'fecha_comienzo',
        'fecha_final',
        'tag_id'
    ];
    
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
