<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminExists = DB::table('users')->where('username', 'admin')->exists();

        if (!$adminExists) {
            DB::table('users')->insert([
                'role_id' => 1, // admin role
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'), // hashed password
                'created_at' => now()
            ]);

            $this->command->info('Admin user telah dibuat');
        } else {
            $this->command->info('Admin user sudah');
        }
    }
}
