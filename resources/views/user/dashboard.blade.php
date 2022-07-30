@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2>{{ __('app.Borrowed Books') }}</h2>
    <div class="row">
        @forelse ($books as $book)
            <div class="col-md-6 col-lg-4 my-2">
                <div class="card" style="width: 18rem;">
                    @if (count($book->images))
                        <img src="{{ $book->images()->first()->path }}" class="card-img-top" alt="{{ $book->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text">{{ substr($book->description, 0, 50) }}...</p>
                        <div class="my-2">
                            @foreach ($book->tags as $tag)
                                <span class="badge text-bg-dark">
                                    <a href="{{ route('book.index') }}/?tag={{ $tag->name }}"
                                        class="text-decoration-none text-white">{{ $tag->name }}</a>
                                </span>
                            @endforeach
                        </div>
                        <a href="{{ route('book.show', $book->id) }}" class="btn btn-primary">{{ __('app.show-book') }}</a>
                    </div>
                </div>
            </div>
        @empty
            <h4>{{ __('app.empty-book') }}</h4>
        @endforelse
    </div>
    <hr>
    <h2>{{ __('app.pending-orders') }}</h2>
    <div class="row">
        @forelse ($pendingOrders as $book)
            <div class="col-md-6 col-lg-4 my-2">
                <div class="card" style="width: 18rem;">
                    @if (count($book->images))
                        <img src="{{ $book->images()->first()->path }}" class="card-img-top" alt="{{ $book->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text">{{ substr($book->description, 0, 50) }}...</p>
                        <div class="my-2">
                            @foreach ($book->tags as $tag)
                                <span class="badge text-bg-dark">
                                    <a href="{{ route('book.index') }}/?tag={{ $tag->name }}"
                                        class="text-decoration-none text-white">{{ $tag->name }}</a>
                                </span>
                            @endforeach
                        </div>
                        <a href="{{ route('book.show', $book->id) }}"
                            class="btn btn-primary">{{ __('app.show-book') }}</a>
                    </div>
                </div>
            </div>
        @empty
            <h4>{{ __('app.pending-book') }}</h4>
        @endforelse
    </div>
@endsection
