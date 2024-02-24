<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipomascota extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_mascota',
 
    ];

    public $table  = "tipomascota";

    public $timestamps = false;



    public function informacion()
    {
        return $this->hasMany(Informacion::class,'id_mascota', 'id');
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'tipomascota_id');
    }



}
