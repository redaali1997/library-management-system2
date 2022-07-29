<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create(['name' => 'PHP']);
        Tag::create(['name' => 'Laravel']);
        Tag::create(['name' => 'Vue']);
        Tag::create(['name' => 'Javascript']);
        Tag::create(['name' => 'CSS']);
        Tag::create(['name' => 'HTML']);
    }
}
