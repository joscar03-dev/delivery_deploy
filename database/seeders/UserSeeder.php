<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un nuevo usuario
        $user = User::create([
            'name' => 'Jose Carlos',
            'email' => 'joscar@admin.com',
            'password' => Hash::make('verano2080'),
        ]);

        // Asegurarse de que el rol existe antes de asignarlo
        $role = Role::where('name', 'admin')->first();
        if ($role) {
            // Asignar el rol al usuario
            $user->assignRole($role);
        } else {
            echo "El rol no existe";
        }
    }
}
