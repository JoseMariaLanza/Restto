<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Usuarios
        Permission::create([
            'name'          => 'Navegar usuarios',
            'slug'          => 'users.index',
            'description'   => 'Lista y navega todos los usuarios del sistema',
        ]);
        Permission::create([
            'name'          => 'Ver detalle de usuario',
            'slug'          => 'users.show',
            'description'   => 'Ver en detalle cada usuario del sistema',
        ]);
        Permission::create([
            'name'          => 'Edición de usuarios',
            'slug'          => 'users.edit',
            'description'   => 'Editar cualquier dato de un usuario del sistema',
        ]);
        Permission::create([
            'name'          => 'Eliminar usuario',
            'slug'          => 'users.destroy',
            'description'   => 'Eliminar cualquier usuario del sistema',
        ]);
        
        // Roles
        Permission::create([
            'name'          => 'Navegar roles',
            'slug'          => 'roles.index',
            'description'   => 'Lista y navega todos los roles del sistema',
        ]);
        Permission::create([
            'name'          => 'Ver detalle de rol',
            'slug'          => 'roles.show',
            'description'   => 'Ver en detalle cada rol del sistema',
        ]);
        Permission::create([
            'name'          => 'Creación de roles',
            'slug'          => 'roles.create',
            'description'   => 'Editar cualquier dato de un rol del sistema',
        ]);
        Permission::create([
            'name'          => 'Edición de roles',
            'slug'          => 'roles.edit',
            'description'   => 'Editar cualquier dato de un rol del sistema',
        ]);
        Permission::create([
            'name'          => 'Eliminar rol',
            'slug'          => 'roles.destroy',
            'description'   => 'Eliminar cualquier rol del sistema',
        ]);

        // Cajas
        Permission::create([
            'name'          => 'Navegar cajas',
            'slug'          => 'cajas.index',
            'description'   => 'Lista y navega todas las cajas del sistema',
        ]);
        Permission::create([
            'name'          => 'Ver detalle de caja',
            'slug'          => 'cajas.show',
            'description'   => 'Ver en detalle cada caja del sistema',
        ]);
        Permission::create([
            'name'          => 'Creación de cajas',
            'slug'          => 'cajas.create',
            'description'   => 'Editar cualquier dato de una caja del sistema',
        ]);
        Permission::create([
            'name'          => 'Edición de cajas',
            'slug'          => 'cajas.edit',
            'description'   => 'Editar cualquier dato de una caja del sistema',
        ]);
        Permission::create([
            'name'          => 'Eliminar caja',
            'slug'          => 'cajas.destroy',
            'description'   => 'Eliminar cualquier caja del sistema',
        ]);
        Permission::create([
            'name'          => 'Actualizar el estado de la caja',
            'slug'          => 'ventas.updateState',
            'description'   => 'Abrir o cerrar una caja del sistema',
        ]);

        Permission::create([
            'name'          => 'Ingresar una venta en el sistema',
            'slug'          => 'ventas.create',
            'description'   => 'Creación de facturas y detalles',
        ]);
    }
}
