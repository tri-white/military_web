
    <div class="card mb-3 col-12">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <!-- Top Left: Link to Author's Profile with Picture -->
                <div>
                    @php 
                        $user = App\Models\User::find($proposition->user_id);
                        $post = App\Models\PostAsk::find($proposition->post_ask_id);
                        $post_author = App\Models\User::find($post->user_id);
                    @endphp
                    
                    <h5 class="card-title">
                        <a class="link-dark" href="{{ route('profile', $proposition->user_id) }}">
                            {{ $user->name }}
                        </a>
                    </h5>
                </div>
                <small>{{ $proposition->created_at->diffForHumans() }}</small>
            </div>
            @if ($proposition->photo)
                <img src="{{ asset($proposition->photo) }}" alt="Фото пропозиції" class="align-self-center mx-auto text-center d-flex justify-content-center" style="width: 300px; height: 300px; object-fit: cover;">
             @endif
            <p class="card-text">{{ $proposition->message }}</p>
            <p class="card-text">Price: {{ $proposition->price }} грн.</p>
            @if (Auth::check() && $post_author->id == Auth::user()->id)
                <form method="POST" action="">
                    <button class="btn btn-success" type="submit">Прийняти пропозицію</button>
                </form>
            @endif
        </div>
    </div>
