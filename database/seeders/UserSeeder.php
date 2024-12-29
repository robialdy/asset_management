<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'department' => 'IT',
            'email' => 'admin@gmail.com',
            'full_name' => 'Muhammad Fachri Robialdy',
            'phone' => '6285179902057',
            'role' => 'Admin', // Role Admin
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // User::factory()->count(100)->create();
    }
}
