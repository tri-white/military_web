<div class="col-9">
                        @php 
                         $category = App\Models\Category::where('id', $postBid->category_id)->first();
                        @endphp 
    <a href="{{ route('lot-post', ['postid' => $postBid->id]) }}" class="card-link" style="text-decoration: none; color: inherit;">
        <div class="card mb-4">
            <div class="row g-0" style="height:200px;">
                <div class="col-3" style="height:200px; width:200px;">
                    <img src="{{ $postBid->photo ? asset('storage/app/' . $postBid->photo) : asset('no-image.jpg') }}" class="card-img-top" alt="Listing Photo" style="height: 100%;">
                </div>
                <div class="col-9">
                    <div class="card-body" style="height:82%;">
                        <h5 class="mx-0 px-0 card-title d-flex justify-content-between">
                            <span class="pe-5" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width:60%;">
                                {{ $postBid->header }}
                            </span>
                            <span class="d-flex text-end justify-end"
                                style="font-size:16px; color: gray; position:absolute; right:25px; top:15px;">
                                {{ $category->name }}
                            </span>
                        </h5>
                        <div class="col-12">
                            <p class="card-text" style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-height: 100%;">{{ $postBid->content }}</p>
                        </div>


                    </div>
                    <div class="row ms-3">
                        <div class="col-4">
                            
                            <p class="text-start">
                                До завершення:
                                {{ \Carbon\Carbon::parse($postBid->expiration_datetime)->diffForHumans(null, true) }}
                            </p>

                        </div>
                        <div class="col-5 text-center">
                                    @if ($postBid->current_bid > 0)
                                    <p class="">Поточна ставка: {{ $postBid->current_bid }} грн.</p>
                                    @else
                                    <p class="card-text text-success">Цей лот безкоштовний!</p>
                                    @endif
                        </div>
                        <div class="col-3">
                            <p class="text-end">
                                {{ $postBid->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                    


                    
                </div>
            </div>
        </div>
    </a>
</div>
