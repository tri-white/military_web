Шановний користувач платформи Military Trade,<br>
Ваш збір коштів було видалено адміністратором платформи по наступній причині: {{ $reason }}<br><hr>
Збір коштів:<br>
<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title fs-3 text-justify">{{ $post->purpose }}</h1>
                    <p class="card-text">Вже зібрано: {{ $post->current_amount }} / {{ $post->goal_amount }} грн.</p>
                    <div class="row d-flex justify-content-between">
                        <div class="col-6">
                            Дата створення: {{ $post->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

