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
      // User::create(["id"=>1, "name"=>"Huver", "apellido"=>"Hernandez" ,"telefono"=>3219876543,"fecha_nacimiento"=>'2005-10-17', "email"=>"huver@correo.com", "password"=>bcrypt("12345678")]);
    }
}
