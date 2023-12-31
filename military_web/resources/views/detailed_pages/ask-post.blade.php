@extends('shared/layout')

@section('content')
@php
    $propositionCount = App\Models\Proposition::where('post_ask_id', $postAsk->id)->count();
    $user = App\Models\User::find($postAsk->user_id);
    @endphp
<div class="container my-5">
<div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="row g-0">
                    <div class="col-3 p-3" style="height: 400px; width: 400px;">
                        <img src="{{ $postAsk->photo ? asset('/storage/app/' . $postAsk->photo) : asset('no-image.jpg') }}" class="card-img-top" alt="Listing Photo" style="width:100%; height:100%;">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                        @if(Auth::check())
                    @if(Auth::user()->role_id==3 || Auth::user()->id==$postAsk->user_id)
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('edit-post-ask', ['postid' => $postAsk->id]) }}" class="text-dark me-4">
                            <i class="fas fa-edit"></i> Редагувати
                        </a>
                        <!-- Delete Form -->
                        @if(Auth::user()->id==$postAsk->user_id)
                            <form action="{{ route('remove-ask', ['postid' => $postAsk->id, 'userid'=>Auth::user()->id]) }}" method="POST" onsubmit="return confirm('Ви впевнені, що хочете видалити цей запис?');">
                                @csrf
                                <button type="submit" class="text-danger" style="background: none; border: none; cursor: pointer;">
                                    <i class="fas fa-trash-alt"></i> Видалити
                                </button>
                            </form>
                        @else
                            <button type="button" class="text-danger" onclick="location.href='{{ route('remove-ask-form', ['postid' => $postAsk->id, 'userid' => Auth::user()->id]) }}'">
                                <i class="fas fa-trash-alt"></i> Видалити
                            </button>
                        @endif
                    </div>
                    @endif
                @endif
                            <h5 class="mx-0 px-0 card-title" style="font-size:24px;">
                                {{ $postAsk->header }}
                            </h5>
                            <pre class="card-text" style="font-size:20px; white-space: pre-wrap;">{{ $postAsk->content }}</pre>
                            @php
                                $category = App\Models\Category::where('id', $postAsk->category_id)->first();
                            @endphp

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Card (Takes Half Column) -->
    <div class="row">
        <div class="col-6 mb-0">
            <div class="card mb-4 d-flex flex-column">
                <div class="card-body flex-grow-1">
                    <h5 class="card-title">Додаткова інформація</h5>
                    <p class="card-text">Категорія: {{ $category->name }}</p>
                    <p class="card-text">Дата публікації: {{ $postAsk->created_at }}</p>
                    <p class="card-text">Кількість пропозицій: {{ $propositionCount }}</p>
                    <p class="card-text">Прийнятих пропозицій: {{ $postAsk->accepted_propositions }}</p>
                </div>
            </div>
        </div>

        <!-- Third Card (Takes Half Column) -->
        <div class="col-6">
            <div class="card mb-4 d-flex flex-column">
                <div class="card-body flex-grow-1">
                    <h5 class="card-title">Автор запиту</h5>
                    <p class="card-text">Імя: <a href="{{ route('profile', $user->id) }}">{{ $user->name }}</a></p>
                    <p class="card-text">Ранг: {{ $user->military_rank }}</p>
                    <p class="card-text">Склад: {{ $user->composition }}</p>
                    <p class="card-text">Профіль: {{ $user->profile }}</p>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::check())
    @if(Auth::user()->id != $postAsk->user_id)
    <h5 class="text-white fs-3 my-4 text-center">Зробити пропозицію</h5>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Зробити пропозицію</h5>
            <form method="POST" action="{{ route('ask-post-propose', ['postid' => $postAsk->id, 'userid'=>Auth::user()->id]) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="price">Ціна</label>
                    <input type="number" name="price" required min="0" id="price" class="form-control">
                </div>
                <div class="form-group">
                    <label for="photo">Фотографія (необовязково)</label>
                    <input type="file" name="photo" id="photo" class="form-control">
                </div>
                <div class="form-group">
                    <label for="message">Коментар</label>
                    <textarea name="message" id="message" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn" style="background-color: #B5C186;">Запропонувати</button>
            </form>
        </div>
    </div>
    @endif
    @endif

    <!-- List of propositions -->
    @if($propositionCount!=0)
<div class="row">
<h5 class="text-white fs-3 my-4 text-center">Пропозиції</h5>
            <ul>
                @foreach ($propositions as $proposition)
                    @include('card_pages/proposition-card')
                @endforeach
            </ul>
</div>
@endif
  
</div>

@endsection
