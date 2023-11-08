<div class="col-9">
    <a href="{{ route('lot-post', ['postid' => $postBid->id]) }}" class="card-link" style="text-decoration: none; color: inherit;">
        <div class="card mb-4">
            <div class="row g-0">
                <div class="col-3">
                    <img src="{{ $postBid->photo ? asset(str_replace('public/', 'storage/', $postBid->photo)) : asset('no-image.jpg') }}" class="card-img-top" alt="Listing Photo" style="height: 100%;">
                </div>
                <div class="col-9">
                    <div class="card-body">
                        <h5 class="card-title">{{ $postBid->header }}</h5>
                        <p class="card-text">{{ $postBid->content }}</p>
                        @php 
                        $category = App\Models\Category::where('id', $postBid->category_id)->first();
                        @endphp 
                        <p class="card-text">Категорія: {{ $category->name }}</p>
                        <p class="card-text">Дата і час завершення: {{ $postBid->expiration_datetime }}</p>

                        @if ($postBid->current_bid > 0)
                        <p class="card-text">Поточна ставка: ${{ $postBid->current_bid }}</p>
                        <p class="card-text">Ціна для миттєвої купівлі: ${{ $postBid->buy_price }}</p>
                        @else
                        <p class="card-text text-success">Цей лот безкоштовний! [Волонтерство]</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
