<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name'=>'Admin',
                'desc'=>'Usuario Administrador del sistema, con capacidad de realizar cualquier acción.'
            ],
            [
                'name'=>'Supervisor',
                'desc'=>'Usuario designado para gestionar usuarios, monitorear el inventario, gestionar clientes, monitorear deudas, ventas, así como reversar éstas acciones realizadas por otros usuarios, además puede ver los reportes en caso de también tener cuenta premium.'
            ],
            [
                'name'=>'Vendedor',
                'desc'=>'Usuario capaz de crear, listar y ver la información de los clientes, realizar ventas a crédito, listar inventario y crear y visualizar ventas a crédito.'
            ],
            [
                'name'=>'Inventario',
                'desc'=>'Usuario designado para gestionar el inventario.'
            ],
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role['name'],
                'description' => $role['desc']
            ]);
        }
    }
}
