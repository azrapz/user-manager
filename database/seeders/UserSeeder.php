<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $admin = User::create([
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@gmail.com',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'status' => 'active'
            ]);

            $user = User::create([
                'first_name' => 'User',
                'last_name' => 'User',
                'email' => 'user@gmail.com',
                'username' => 'user',
                'password' => Hash::make('user123'),
                'status' => 'active'
            ]);

            $admin->assignRole([Role::where('name', 'Admin')->first()->id]);
            $user->assignRole([Role::where('name','User')->first()->id]);
    }
}
