<?php

namespace App\Http\Controllers;

use App\Events\NewOrderEvent;
use App\Events\OrderStatusChanged;
use App\Models\Order;
use App\Models\Status;
use App\Models\Type;

class OrderController extends Controller
{
    public function create($book)
    {
        auth()->user()->books()->attach($book, ['type_id' => Type::BORROW]);

        session()->flash('success', 'The order has been sended.');

        NewOrderEvent::dispatch();

        return back();
    }

    public function delete($book)
    {
        auth()->user()->getLastOrder($book, Status::PENDING)->delete();

        NewOrderEvent::dispatch();

        return back();
    }

    public function reverse($book)
    {

        auth()->user()->books()->attach($book, ['type_id' => Type::REVERSE]);

        session()->flash('success', 'The order has been sended.');

        NewOrderEvent::dispatch();


        return back();
    }

    public function accept(Order $order)
    {
        $status = Status::where('title', 'accepted')->select('id')->first()->id;

        $order->status_id = Status::ACCEPTED;
        $order->save();

        OrderStatusChanged::dispatch($order);

        return back();
    }

    public function confirm(Order $order)
    {

        // get accepted borrow order
        $previosOrder = Order::where('book_id', $order->book_id)
            ->where('user_id', $order->user_id)
            ->where('status_id', Status::ACCEPTED)
            ->first();

        // change borrow order status
        $previosOrder->status_id = Status::REVERSED;
        $previosOrder->save();

        // change reverse order status
        $order->status_id = Status::REVERSED;
        $order->save();

        OrderStatusChanged::dispatch($order);

        return back();
    }

    public function refuse(Order $order)
    {
        $order->status_id = Status::REFUSED;
        $order->save();

        OrderStatusChanged::dispatch($order);


        return back();
    }
}
