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
            ['name'=>'configuration_index', 'desc'=>'Permiso de visualización de ventana de configuración.'],
            ['name'=>'configuration_create', 'desc'=>'Permiso de visualización de ventana de crear configuración.'],
            ['name'=>'configuration_show', 'desc'=>'Permiso de visualización de ventana para mostrar configuración.'],
            ['name'=>'configuration_edit', 'desc'=>'Permiso de visualización de ventana de edición de datos de configuración.'],
            ['name'=>'configuration_destroy', 'desc'=>'Permiso para deshabilitar/habilitar configuración.'],

            ['name'=>'permission_index', 'desc'=>'Permiso de visualización de ventana de visualización de permisos.'],
            ['name'=>'permission_create', 'desc'=>'Permiso de visualización de ventana para crear permisos.'],
            ['name'=>'permission_show', 'desc'=>'Permiso de visualización de ventana para mostrar información del permiso.'],
            ['name'=>'permission_edit', 'desc'=>'Permiso de visualización de ventana de edición del permiso.'],
            ['name'=>'permission_destroy', 'desc'=>'Permiso para deshabilitar/habilitar permiso.'],

            ['name'=>'role_index', 'desc'=>'Permiso de visualización de ventana de lista de roles.'],
            ['name'=>'role_create', 'desc'=>'Permiso de visualización de ventana de creación de roles.'],
            ['name'=>'role_show', 'desc'=>'Permiso de visualización de ventana de información completa de los roles.'],
            ['name'=>'role_edit', 'desc'=>'Permiso de visualización de ventana de edición de los datos de los roles.'],
            ['name'=>'role_destroy', 'desc'=>'Permiso para deshabilitar/habilitar rol.'],

            ['name'=>'user_indexUsers', 'desc'=>'Permiso de visualización de ventana de lista de usuarios'],
            ['name'=>'user_createUser', 'desc'=>'Permiso de visualización de ventana de creación de usuarios.'],
            ['name'=>'user_showUser', 'desc'=>'Permiso de visualización de ventana para mostrar datos detallados de usuario.'],
            ['name'=>'user_editUser', 'desc'=>'Permiso de visualización de ventana de edición de datos de usuario.'],
            ['name'=>'user_statusUser', 'desc'=>'Permiso para deshabilitar/habilitar usuario.'],

            ['name'=>'inventory_index', 'desc'=>'Permiso de visualización de ventana de lista de productos en inventario.'],
            ['name'=>'inventory_create', 'desc'=>'Permiso de visualización de ventana de creación de producto para el inventario.'],
            ['name'=>'inventory_show', 'desc'=>'Permiso de visualización de ventana de información detallada de producto.'],
            ['name'=>'inventory_edit', 'desc'=>'Permiso de visualización de ventana de edición de información de producto en inventario.'],
            ['name'=>'inventory_destroy', 'desc'=>'Permiso para deshabilitar/habilitar producto del inventario.'],

            ['name'=>'client_index', 'desc'=>'Permiso de visualización de ventana de lista de clientes.'],
            ['name'=>'client_create', 'desc'=>'Permiso de visualización de ventana de creación de clientes.'],
            ['name'=>'client_show', 'desc'=>'Permiso de visualización de ventana de información del cliente.'],
            ['name'=>'client_edit', 'desc'=>'Permiso de visualización de ventana de edición de información del cliente.'],
            ['name'=>'client_destroy', 'desc'=>'Permiso para deshabilitar/habilitar cliente.'],

            ['name'=>'sale_index', 'desc'=>'Permiso de visualización de ventana de ventas realizadas.'],
            ['name'=>'sale_create', 'desc'=>'Permiso de visualización de ventana de registro de venta.'],
            ['name'=>'sale_show', 'desc'=>'Permiso de visualización de ventana para mostrar la información de la venta.'],
            ['name'=>'sale_destroy', 'desc'=>'Permiso para anular venta.'],

            ['name'=>'report_index', 'desc'=>'Permiso de visualización de ventana de reportes.'],
            ['name'=>'report_show', 'desc'=>'Permiso de visualización de ventana de detalles de reportes.'],

            ['name'=>'debts_index', 'desc'=>'Permiso de visualización de ventana de lista de deudas.'],
            ['name'=>'debts_show', 'desc'=>'Permiso de visualización de ventana de información completa de la deuda.'],
            ['name'=>'debts_pay', 'desc'=>'Permiso de visualización de ventana de pago de la deuda.'],
            ['name'=>'debts_destroy', 'desc'=>'Permiso para anular deuda.'],

            ['name'=>'lot_index', 'desc'=>'Permiso de visualización de ventana de lista de lotes.'],
            ['name'=>'lot_create', 'desc'=>'Permiso de visualización de ventana de creación de lote nuevo.'],
            ['name'=>'lot_show', 'desc'=>'Permiso de visualización de ventana para mostrar información del lote.'],
            ['name'=>'lot_destroy', 'desc'=>'Permiso para deshabilitar/habilitar lote.'],

            ['name'=>'to_discount_index', 'desc'=>'Permiso de visualización de ventana de descuento del inventario.'],
            ['name'=>'to_discount_create', 'desc'=>'Permiso de visualización de ventana de descuento del inventario.'],
            ['name'=>'to_discount_show', 'desc'=>'Permiso de visualización de ventana de descuento del inventario.'],
            ['name'=>'to_discount_destroy', 'desc'=>'Permiso para anular descuento de inventario.'],


        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'description' => $permission['desc']
            ]);
        }
    }
}
