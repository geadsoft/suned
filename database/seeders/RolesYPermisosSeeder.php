<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesYPermisosSeeder extends Seeder
{
    public function run()
    {
        // Limpiar caché
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        $permisos = [
            'ver dashboard',
            'ver reportes',
            'editar usuarios',
            'crear posts',
            'borrar posts',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // Crear roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);

        // Asignar permisos a roles
        $admin->givePermissionTo(Permission::all());
        $editor->givePermissionTo(['ver dashboard', 'crear posts']);

        // Crear un usuario de prueba
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Test',
                'password' => bcrypt('password') // Cambialo si querés
            ]
        );

        // Asignar rol al usuario
        $user->assignRole('admin');

        // También podés asignarle permisos directos si querés probar:
        // $user->givePermissionTo('borrar posts');

        echo "✅ Seeder ejecutado: Usuario admin@example.com / password\n";
    }
}