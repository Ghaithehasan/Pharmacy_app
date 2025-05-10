<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayOfPermissionsNames = [
            'add product' , 'export invoices'
        ];

        $permissions = collect($arrayOfPermissionsNames)->map(function($permission){
            return ['name' => $permission , 'guard_name' => 'web'];
        });

        Permission::insert($permissions->toArray());

        $role = Role::create(['name' => 'admin'])->givePermissionTo($arrayOfPermissionsNames);

    }
}
