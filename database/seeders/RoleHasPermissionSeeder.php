<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \DB::table('role_has_permissions')->insert([
            [
                'role_id' => Role::where(['name' => 'Admin'])->first()->id,
                'permission_id' => Permission::where(['name'=>'user_index'])->first()->id
            ],
            [
                'role_id' => Role::where(['name' => 'Admin'])->first()->id,
                'permission_id' => Permission::where(['name' => 'user_create'])->first()->id
            ],
            [
                'role_id' => Role::where(['name' => 'Admin'])->first()->id,
                'permission_id' => Permission::where(['name' => 'user_edit'])->first()->id
            ],
            [
                'role_id' => Role::where(['name' => 'Admin'])->first()->id,
                'permission_id' => Permission::where(['name' => 'user_delete'])->first()->id
            ],
            [
                'role_id' => Role::where(['name' => 'Admin'])->first()->id,
                'permission_id' => Permission::where(['name' => 'user_assign_role'])->first()->id
            ],
            [
                'role_id' => Role::where(['name' => 'Admin'])->first()->id,
                'permission_id' => Permission::where(['name' => 'user_get_data'])->first()->id
            ]

        ]);
    }
}
