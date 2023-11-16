@extends('shared/layout')

@section('content')
@php
    $category = App\Models\Category::where('id', $postBid->category_id)->first();
@endphp

<div class="container my-5">
    <div class="row">
        <div class="col-9">
            <a href="{{ route('lot-post', ['postid' => $postBid->id]) }}" class="card-link" style="text-decoration: none; color: inherit;">
                <div class="card mb-4">
                    <div class="row g-0">
                        <div class="col-3 p-3" style="height: 400px; width: 400px;">
                            <img src="{{ $postBid->photo ? asset(str_replace('public/', 'storage/', $postBid->photo)) : asset('no-image.jpg') }}" class="card-img-top" alt="Listing Photo" style="width:100%; height:100%;">
                        </div>
                        <div class="col-6">
                            <div class="card-body">
                                <h5 class="mx-0 px-0 card-title" style="font-size:24px;">
                                    {{ $postBid->header }}
                                </h5>
                                <div class="row ms-3 text-center" style="font-size:32px;">
                                        @if ($postBid->current_bid > 0)
                                            <p class="">Поточна ставка: {{ $postBid->current_bid }} грн.</p>
                                        @else
                                            <p class="card-text text-success">Цей лот безкоштовний!</p>
                                        @endif
                                </div>
                                <div class="row">
                            <p class="text-center">
                                До завершення:
                                {{ \Carbon\Carbon::now()->diffForHumans(\Carbon\Carbon::parse($postBid->expiration_datetime), true) }}
                            </p>
                        </div>


                            </div>
                        </div>
                        <div class="col-12 ps-3 mb-3">
                            <pre class="card-text" style="font-size:20px; white-space: pre-wrap;">{{ $postBid->content }}</pre>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Автор лоту</h5>
                    <p>
                        Ім'я: <a href="{{ route('profile', $user->id) }}">
                            {{ $user->name }}
                        </a>
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Інформація про лот</h5>
                    <p>Категорія: {{ $category->name }}</p>
                    <p>Створено: {{ $postBid->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
