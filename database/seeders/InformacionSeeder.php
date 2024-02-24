<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Informacion;

class InformacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Informacion::create(["Nombre_Mascota"=>"luna", "Edad"=>5, "Raza"=>"chiwawa", "peso"=>6, "tamaño"=>1.80, "sexo"=>'Hembra', "user_id"=>1,"id_tipomascota"=>1]);

    }
}
