<div class="col-md-4">
            <a href="{{ route('ask-post', ['postid' => $postAsk->id]) }}" class="card-link" style="text-decoration: none; color: inherit;">
                <div class="card mb-4">
                    <img src="{{ $postAsk->photo ? asset(str_replace('public/', 'storage/', $postAsk->photo)) : asset('no-image.jpg') }}" class="card-img-top" alt="Listing Photo">
                    <div class="card-body">
                        <h5 class="card-title">{{ $postAsk->header }}</h5>
                        <p class="card-text">{{ $postAsk->content }}</p>
                        @php 
                        $category = App\Models\Category::where('id', $postAsk->category_id)->first();
                        @endphp 
                        <p class="card-text">Категорія: {{ $category->name }}</p>
                    </div>
                </div>
            </a>
        </div>