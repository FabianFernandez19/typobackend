<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //  User::create(["id"=>1, "name"=>"Huver","fecha_nacimiento"=>'2005-10-17', "apellido"=>"Hernandez","telefono"=>3219876543, "email"=>"huver@correo.com", "password"=>bcrypt("12345678")]);
    }
}
