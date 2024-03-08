<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reporte_cumplimiento extends Model
{
    use HasFactory;

    protected $table = 'reporte_cumplimiento';

    protected $fillable = [
        'mes',
        'porcentaje_cumplimiento',
        'total_agendamientos_cumplidos',
        'agendamientos_no_cumplidos',
        'user_id'

 
    ];


    public $timestamps = false;

    // Define la relación con el modelo User
    /*public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define la relación con el modelo Logro
    public function logro()
    {
        return $this->belongsTo(Logro::class, 'logro_id');
    }*/

        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }




  
}
