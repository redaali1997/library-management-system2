@extends('layouts.app')

@section('title', $book->title)

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">{{ __('app.order-sent') }}</div>
    @endif
    <div class="card" style="width: 100%;">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($book->images as $image)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ $image->path }}" class="d-block w-100">
                    </div>
                @endforeach
            </div>
            @if (count($book->images) > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            @endif
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $book->title }}</h5>
            <div class="d-flex justify-content-between">
                <h6 class="card-subtitle mb-2 text-muted">Added at: {{ $book->created_at->format('d-m-Y h:i A') }}</h6>
                <h6 class="card-subtitle mb-2 text-muted">Author: {{ $book->author }}</h6>
                <h6 class="card-subtitle mb-2 text-muted">ISBN (13): {{ $book->isbn }}</h6>
            </div>
            <p class="card-text">{{ $book->description }}</p>
            @if ($book->tags)
                <div class="my-2">
                    @foreach ($book->tags as $tag)
                        <span class="badge text-bg-dark">
                            <a href="{{ route('book.index') }}/?tag={{ $tag->name }}"
                                class="text-decoration-none text-white">{{ $tag->name }}</a>
                        </span>
                    @endforeach
                </div>
            @endif
            @auth
                @if (auth()->user()->getLastOrder($book->id, 1))
                    <form action="{{ route('order.delete', $book->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="btn btn-danger" style="width: 100%" value="{{ __('app.cancel-order') }}">
                    </form>
                @elseif(auth()->user()->getLastOrder($book->id, 2, 1))
                    <form action="{{ route('order.reverse', $book->id) }}" method="post">
                        @csrf
                        <input type="submit" class="btn btn-dark" style="width: 100%" value="{{ __('app.reverse-book') }}">
                    </form>
                @else
                    <form action="{{ route('order.create', $book->id) }}" method="post">
                        @csrf
                        <input type="submit" class="btn btn-primary" style="width: 100%" value="{{ __('app.borrow-book') }}">
                    </form>
                @endif
            @endauth
        </div>
    </div>
@endsection

@section('script')
    @auth
        @if (auth()->user()->getLastOrder($book->id, 1))
            <script defer>
                let orderId = {{ auth()->user()->getLastOrder($book->id, 1)->id }}
                window.Echo.channel(`orders.${orderId}`)
                    .listen('OrderStatusChanged', (e) => {
                        location.reload();
                    });
            </script>
        @endif
    @endauth
@endsection
