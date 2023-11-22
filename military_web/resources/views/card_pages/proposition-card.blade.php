
    <div class="card mb-3 col-12">
        <div class="card-body">
        @if(Auth::check())
                    @if(Auth::user()->role_id==3 || Auth::user()->id==$proposition->user_id)
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('edit-proposition', ['propositionid' => $proposition->id]) }}" class="text-dark me-4">
                            <i class="fas fa-edit"></i> Редагувати
                        </a>
                        @if(Auth::user()->id==$proposition->user_id)
                        <form action="{{ route('remove-proposition', ['propositionid' => $proposition->id, 'userid'=>Auth::user()->id]) }}" method="POST" onsubmit="return confirm('Ви впевнені, що хочете видалити цей запис?');">
                            @csrf
                            <button type="submit" class="text-danger" style="background: none; border: none; cursor: pointer;">
                                <i class="fas fa-trash-alt"></i> Видалити
                            </button>
                        </form>
                        @else
                        <button type="button" class="text-danger" onclick="location.href='{{ route('remove-proposition-form', ['propositionid' => $proposition->id, 'userid' => Auth::user()->id]) }}'">
                            <i class="fas fa-trash-alt"></i> Видалити
                        </button>
                        @endif
                    </div>
                    @endif
                @endif
            <div class="d-flex justify-content-between align-items-start">
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
                <img src="{{ $proposition->photo ? asset('storage/app/' . $proposition->photo) : asset('no-image.jpg') }}" alt="Фото пропозиції" class="align-self-center mx-auto text-center d-flex justify-content-center border-1 border-dark" style="width: 300px; height: 300px; object-fit: cover;">
             @endif
            <p class="card-text">{{ $proposition->message }}</p>
            <p class="card-text">Вартість: {{ $proposition->price }} грн.</p>
            @if (Auth::check() && $post_author->id == Auth::user()->id)
                <form method="POST" action="{{ route('accept-proposition', $proposition->id) }}">
                    @csrf
                    <button class="btn btn-success" type="submit">Прийняти пропозицію</button>
                </form>
            @endif
        </div>
    </div>
    @if(Auth::check())
    <div class="modal fade" id="removeReasonModal" tabindex="-1" role="dialog" aria-labelledby="removeReasonModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="removeReasonModalLabel">Видалення пропозиції</h5>
                </div>
                <form action="{{ route('remove-proposition', ['propositionid' => $proposition->id, 'userid'=>Auth::user()->id]) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="reason" class="form-control" placeholder="Причина видалення" required>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                        <button type="submit" class="btn btn-danger">Видалити пропозицію</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
