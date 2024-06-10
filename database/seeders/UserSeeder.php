<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'user1',
            'email' => 'user1@example.com',
            'password' => bcrypt('user1'),
        ]);

        User::create([
            'name' => 'user2',
            'email' => 'user2@example.com',
            'password' => bcrypt('user2'),
        ]);
    }
}
