<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin
        $permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($permissions->pluck('id'));

        // Supervisor
        $supervisor_permissions = $permissions->filter(function($permission){
            return substr($permission->name, 0, 4) == 'user' ||
            (substr($permission->name, 0, 9) == 'inventory' && substr($permission->name, 0, 11) != 'inventory_c') ||
            substr($permission->name, 0, 6) == 'client' ||
            (substr($permission->name, 0, 5) == 'debts' && substr($permission->name, 0, 7) != 'debts_p') ||
            (substr($permission->name, 0, 11) == 'to_discount' && substr($permission->name, 0, 13) != 'to_discount_c') ||
            (substr($permission->name, 0, 4) == 'sale' && substr($permission->name, 0, 6) != 'sale_c') ||
            substr($permission->name, 0, 6)=='report';
        });
        Role::findOrFail(2)->permissions()->sync($supervisor_permissions->pluck('id'));

        //Vendedor
        $vendedor_permissions = $permissions->filter(function($permission){
            return substr($permission->name, 0, 8) == 'client_c' ||
            substr($permission->name, 0, 8) == 'client_s' ||
            substr($permission->name, 0, 8) == 'client_i' ||
            substr($permission->name, 0, 6) == 'sale_c' ||
            // substr($permission->name, 0, 6) == 'sale_s' ||
            substr($permission->name, 0, 11) == 'inventory_i' ||
            substr($permission->name, 0, 11) == 'inventory_s' ||
            substr($permission->name, 0, 5) == 'lot_i' ||
            substr($permission->name, 0, 5) == 'lot_s' ||
            (substr($permission->name, 0, 5) == 'debts' && substr($permission->name, 0, 7) != 'debts_d')
            ;
        });
        Role::findOrFail(3)->permissions()->sync($vendedor_permissions->pluck('id'));

        // Inventario
        $inventario_permissions = $permissions->filter(function($permission){
            return (substr($permission->name, 0, 9) == 'inventory' && substr($permission->name, 0, 11) != 'inventory_d')||
            (substr($permission->name, 0, 11) == 'to_discount' && substr($permission->name, 0, 13) != 'to_discount_d') ||
            substr($permission->name, 0, 3) == 'lot';
        });
        Role::findOrFail(4)->permissions()->sync($inventario_permissions->pluck('id'));

    }
}
