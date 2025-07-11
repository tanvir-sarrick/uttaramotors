<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RollPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create Role
        $roleSuperAdmin = Role::create(['name' => 'Superadmin', 'guard_name' => 'web']);
        //$roleAdmin      = Role::create(['name' => 'Admin', 'guard_name' => 'admin']);

        //Permission list as Array
        $permissions = [
            [
                //Role Permission
                'group_name'    => 'role',
                'permissions'   => [
                    'role.manage',
                    'role.create',
                    'role.edit',
                    'role.delete',
                ]
            ],
            [
                //permission Permission
                'group_name'    => 'permission',
                'permissions'   => [
                    'permission.manage',
                    'permission.create',
                    'permission.edit',
                    'permission.delete',
                ]
            ],
            [
                //User Permission
                'group_name'    => 'user',
                'permissions'   => [
                    'user.manage',
                    'user.create',
                    'user.edit',
                    'user.delete',
                ]
            ],
            [
                //dealer Permission
                'group_name'    => 'dealer',
                'permissions'   => [
                    'dealer.manage',
                    'dealer.create',
                    'dealer.edit',
                    'dealer.delete',
                ]
            ],
            [
                //appsetup Permission
                'group_name'    => 'appsetup',
                'permissions'   => [
                    'appsetup.manage',
                    'appsetup.edit',
                ]
            ],
            [
                //appsetup Permission
                'group_name'    => 'invoice',
                'permissions'   => [
                    'invoice.manage',
                    'invoice.import',
                    'invoice.print',
                    'invoice.delete',
                ]
            ],
        ];

        //Create And Assign Permission
        //$permission = Permission::create(['name' => 'blog.manage']);
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                //Create Permission
                $permission = Permission::create([
                    'name' => $permissions[$i]['permissions'][$j],
                    'group_name' => $permissionGroup,
                    // 'guard_name' => 'admin'
                ]);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }
    }
}
