@extends('shared/layout')

@section('content')
<h1 class="text-center mt-5"> Збори коштів військовим </h1>
<div class="container my-5">
    <div class="card-deck"> <!-- Use card-deck class to ensure proper alignment -->
        @foreach($fundraisingPosts as $post)
        <a href="{{ route('fundraising-post', ['postid' => $post->id]) }}" class="card-link" style="text-decoration: none; color: inherit;">
            <div class="col-8 mx-auto">
                <div class="card mb-4" style="border: 1px solid #ccc; margin: 10px; border-radius: 10px; box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2); padding: 10px 20px; position: relative;"> <!-- Add position: relative -->
                    <div class="card-body">
                        <h5 class="card-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $post->purpose }}
                        </h5>
                        <p class="card-text">{{ $post->content }}</p>
                    </div>
                    <div class="progress" style="margin-left: 10px; margin-right: 10px;"> <!-- Adjust margin for the progress bar -->
                        @php
                        $progress = ($post->current_amount / $post->goal_amount) * 100;
                        @endphp
                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $post->current_amount }}" aria-valuemin="0" aria-valuemax="{{ $post->goal_amount }}">
                            {{ number_format($progress, 0) }}%
                        </div>
                        <div class="text-center" style="color: #000; position: absolute; left: 50%; bottom: 25px; transform: translateX(-50%); font-weight: bold;">
                            {{ number_format($post->current_amount, 0) }} / {{ number_format($post->goal_amount, 0) }}
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection
