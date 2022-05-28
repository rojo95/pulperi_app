<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'configuration_index',
            'configuration_create',
            'configuration_show',
            'configuration_edit',
            'configuration_destroy',

            'permission_index',
            'permission_create',
            'permission_show',
            'permission_edit',
            'permission_destroy',

            'role_index',
            'role_create',
            'role_show',
            'role_edit',
            'role_destroy',

            'user_indexUsers',
            'user_createUser',
            'user_showUser',
            'user_editUser',
            'user_statusUser',

            'inventory_index',
            'inventory_create',
            'inventory_show',
            'inventory_edit',
            'inventory_destroy',

            'client_index',
            'client_create',
            'client_show',
            'client_edit',
            'client_destroy',

            'sale_index',
            'sale_create',
            'sale_show',
            'sale_destroy',

            'report_index',
            'report_show',

            'debts_index',
            'debts_show',
            'debts_pay',
            'debts_destroy',

            'lot_index',
            'lot_create',
            'lot_show',
            'lot_destroy',

            'to_discount_index',
            'to_discount_create',
            'to_discount_show',
            'to_discount_destroy',

            'config_index',
            'config_create',
            'config_show',
            'config_edit',
            'config_destroy',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }
    }
}
