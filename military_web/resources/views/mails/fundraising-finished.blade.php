Доброго дня, користувач платформи Military Trade!<br>
Раді повідомити, що ваш збір коштів завершено!<br>
<hr> Збір коштів: <br>
<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title fs-3 text-justify">{{ $post->purpose }}</h1>
                    <p class="card-text">Зібрано: {{ $post->current_amount }} / {{ $post->goal_amount }} грн.</p>

                    <div class="progress my-5">
                        <div class="progress-bar" role="progressbar"
                            style="width: {{ ($post->current_amount / $post->goal_amount) * 100 }}%; background-color: #B5C186;">
                            {{ number_format(($post->current_amount / $post->goal_amount) * 100, 2) }}%
                        </div>
                    </div>

                    <div class="row d-flex justify-content-between">
                        <div class="col-6">
                            Дата створення: {{ $post->created_at->format('d/m/Y') }}
                        </div>
                        <div class="col-6 text-end">
                            @php
                            $name = App\Models\Category::where('id',$post->category_id)->first()->name;
                            @endphp
                            {{ $name }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>