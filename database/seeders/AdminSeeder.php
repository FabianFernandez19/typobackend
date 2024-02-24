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

        /*
        Role::create(["name" => "Administrator"]);
        Admin::create([
            "email" => "admin@gmail.com",
            "password" => bcrypt("12345678")
        ]);
        $user = User::create([
            "email" => "admin@gmail.com",
            "password" => bcrypt("12345678"),
            "name" => "admin",
            "apellido" => "admin",
            "telefono" => 3123653874,
            "fecha_nacimiento" => "2000-01-29"
        ]);

        // Asignación del rol
        $user->assignRole('Administrator'); */
    }
}
