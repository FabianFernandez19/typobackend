<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelsHasRolesSeeder extends Seeder
{
    public function run()
    {
        DB::table('model_has_roles')->insert([
            [   'role_id' => 1,
                'model_type' => 'App\Models\User',
                'model_id' => 1,
            ],
            [
                'role_id' => 1,
                'model_type' => 'App\Models\User',
                'model_id' => 2,
            ],
        ]);
    }
}

