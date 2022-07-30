@extends('layouts.app')

@section('title', 'Add Book')

@section('content')
    <div class="card p-4">
        <h2>{{ __('app.add-tag') }}</h2>
        <form action="{{ route('tag.create') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-6">
                    <input class="form-control" type="text" name="tag_name" placeholder="{{ __('app.add-tag') }}">
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-primary">{{ __('app.submit') }}</button>
                </div>
            </div>
        </form>
        <hr>
        <h1>{{ __('app.add-book') }}</h1>
        <x-errors></x-errors>
        <select class="form-select language" style="width: 20%">
            <option value="ar">{{ __('app.arabic') }}</option>
            <option value="en" selected>{{ __('app.english') }}</option>
        </select>
        <form action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="en-fields">
                <div class="form-group my-2">
                    <label for="en-title" class="form-label">{{ __('app.book-title') }} <span
                            style="color:red;">({{ __('app.required') }})</span></label>
                    <input required value="{{ old('en-title') }}" name="en-title" type="text" class="form-control"
                        placeholder="{{ __('app.en-book-title') }}">
                </div>
                <div class="form-group my-2">
                    <label for="en-description" class="form-label">{{ __('app.book-description') }} <span
                            style="color:red;">({{ __('app.required') }})</span></label>
                    <textarea required name="en-description" id="en-description" cols="30" class="form-control"
                        placeholder="{{ __('app.en-book-description') }}">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="ar-fields d-none">
                <div class="form-group my-2">
                    <label for="ar-title" class="form-label">{{ __('app.book-title') }}</label>
                    <input value="{{ old('ar-title') }}" name="ar-title" type="text" class="form-control"
                        placeholder="{{ __('app.ar-book-title') }}">
                </div>
                <div class="form-group my-2">
                    <label for="ar-description" class="form-label">{{ __('app.book-description') }}</label>
                    <textarea name="ar-description" id="ar-description" cols="30" class="form-control"
                        placeholder="{{ __('app.ar-book-description') }}">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group my-2">
                        <label for="author" class="form-label">{{ __('app.book-author') }} <span
                                style="color:red;">({{ __('app.required') }})</span></label>
                        <input required value="{{ old('author') }}" name="author" type="text" class="form-control"
                            placeholder="{{ __('app.book-author') }}">
                    </div>
                </div>
                <div class="col-6">

                    <div class="form-group my-2">
                        <label for="isbn" class="form-label">ISBN(13) <span
                                style="color:red;">({{ __('app.required') }})</span></label>
                        <input required value="{{ old('isbn') }}" name="isbn" type="text" class="form-control"
                            placeholder="ISBN(13)">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="images" class="form-label">{{ __('app.images') }}</label>
                <input class="form-control" type="file" name="images[]" id="images" multiple>
            </div>
            <div class="form-group my-2">
                <label class="form-label">{{ __('app.tags') }}</label>
                @foreach ($tags as $tag)
                    <div class="form-check d-inline-block">
                        <input class="form-check-input" name="tags[]" type="checkbox" value="{{ $tag->id }}"
                            id="flexCheckChecked">{{ $tag->name }}
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary my-2">{{ __('app.submit') }}</button>
        </form>

    </div>
@endsection

@section('script')
    <script src="{{ asset('js/script.js') }}"></script>
@endsection
