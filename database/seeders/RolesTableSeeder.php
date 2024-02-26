<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // Crear rol de administrador si no existe
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }
    
        // Crear rol de operario si no existe
        if (!Role::where('name', 'operario')->exists()) {
            Role::create(['name' => 'operario']);
        }
    
        // Crear rol de supervisor si no existe
        if (!Role::where('name', 'supervisor')->exists()) {
            Role::create(['name' => 'supervisor']);
        }
    }
    

}
