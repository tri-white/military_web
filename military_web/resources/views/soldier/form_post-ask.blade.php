@extends('shared/layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-white">
            <h2 class="text-center mt-4 mb-4">Створення оголошення</h2>
            <form action="{{ route('create_post-ask', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
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
                    <label for="photo">Фотографія (не обов'язково):</label>
                    <input type="file" class="form-control-file" id="photo" name="photo" accept=".jpg, .jpeg, .png">
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

                <button type="submit" class="btn btn-primary btn-block mt-4">Створити оголошення</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
    <!-- Add your JavaScript here if needed -->
@endpush
