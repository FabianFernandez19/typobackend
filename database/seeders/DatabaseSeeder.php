<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        $this->call(TipoMascotaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ActividadSeeder::class);
        $this->call(AgendamientoSeeder::class);
        $this->call(InformacionSeeder::class);
        $this->call(Informacion_ActividadSeeder::class);
        $this->call(AdminSeeder::class);





    }
}
