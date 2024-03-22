<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informacion extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'Nombre_Mascota',
        'Edad',
        'Raza',
        'Peso',
        'Tamaño',
        'Sexo',
        'tiempo_total',
        'user_id',
        'id_tipomascota'
    ];

    public $table = 'informacion';

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function tipomascota(){
        return $this->hasMany(Tipomascota::class, 'id_tipo', 'id');
  }

  public function logros()
  {
      return $this->belongsToMany(Logros::class, 'mascota_has_logros', 'mascota_id', 'logros_id');
  }

  public function logrosAsignados($mascotaId)
{
    // Recupera los logros asignados a la mascota con el ID dado
    return $this->hasManyThrough(Logros::class, mascota_has_logros::class, 'mascota_id', 'id', 'id', 'logros_id')
        ->where('mascota_id', $mascotaId)->get();
}




    public function agendamientos()
    {
        return $this->hasMany(Agendamiento::class, 'infomascota_id', 'id');
    }

 // public function actividad(){
   //  return $this->belongsToMany(Actividad::class)->withPivot('id');
 //}
}
