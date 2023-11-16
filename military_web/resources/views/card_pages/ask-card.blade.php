<div class="col-9">
    @php
    $category = App\Models\Category::where('id', $postAsk->category_id)->first();
    $propositionCount = App\Models\Proposition::where('post_ask_id', $postAsk->id)->count();
    @endphp

    <a href="{{ route('ask-post', ['postid' => $postAsk->id]) }}" class="card-link"
        style="text-decoration: none; color: inherit;">
        <div class="card mb-4">
            <div class="row g-0" style="height:200px;">
                <div class="col-3" style="height:200px; width:200px;">
                    <img src="{{ $postAsk->photo ? asset(str_replace('public/', 'storage/', $postAsk->photo)) : asset('no-image.jpg') }}"
                        class="card-img-top" alt="Listing Photo" style="height:100%;">
                </div>
                <div class="col-9">
                    <div class="card-body" style="height:82%;">
                        <h5 class="mx-0 px-0 card-title d-flex justify-content-between">
                            <span class="pe-5"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width:60%;">
                                {{ $postAsk->header }}
                            </span>
                            <span class="d-flex text-end justify-end"
                                style="font-size:16px; color: gray; position:absolute; right:25px; top:15px;">
                                {{ $category->name }}
                            </span>
                        </h5>
                        <div class="col-12">
                            <p class="card-text"
                                style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-height: 100%;">
                                {{ $postAsk->content }}</p>
                        </div>
                    </div>
                    <div class="row ms-3">
                        <div class="col-4">
                            <p class="text-start">
                                Кількість пропозицій:
                                {{ $propositionCount }}
                            </p>
                        </div>
                        <div class="col-2 text-center">
                        </div>
                        <div class="col-6">
                            <p class="text-end">
                                {{ $postAsk->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>