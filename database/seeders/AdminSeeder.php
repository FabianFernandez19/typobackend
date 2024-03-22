<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
        Admin::create([
            "email" => "admin@gmail.com",
            "password" => bcrypt("2222")
        ]);
        $user = User::create([
            "email" => "admin@gmail.com",
            "password" => bcrypt("2222"),
            "name" => "admin",
            "apellido" => "admin",
            "telefono" => 3203871121,
            "fecha_nacimiento" => "2004-08-19"
        ]);
        // Asignación del rol
        $user->assignRole('Administrator');
    }
}
