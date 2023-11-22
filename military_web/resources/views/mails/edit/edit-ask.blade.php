Доброго дня, користувач платформи Military Trade!<br>
Ваш запит на допомогу було відредаговано менеджером платформи.<br>
<hr> Запит на допомогу: <br>

@php
    $propositionCount = App\Models\Proposition::where('post_ask_id', $post->id)->count();
    $user = App\Models\User::find($post->user_id);
    @endphp
<div class="container my-5">
<div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="row g-0">
                    <div class="col-3 p-3" style="height: 400px; width: 400px;">
                        <img src="{{ $post->photo ? asset('storage/app/public' . $post->photo) : asset('no-image.jpg') }}" class="card-img-top" alt="Listing Photo" style="width:100%; height:100%;">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <h5 class="mx-0 px-0 card-title" style="font-size:24px;">
                                {{ $post->header }}
                            </h5>
                            <pre class="card-text" style="font-size:20px; white-space: pre-wrap;">{{ $post->content }}</pre>
                            @php
                                $category = App\Models\Category::where('id', $post->category_id)->first();
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
                    <p class="card-text">Дата публікації: {{ $post->created_at }}</p>
                    <p class="card-text">Кількість пропозицій: {{ $propositionCount }}</p>
                    <p class="card-text">Прийнятих пропозицій: {{ $post->accepted_propositions }}</p>
                </div>
            </div>
        </div>
