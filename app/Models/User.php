<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

//Spatie
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'apellido',
        'telefono',
        'fecha_nacimiento',
        'email',
        'password',
        'tiempo_total'
    ];



    public function logros()
    {
        return $this->belongsToMany(Logro::class, 'user_has_logros', 'user_id', 'logro_id')
                    ->withTimestamps();
    }


  /*  public function informacion()
{
    return $this->hasMany(Informacion::class);
}*/



public function agendamientos()
{
    return $this->hasMany(Agendamiento::class);
}




public function informaciones()
    {
        return $this->hasMany(Informacion::class);
    }


    public function reporteCumplimiento()
{
    return $this->hasOne(reporte_cumplimiento::class);
}





  

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];
}
