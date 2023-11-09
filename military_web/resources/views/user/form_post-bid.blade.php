@extends('shared/layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-white">
            <h2 class="text-center mt-4 mb-4">Створення лоту</h2>
            <form  class="mb-5" action="{{ route('create_post-bid', Auth::user()->id) }}" method="POST" enctype="multipart/form-data" id="listingForm">
                @csrf

                <div class="form-group">
                    <label for="header">Заголовок:</label>
                    <input type="text" class="form-control" id="header" name="header" required>
                </div>

                <div class="form-group">
                    <label for="content">Опис:</label>
                    <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="photo">Фото товару (не обов'язково):</label>
                    <input type="file" class="form-control-file" id="photo" name="photo" accept=".jpg, .jpeg, .png">
                </div>

                <div class="form-group my-3">
                    <label for="expiration_datetime">Дата та час закінчення торгів:</label>
                    <input type="datetime-local" class="form-control" id="expiration_datetime" name="expiration_datetime" required>
                </div>

                <div class="form-group">
                    <input type="checkbox" id="volunteer" name="volunteer" class="mr-2">
                    <label>Це волонтерство (безкоштовно, тим хто потребує)</label>
                </div>

                <div class="form-group" id="currentBidGroup">
                    <label for="current_bid">Початкова ціна (грн):</label>
                    <input type="number" class="form-control" id="current_bid" name="current_bid" step="0.01">
                </div>

                <div class="form-group" id="buyPriceGroup">
                    <label for="buy_price">Ціна завершення (грн):</label>
                    <input type="number" class="form-control" id="buy_price" name="buy_price" step="0.01">
                </div>

                <div class="form-group mt-3">
                    <label for="category_id">Категорія:</label>
                    <select class="form-control" id="category_id" name="category_id">
                        @php 
                         $categories = App\Models\Category::all();
                         @endphp
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="div d-flex justify-content-center">
                    <button type="submit" class="btn text-white btn-block mt-4 px-5"  style="background-color: #2B2C27;">Створити лот</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    const volunteerCheckbox = document.getElementById('volunteer');
    const currentBidGroup = document.getElementById('currentBidGroup');
    const buyPriceGroup = document.getElementById('buyPriceGroup');
    const listingForm = document.getElementById('listingForm');

    volunteerCheckbox.addEventListener('change', function () {
        if (this.checked) {
            currentBidGroup.style.display = 'none';
            buyPriceGroup.style.display = 'none';
            listingForm.action = "{{ route('create_post-bidFree', Auth::user()->id) }}";
        } else {
            currentBidGroup.style.display = 'block';
            buyPriceGroup.style.display = 'block';
            listingForm.action = "{{ route('create_post-bid', Auth::user()->id) }}";
        }
    });
</script>
@endpush
