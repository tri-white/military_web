@extends('shared/layout')

@section('content')
<div class="container my-5">
    <div class="card mb-4">
        <img src="{{ $postAsk->photo ? asset(str_replace('public/', 'storage/', $postAsk->photo)) : asset('no-image.jpg') }}" class="card-img-top" alt="Listing Photo">
        <div class="card-body">
            <h5 class="card-title">{{ $postAsk->header }}</h5>
            <p class="card-text">{{ $postAsk->content }}</p>
            @php
            $category = App\Models\Category::where('id', $postAsk->category_id)->first();
            @endphp
            <p class="card-text">Category: {{ $category->name }}</p>
        </div>
    </div>

    <!-- Form for making propositions -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Make a Proposition</h5>
            <form method="POST" action="{{ route('ask-post-propose', ['postid' => $postAsk->id]) }}">
                @csrf
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" class="form-control">
                </div>
                <div class="form-group">
                    <label for="photo">Photo</label>
                    <input type="file" name="photo" id="photo" class="form-control">
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" class="form-control"></textarea>
                </div>
                <input type="hidden" name="post_ask_id" value="{{ $postAsk->id }}">
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <button type="submit" class="btn btn-primary">Submit Proposition</button>
            </form>
        </div>
    </div>

    <!-- List of propositions -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Propositions</h5>
            <ul>
                @foreach ($propositions as $proposition)
                    <li>
                        Price: ${{ $proposition->price }}
                        <br>
                        Message: {{ $proposition->message }}
                        <br>
                        <!-- Display the user's information here -->
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
