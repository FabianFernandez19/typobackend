<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tipomascota;
use App\Models\Actividad;

class tipomascota_has_actividad extends Model
{
    use HasFactory;


    public $table  = "tipomascota_has_actividad";

    protected $fillable = [
        'tipomascota_id',
        'actividad_id'

    ];

    public function tipomascota(){
        return $this->belongsTo(tipomascota::class, 'tipomascota_id', 'id');
    }
    
    public function actividad(){
        return $this->belongsTo(Actividad::class, 'actividad_id', 'id');
    }



}
