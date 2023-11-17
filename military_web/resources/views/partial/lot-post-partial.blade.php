<!-- resources/views/partial/lot-post-partial.blade.php -->

@if(!$finished)
<div class="row ms-3 text-center h-100 d-flex justify-content-center" style="font-size:32px;">
    @if ($postBid->current_bid > 0)
        <p class="d-flex justify-content-center align-items-center">Поточна ставка: {{ $postBid->current_bid }} грн.</p>
        
    @else
        <p class="card-text text-success d-flex justify-content-center align-items-center h-50">Цей лот безкоштовний!</p>
    @endif
    <p class="text-center fs-5 mt-0">
            До завершення:
            {{ \Carbon\Carbon::now()->diffForHumans(\Carbon\Carbon::parse($postBid->expiration_datetime), true) }}
        </p>
</div>
@else
<p class="text-center text-success fs-1 align-items-center d-flex justify-content-center h-50"> Ставки завершено! </p>
@endif
