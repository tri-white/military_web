@extends('shared/layout')

@section('content')
<style>
    .text-justify {
        text-align: justify;
        text-justify: inter-word;
    }
</style>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title fs-3 text-justify">{{ $fundraisingPost->purpose }}</h1>
                    <p class="card-text">Вже зібрано: {{ $fundraisingPost->current_amount }} / {{ $fundraisingPost->goal_amount }} грн.</p>

                    <div class="progress my-5">
                        <div class="progress-bar" role="progressbar" style="width: {{ ($fundraisingPost->current_amount / $fundraisingPost->goal_amount) * 100 }}%;">
                            {{ number_format(($fundraisingPost->current_amount / $fundraisingPost->goal_amount) * 100, 2) }}%
                        </div>
                    </div>

                    @php
                    $user = App\Models\User::where('id', $fundraisingPost->user_id)->first();
                    @endphp
                    <hr>
                    <a href="{{ route('profile', $user->id) }}">
                        <p>Повне ім'я: {{ $user->name }}</p>
                        <p>Електронна скринька: {{ $user->email }}</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Здійсніть пожертву</h2>
                    <form method="POST" action="{{ route('fundraising-post-donate', ['postid' => $fundraisingPost->id]) }}">
                        @csrf
                        <div class="form-group">
                            <label for="donationAmount">Введіть суму:</label>
                            <input type="number" name="donationAmount" id="donationAmount" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Сплатити</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
