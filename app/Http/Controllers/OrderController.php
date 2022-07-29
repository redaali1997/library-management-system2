<?php

namespace App\Http\Controllers;

use App\Models\BookUser;

class OrderController extends Controller
{
    public function create($book)
    {
        auth()->user()->books()->attach($book, ['type' => 'borrow']);

        return back();
    }

    public function delete($book)
    {
        $lastOrder = auth()->user()->getLastOrder($book, 'pending');
        if ($lastOrder) {
            if ($lastOrder->pivot->type == 'reverse') {
                BookUser::where([
                    'book_id' => $lastOrder->pivot->book_id,
                    'user_id' => $lastOrder->pivot->user_id,
                    'type' => 'reverse',
                    'status' => 'pending'
                ])->delete();
            } else {
                auth()->user()->books()->detach($book);
            }

            return back();
        }
    }

    public function reverse($book)
    {
        auth()->user()->books()->attach($book, ['type' => 'reverse']);

        session()->flash('success', 'The order has been sended.');

        return back();
    }

    public function accept(BookUser $order)
    {
        $order->update([
            'status' => 'accepted'
        ]);
        return back();
    }

    public function confirm(BookUser $order)
    {
        $previousOrder = BookUser::where([
            'book_id' => $order->book_id,
            'user_id' => $order->user_id,
            'status' => 'accepted'
        ])->latest()->first();
        $previousOrder->update([
            'status' => 'reversed'
        ]);

        $order->update([
            'status' => 'reversed'
        ]);
        return back();
    }

    public function refuse(BookUser $order)
    {
        $order->update([
            'status' => 'refused'
        ]);

        return back();
    }
}
