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
        $type = Type::where('title', 'borrow')->select('id')->first()->id;
        auth()->user()->books()->attach($book, ['type_id' => $type]);

        session()->flash('success', 'The order has been sended.');

        NewOrderEvent::dispatch();

        return back();
    }

    public function delete($book)
    {
        auth()->user()->getLastOrder($book, 'pending')->delete();

        NewOrderEvent::dispatch();

        return back();
    }

    public function reverse($book)
    {
        $type = Type::where('title', 'reverse')->select('id')->first()->id;

        auth()->user()->books()->attach($book, ['type_id' => $type]);

        session()->flash('success', 'The order has been sended.');

        NewOrderEvent::dispatch();


        return back();
    }

    public function accept(Order $order)
    {
        $status = Status::where('title', 'accepted')->select('id')->first()->id;

        $order->status_id = $status;
        $order->save();

        OrderStatusChanged::dispatch($order);

        return back();
    }

    public function confirm(Order $order)
    {

        $acceptedStatus = Status::where('title', 'accepted')->select('id')->first();
        $reversedStatus = Status::where('title', 'reversed')->select('id')->first();


        // get accepted borrow order
        $previosOrder = Order::where('book_id', $order->book_id)
            ->where('user_id', $order->user_id)
            ->where('status_id', $acceptedStatus->id)
            ->first();

        // change borrow order status
        $previosOrder->status_id = $reversedStatus->id;
        $previosOrder->save();

        // change reverse order status
        $order->status_id = $reversedStatus->id;
        $order->save();

        OrderStatusChanged::dispatch($order);

        return back();
    }

    public function refuse(Order $order)
    {
        $refusedStatus = Status::where('title', 'refused')->select('id')->first();

        $order->status_id = $refusedStatus->id;
        $order->save();

        OrderStatusChanged::dispatch($order);


        return back();
    }
}
