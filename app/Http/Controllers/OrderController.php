<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function create($book)
    {
        auth()->user()->books()->attach($book, ['type' => 'borrow']);

        session()->flash('success', 'The order has been sended.');

        return back();
    }

    public function delete($book)
    {
        auth()->user()->getLastOrder($book, 'pending')->delete();
        return back();
    }

    public function reverse($book)
    {
        auth()->user()->books()->attach($book, ['type' => 'reverse']);

        session()->flash('success', 'The order has been sended.');

        return back();
    }

    public function accept(Order $order)
    {
        $order->status = 'accepted';
        $order->save();

        return back();
    }

    public function confirm(Order $order)
    {
        // get accepted borrow order
        $previosOrder = Order::where('book_id', $order->book_id)
            ->where('user_id', $order->user_id)
            ->where('status', 'accepted')
            ->first();

        // change borrow order status
        $previosOrder->status = 'reversed';
        $previosOrder->save();

        // change reverse order status
        $order->status = 'reversed';
        $order->save();

        return back();
    }

    public function refuse(Order $order)
    {
        $order->status = 'refused';
        $order->save();

        return back();
    }
}
