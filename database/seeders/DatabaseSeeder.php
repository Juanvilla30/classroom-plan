<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $rol = new Role();
        $rol->id = 1;
        $rol->name_role= "administrador";
        $rol->save();

        $rol2 = new Role();
        $rol2->id = 2;
        $rol2->name_role= "vicerrectoría";
        $rol2->save();

        $rol3 = new Role();
        $rol3->id = 3;
        $rol3->name_role= "coordinador";
        $rol3->save();

        $rol4 = new Role();
        $rol4->id = 4;
        $rol4->name_role= "docente";
        $rol4->save();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'last_name' => 'suport',
            'phone' => '1234567890',
            'email' => 'aulamanager.support@gmail.com',
            'password' => 'admin',
            'id_role' => '1',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'vicerrector',
            'last_name' => 'vice',
            'phone' => '1234567890',
            'email' => 'vicerrectoria@uniautonoma.edu.co',
            'password' => 'vicerrectoria',
            'id_role' => '2',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Zulema Yidney',
            'last_name' => 'León Escobar',
            'phone' => '1234567890',
            'email' => 'coordinacion.software@uniautonoma.edu.co',
            'password' => 'vicerrectoria',
            'id_role' => '3',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'docente',
            'last_name' => 'software',
            'phone' => '0000000000',
            'email' => 'docente.software@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
        ]);
    }
}
