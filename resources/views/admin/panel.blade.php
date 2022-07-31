@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
    <div class="card p-4">
        <a href="{{ route('book.create') }}" class="btn btn-primary">{{ __('app.add-book') }}</a>

        <div class="my-4">
            <h1>{{ __('app.pending-orders') }}</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">{{ __('app.book-title') }}</th>
                        <th scope="col">{{ __('app.user') }}</th>
                        <th scope="col">{{ __('app.order-type') }}</th>
                        <th scope="col">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendingOrders as $order)
                        <tr>
                            <td><a href="{{ route('book.show', $order->book_id) }}"
                                    target="_blank">{{ $order->book->title }}</a>
                            </td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ __('app.' . $order->type->title) }}</td>
                            <td>
                                @if ($order->type_id == $reverseType->id)
                                    <form action="{{ route('order.confirm', $order->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-dark">{{ __('app.confirm') }}</button>
                                    </form>
                                @else
                                    <div class="d-inline-block">
                                        <form action="{{ route('order.accept', $order->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary">{{ __('app.accept') }}</button>
                                        </form>
                                    </div>
                                    <div class="d-inline-block">

                                        <form action="{{ route('order.refuse', $order->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger">{{ __('app.refuse') }}</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script defer>
        window.Echo.channel(`new-order`)
            .listen('NewOrderEvent', (e) => {
                location.reload();
            });
    </script>
@endsection
