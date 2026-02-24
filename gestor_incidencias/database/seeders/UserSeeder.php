<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;

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