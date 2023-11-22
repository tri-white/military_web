Шановний користувач платформи Military Trade,<br>
Вашу пропозицію було вилучено з наступної причини: "{{ $reason }}"<br>
Пропозиція:<br>

<div class="card mb-3 col-12">
        <div class="card-body">
            @if ($proposition->photo)
                <img src="{{ $proposition->photo ? asset('storage/app/' . $proposition->photo) : asset('no-image.jpg') }}" alt="Фото пропозиції" class="align-self-center mx-auto text-center d-flex justify-content-center border-1 border-dark" style="width: 300px; height: 300px; object-fit: cover;">
             @endif
            <p class="card-text">{{ $proposition->message }}</p>
            <p class="card-text">Вартість: {{ $proposition->price }} грн.</p>
           
        </div>
    </div>
</div><br>
Оголошення, на яке було здійснено пропозицію:<br>
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
                            @php
                                $category = App\Models\Category::where('id', $post->category_id)->first();
                            @endphp
                            <p> Категорія: {{$category->name }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
