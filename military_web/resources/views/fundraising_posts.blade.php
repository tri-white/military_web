@extends('shared/layout')

@section('content')
<h1 class="text-center mt-5"> Збори коштів військовим </h1>
<div class="container my-5">
    <div class="card-deck"> <!-- Use card-deck class to ensure proper alignment -->
        @foreach($fundraisingPosts as $post)
        <a href="{{ route('fundraising-post', ['postid' => $post->id]) }}" class="card-link" style="text-decoration: none; color: inherit;">
            <div class="col-8 mx-auto">
                <div class="card mb-5" style="border: 1px solid #ccc; margin: 10px; border-radius: 10px; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2); padding: 10px 20px;"> <!-- Reduced vertical padding -->
                    <div class="card-body">
                        <h5 class="card-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
     
                                {{ $post->purpose }}
           
                        </h5>
                        <p class="card-text">{{ $post->content }}</p>
                    </div>
                    <div class="progress" style="margin-left: 10px; margin-right: 10px;"> <!-- Adjust margin for the progress bar -->
                        <div class="progress-bar" role="progressbar" style="width: {{ ($post->current_amount / $post->goal_amount) * 100 }}%;" aria-valuenow="{{ $post->current_amount }}" aria-valuemin="0" aria-valuemax="{{ $post->goal_amount }}">
                            <div class="text-center" style="color: #fff;">{{ $post->current_amount }} / {{ $post->goal_amount }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection
