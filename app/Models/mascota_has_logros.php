<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Logros;
use App\Models\Informacion;


class mascota_has_logros extends Model
{
    use HasFactory;


    public $table  = "mascota_has_logros";

    protected $fillable = [
        'mascota_id',
        'logros_id'

    ];

    public function mascota(){
        return $this->belongsTo(Informacion::class, 'mascota_id', 'id');
    }
    
    public function logros(){
        return $this->belongsTo(Logros::class, 'logros_id', 'id');
    }
}
