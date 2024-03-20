<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // Crear rol de administrador si no existe
        if (!Role::where('name', 'Administrador')->exists()) {
            Role::create(['name' => 'Administrador']);
        }
        // Crear rol de Segregación si no existe
        if (!Role::where('name', 'Recibo')->exists()) {
            Role::create(['name' => 'Recibo']);
        }
        // Crear rol de Segregación si no existe
        if (!Role::where('name', 'Segregacion')->exists()) {
            Role::create(['name' => 'Segregacion']);
        }

        // Crear rol de Desnaturalización si no existe
        if (!Role::where('name', 'Desnaturalizacion')->exists()) {
            Role::create(['name' => 'Desnaturalizacion']);
        }

        // Crear rol de supervisor si no existe
        if (!Role::where('name', 'Plasticos')->exists()) {
            Role::create(['name' => 'Plasticos']);
        }
    }


}
