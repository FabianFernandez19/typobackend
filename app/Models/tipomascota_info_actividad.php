<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipomascota_info_actividad extends Model
{
    use HasFactory;

    
    public $table  = "tipomascota_info_actividad";

    protected $fillable = [
        'tipomascota_id',
        'actividad_id'

    ];

    public function tipomascota(){
        return $this->belongsTo(Tipomascota::class, 'tipomascota_id', 'id');
    }
    
    public function actividad(){
        return $this->belongsTo(actividad::class, 'actividad_id', 'id');
    }
}
