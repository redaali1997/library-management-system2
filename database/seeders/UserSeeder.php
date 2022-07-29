<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Reda Ali',
            'email' => 'reda@example.com',
            'password' => bcrypt('password'),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'Mohamed Salem',
            'email' => 'salem@example.com',
            'password' => bcrypt('password'),
            'role_id' => 2
        ]);

        User::factory(5)->create();
    }
}
