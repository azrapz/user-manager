<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Permission::create([
            'name' => 'user_index'
        ]);

        Permission::create([
            'name' => 'user_edit'
        ]);

        Permission::create([
            'name' => 'user_create'
        ]);

        Permission::create([
            'name' => 'user_delete'
        ]);

        Permission::create([
            'name' => 'user_assign_role'
        ]);

        Permission::create([
            'name' => 'user_get_data'
        ]);
    }
}
