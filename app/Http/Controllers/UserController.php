<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Type;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $acceptedStatus = Status::where('title', 'accepted')->select('id')->first();
        $pendingStatus = Status::where('title', 'pending')->select('id')->first();
        $borrowStatus = Type::where('title', 'borrow')->select('id')->first();

        $books = auth()->user()->books()
            ->wherePivot('status_id', $acceptedStatus->id)
            ->latest()
            ->get();

        $pendingOrders = auth()->user()->books()
            ->wherePivot('status_id', $pendingStatus->id)
            ->wherePivot('type_id', $borrowStatus->id)
            ->latest()
            ->get();

        return view('user.dashboard', compact('books', 'pendingOrders'));
    }
}
