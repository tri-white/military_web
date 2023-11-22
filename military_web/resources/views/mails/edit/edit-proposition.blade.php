Доброго дня, користувач платформи Military Trade!<br>
Вашу пропозицію було відредаговано менеджером платформи.<br>
<hr> Пропозиція: <br>

<div class="card mb-3 col-12">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    @if ($proposition->photo)
                        <img src="{{ $proposition->photo ? asset('storage/app/' . $proposition->photo) : asset('no-image.jpg') }}" alt="Фото пропозиції" class="align-self-center mx-auto text-center d-flex justify-content-center border-1 border-dark" style="width: 300px; height: 300px; object-fit: cover;">
                    @endif
                    <p class="card-text">{{ $proposition->message }}</p>
                    <p class="card-text">Вартість: {{ $proposition->price }} грн.</p>
                </div>
                <small>{{ $proposition->created_at->diffForHumans() }}</small>
            </div>
          
        </div>
    </div>
</div>
