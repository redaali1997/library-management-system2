<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = Book::factory(50)->hasImages(3)->create();

        $books->map(function ($book) {
            $book->tags()->attach([rand(1, 6), rand(1, 6)]);
        });
    }
}
