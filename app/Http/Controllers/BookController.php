<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Tag;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function index()
    {
        $books = [];
        if (request()->tag) {
            $tag = Tag::where('name', request()->tag)->first();
            $books = $tag->books()->with(['images', 'tags'])->latest()->paginate(9)->withQueryString();
        } else {
            $books = Book::with(['images', 'tags'])->latest()->paginate(9);
        }

        return view('books.index', compact('books'));
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('books.create', compact('tags'));
    }

    public function store(Request $request)
    {
        // validation
        $data = $request->validate([
            'en-title' => ['required', 'max:255'],
            'en-description' => ['required', 'max:1000'],
            'ar-title' => ['max:255'],
            'ar-description' => ['max:1000'],
            'author' => ['required', 'max:255'],
            'isbn' => ['required', 'size:13', 'unique:books,isbn'],
        ]);

        // create a book
        $book = Book::create([
            'title' => [
                'en' => $data['en-title'],
                'ar' => $data['ar-title']
            ],
            'description' => [
                'en' => $data['en-description'],
                'ar' => $data['ar-description'],
            ],
            'author' => $data['author'],
            'isbn' => $data['isbn']
        ]);

        if ($request->has('tags')) {
            foreach ($request->tags as $tag) {
                $book->tags()->attach($tag);
            }
        }
        // store images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('images');
                    $book->images()->create([
                        'path' => $path
                    ]);
                }
            };
        } else {
            $faker = Factory::create();
            $book->images()->create([
                'path' => $faker->imageUrl(900, 300)
            ]);
        }

        // flash message
        session()->flash('success', 'Book has been created');

        // redirect to books
        return redirect()->route('book.index');
    }
}
