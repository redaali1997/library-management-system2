<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Status;
use App\Models\Type;

class AdminController extends Controller
{
    public function showPanel()
    {
        $status = Status::where('title', 'pending')->select('id')->first();
        $reverseType = Type::where('title', 'reverse')->select('id')->first();
        $pendingOrders = Order::with(['type', 'status'])->where('status_id', $status->id)->get();
        return view('admin.panel', compact('pendingOrders', 'reverseType'));
    }
}
