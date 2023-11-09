<div class="col-9">
                        @php 
                         $category = App\Models\Category::where('id', $postBid->category_id)->first();
                        @endphp 
    <a href="{{ route('lot-post', ['postid' => $postBid->id]) }}" class="card-link" style="text-decoration: none; color: inherit;">
        <div class="card mb-4">
            <div class="row g-0" style="height:200px;">
                <div class="col-3" style="height:200px; width:200px;">
                    <img src="{{ $postBid->photo ? asset(str_replace('public/', 'storage/', $postBid->photo)) : asset('no-image.jpg') }}" class="card-img-top" alt="Listing Photo" style="height: 100%;">
                </div>
                <div class="col-9">
                    <div class="card-body">
                        <h5 class="mx-0 px-0 card-title d-flex justify-content-between">
                            <span class="pe-5" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width:90%;">
                                {{ $postBid->header }}
                            </span>
                            <span class="d-flex text-end justify-end"
                                style="font-size:16px; color: gray; position:absolute; right:25px; top:15px;">
                                {{ $category->name }}
                            </span>
                        </h5>
                        <div class="col-12">
                            <p class="card-text"  style="overflow: hidden; text-overflow: ellipsis;"> {{ $postBid->content }} </p>

                        </div>
                    </div>
                    <div class="out-of-card-body d-flex justify-content-center mt-3">
                            <div id="middle" class="row">
                                @if ($postBid->current_bid > 0)
                                <p class="">Поточна ставка: ${{ $postBid->current_bid }}</p>
                                @else
                                <p class="card-text text-success">Цей лот безкоштовний! [Волонтерство]</p>
                                @endif
                            </div>
                    </div>
                    <p class="" style="position:absolute; bottom:0px; left:215px;">
                        До завершення:  
                        {{ \Carbon\Carbon::parse($postBid->expiration_datetime)->subHours(2)->diffForHumans(null, true) }}
                    </p>



                    <p class="text-end" style="position: absolute; bottom: 0px; right:25px; font-size:16px; color: gray;">
                        {{ $postBid->created_at->format('d/m/Y') }}
                    </p>
                </div>
            </div>
        </div>
    </a>
</div>
