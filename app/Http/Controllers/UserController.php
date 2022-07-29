<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $books = auth()->user()->books()->wherePivot('status', 'accepted')->get();

        return view('user.dashboard', compact('books'));
    }
}