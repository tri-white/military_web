@extends('shared/layout')

@section('content')
<div class="container my-5">
    <div class="card mb-4">
        <img src="{{ $postBid->photo ? asset(str_replace('public/', 'storage/', $postBid->photo)) : asset('no-image.jpg') }}" class="card-img-top" alt="Listing Photo">
        <div class="card-body">
            <h5 class="card-title">{{ $postBid->header }}</h5>
            <p class="card-text">{{ $postBid->content }}</p>
            <hr>
            <a href="{{ route('profile', $user->id) }}">
            <p class="card-text">Повне ім'я: {{ $user->name }}</p>
            <p class="card-text">Електронна скринька: {{ $user->email }}</p>
</a>
<hr>
            <form method="POST" action="{{ route('lot-post-bid', ['postid' => $postBid->id]) }}">
                @csrf
                <div class="form-group">
                    <label for="bidAmount">Введіть свою ставку:</label>
                    <input type="number" name="bidAmount" id="bidAmount" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Поставити</button>
            </form>
        </div>
    </div>
</div>
@endsection
