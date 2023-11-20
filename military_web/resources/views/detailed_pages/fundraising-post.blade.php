@extends('shared/layout')

@section('content')
@push('css')
<style>
    .text-justify {
        text-align: justify;
        text-justify: inter-word;
    }
</style>
@endpush

<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                @if(Auth::check())
                    @if(Auth::user()->role_id==3 || Auth::user()->id==$fundraisingPost->user_id)
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('edit-fund', ['postid' => $fundraisingPost->id]) }}" class="text-dark me-4">
                            <i class="fas fa-edit"></i> Редагувати
                        </a>
                        @if(Auth::user()->id==$fundraisingPost->user_id)
                        <form action="{{ route('remove-fund', ['postid' => $fundraisingPost->id, 'userid'=>Auth::user()->id]) }}" method="POST" onsubmit="return confirm('Ви впевнені, що хочете видалити цей запис?');">
                            @csrf
                            <button type="submit" class="text-danger" style="background: none; border: none; cursor: pointer;">
                                <i class="fas fa-trash-alt"></i> Видалити
                            </button>
                        </form>
                        @else
                        <button type="button" class="text-danger" onclick="location.href='{{ route('remove-fundraising-form', ['postid' => $fundraisingPost->id, 'userid' => Auth::user()->id]) }}'">
                            <i class="fas fa-trash-alt"></i> Видалити
                        </button>
                        @endif
                    </div>
                    
                    @endif
                @endif
                    <h1 class="card-title fs-3 text-justify">{{ $fundraisingPost->purpose }}</h1>
                    <p class="card-text">Вже зібрано: {{ $fundraisingPost->current_amount }} / {{ $fundraisingPost->goal_amount }} грн.</p>

                    <div class="progress my-5">
                        <div class="progress-bar" role="progressbar" style="width: {{ ($fundraisingPost->current_amount / $fundraisingPost->goal_amount) * 100 }}%; background-color: #B5C186;">
                            {{ number_format(($fundraisingPost->current_amount / $fundraisingPost->goal_amount) * 100, 2) }}%
                        </div>
                    </div>

                    <div class="row d-flex justify-content-between">
                        <div class="col-6">
                            Дата створення: {{ $fundraisingPost->created_at->format('d/m/Y') }}
                        </div>
                        <div class="col-6 text-end">
                            @php
                            $name = App\Models\Category::where('id',$fundraisingPost->category_id)->first()->name;
                            @endphp
                            {{ $name }}

                        </div>
                    </div>
                   
                    @php
                    $user = App\Models\User::where('id', $fundraisingPost->user_id)->first();
                    @endphp
                    <hr>
                    <h3 class="text-center">Збирач коштів</h3>
                        <p>
                    
                            Імя: <a href="{{ route('profile', $user->id) }}">
                                {{ $user->name }} 
</a>
                            </p>
                        <p>Ранг: {{ $user->military_rank }} </p>
                        <p>Склад: {{ $user->composition }}</p>
                        <p>Профіль: {{ $user->profile }}</p>
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
                            <input type="number" name="donationAmount" id="donationAmount" class="form-control" min="1">
                        </div>
                        <button type="submit" class="btn text-white mt-3" style="background-color: #B5C186;">Допомогти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
