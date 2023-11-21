@if (!$finished)
    <div class="row ms-3 text-center h-100 d-flex justify-content-center" style="font-size:32px;">
        @if (!is_null($postBid->current_bid))
            @php
                $latestBid = App\Models\Bid::where('post_id', $postBid->id)
                    ->orderByDesc('created_at')
                    ->first();
            @endphp
            <p class="d-flex justify-content-center align-items-center">Поточна ставка: {{ $postBid->current_bid }} грн.</p>

        @endif
        
        <p class="text-center fs-5 mt-0">
            До завершення:
            {{ \Carbon\Carbon::now()->diffForHumans(\Carbon\Carbon::parse($postBid->expiration_datetime), true) }}
        </p>
        @if ($latestBid && $latestBid->user_id == Auth::id())
                <p class="text-danger d-flex justify-content-center">Це ваша ставка!</p>
            @endif
    </div>
@else
    <p class="text-center text-success fs-1 align-items-center d-flex justify-content-center h-50"> Ставки завершено! </p>
@endif
