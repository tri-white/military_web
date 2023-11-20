@extends('shared/layout')

@section('content')
@php
    $category = App\Models\Category::where('id', $postBid->category_id)->first();
    $finished = \Carbon\Carbon::now()->isAfter($postBid->expiration_datetime);
@endphp

<div class="container my-5">
    <div class="row">
        <div class="col-9">
                <div class="card mb-4">
                    
                    <div class="row g-0">
                        <div class="col-3 p-3" style="height: 400px; width: 400px;">
                            <img src="{{ $postBid->photo ? asset(str_replace('public/', 'storage/', $postBid->photo)) : asset('no-image.jpg') }}" class="card-img-top" alt="Listing Photo" style="width:100%; height:100%;">
                        </div>
                        <div class="col-6">
                            <div class="card-body">
                            @if(Auth::check())
                    @if(Auth::user()->role_id==3 || Auth::user()->id==$postBid->user_id)
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('edit-lot', ['postid' => $postBid->id]) }}" class="text-dark me-4">
                            <i class="fas fa-edit"></i> Редагувати
                        </a>
                        @if(Auth::user()->id==$postBid->user_id)
                        <form action="{{ route('remove-lot', ['postid' => $postBid->id, 'userid'=>Auth::user()->id]) }}" method="POST" onsubmit="return confirm('Ви впевнені, що хочете видалити цей запис?');">
                            @csrf
                            <button type="submit" class="text-danger" style="background: none; border: none; cursor: pointer;">
                                <i class="fas fa-trash-alt"></i> Видалити
                            </button>
                        </form>
                        @else
                        <button type="button" class="text-danger" onclick="location.href='{{ route('remove-lot-form', ['postid' => $postBid->id, 'userid' => Auth::user()->id]) }}'">
                            <i class="fas fa-trash-alt"></i> Видалити
                        </button>

                        @endif
                    </div>
                    @endif
                @endif
                                <h5 class="mx-0 px-0 card-title" style="font-size:24px;">
                                    {{ $postBid->header }}
                                </h5>
                                <div id="live-update-container">
                                </div>

                            </div>
                        </div>
                        <div class="col-12 ps-3 mb-3">
                            <pre class="card-text" style="font-size:20px; white-space: pre-wrap;">{{ $postBid->content }}</pre>
                        </div>
                    </div>
                </div>

        </div>
        <div class="col-3">
            @if(!$finished && $postBid->current_bid > 0 && Auth::check())
            @if(Auth::user()->role_id!=1)
            <div class="card mb-3">
                <div class="card-body">
                <form action="{{ route('place-bid', ['postid' => $postBid->id, 'userid'=>Auth::user()->id]) }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="newBid" class="form-label text-center fs-4 w-100 mb-3" >Зробити вищу ставку</label>
                        <div class="input-group">
                            <input type="number" value="{{ round($postBid->current_bid * 1.01) }}" class="form-control text-center fs-4" id="newBid" name="newBid" required min="{{ round($postBid->current_bid * 1.01) }}" step="1">
                            <span class="input-group-text">грн.</span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 border-0" style="background-color: #B5C186;">Підтвердити</button>
                </form>


                </div>
            </div>
            @endif
            @endif
            @if($postBid->current_bid==0 && !$finished && Auth::check())
                @if(Auth::user()->role_id!=1 && Auth::user()->id != $postBid->user_id)
                <div class="card mb-3">
                        <div class="card-body">
                            <form action="{{ route('get-free-lot', ['postid'=>$postBid->id, 'userid'=>Auth::user()->id]) }}" method="post">
                                @csrf
                                <button type="submit" class="btn text-white w-100 border-0 my-auto py-3" style="background-color: #B5C186;">Забрати лот</button>
                            </form>
                        </div>
                    </div>
                @endif
            @endif
            
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Автор лоту</h5>
                    <p>
                        Ім'я: <a href="{{ route('profile', $user->id) }}">
                            {{ $user->name }}
                        </a>
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Інформація про лот</h5>
                    <p>Категорія: {{ $category->name }}</p>
                    <p>Створено: {{ $postBid->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    function updateContent() {
        $.ajax({
            url: '{{ route('lot-post-partial', ['postid' => $postBid->id]) }}',
            method: 'GET',
            dataType: 'html',
            success: function(response) {
                $('#live-update-container').html(response);
            },
            error: function(error) {
                console.error('Error fetching updated data:', error);
            },
        });
    }

    setInterval(updateContent, 1000);
</script>
@endpush
