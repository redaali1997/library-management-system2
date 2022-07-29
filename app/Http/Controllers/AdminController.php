<?php

namespace App\Http\Controllers;

use App\Models\BookUser;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showPanel()
    {
        $pendingOrders = BookUser::where('status', 'pending')->get();
        return view('admin.panel', compact('pendingOrders'));
    }
}
