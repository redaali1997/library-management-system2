<?php

namespace App\Http\Controllers;

use App\Models\Order;

class AdminController extends Controller
{
    public function showPanel()
    {
        $pendingOrders = Order::where('status', 'pending')->get();
        return view('admin.panel', compact('pendingOrders'));
    }
}
