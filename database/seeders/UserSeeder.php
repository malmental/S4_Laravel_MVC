<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'salem@telsur.cl'],
            ['name' => 'Salem', 'password' => bcrypt('password')]
        );

        User::firstOrCreate(
            ['email' => 'malmental@telsur.cl'],
            ['name' => 'Malo Mentalo', 'password' => bcrypt('password')]
        );

        User::firstOrCreate(
            ['email' => 'dungeongoblin@telsur.cl'],
            ['name' => 'Dungeon Goblin', 'password' => bcrypt('password')]
        );
    }
}
