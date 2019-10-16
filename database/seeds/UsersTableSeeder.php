<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Role;
use App\User;
use App\Empleado;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'José María',
            'email' => 'lanza.josemaria@gmail.com',
            'password' => Hash::make('123123123')
        ]);

        Empleado::create([
            'Nombre' => 'José María',
            'User_Id' => 1
        ]);

        Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'special' => 'all-access'
        ]);
        Role::create([
            'name' => 'Suspendido',
            'slug' => 'suspendido',
            'description' => 'Usuarios de vacaciones',
            'special' => 'no-access'
        ]);
    }
}
