<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamiento extends Model
{
    use HasFactory;

    public $table = "agendamiento";

    protected $fillable = [
        'tiempo_asignado_actividad',
        'Fecha_Agendamiento',
        'cumplida',
        'infomascota_id',
        'actividades_id',
        'user_id',
        'reportecumplimiento_id'

    ];
  
    public function informacion()
    {
        return $this->belongsTo(Informacion::class, 'infomascota_id', 'id');
    }
    
    public function reporte_cumplimiento()
    {
        return $this->hasOne(Reporte_cumplimiento::class, 'reportecumplimiento_id', 'id');
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'agendamiento_id', 'id');
    }
}

     

