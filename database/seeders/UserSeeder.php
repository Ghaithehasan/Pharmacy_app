<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'admin_name',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123123'),
            'gender' => 'male',
            'phone' => '0932312312' ,
            // 'role' => 'admin'
        ]);

        $user->assignRole('admin');
    }
}
