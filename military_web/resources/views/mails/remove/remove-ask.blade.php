Шановний користувач платформи Military Trade,<br>
Ваш запит на допомогу було видалено адміністратором платформи по наступній причині: {{ $reason }}<br><hr>
Запит на допомогу:<br>
<div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="row g-0">
                    <div class="col-3 p-3" style="height: 400px; width: 400px;">
                        <img src="{{ $post->photo ? asset('storage/app/' . $post->photo) : asset('no-image.jpg') }}" class="card-img-top" alt="Listing Photo" style="width:100%; height:100%;">
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                    
                            <h5 class="mx-0 px-0 card-title" style="font-size:24px;">
                                {{ $post->header }}
                            </h5>
                            <pre class="card-text" style="font-size:20px; white-space: pre-wrap;">{{ $post->content }}</pre>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>