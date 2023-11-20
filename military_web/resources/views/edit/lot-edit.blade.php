@extends('shared/layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-white">
            <h2 class="text-center mt-4 mb-4">Редагування аукціону</h2>
            <form class="mb-5" action="{{ route('edit_post-bid', ['userid' => Auth::user()->id, 'postid' => $post->id]) }}" method="POST" enctype="multipart/form-data" id="editListingForm">
                @csrf

                <div class="form-group">
                    <label for="header">Заголовок:</label>
                    <input type="text" class="form-control" id="header" name="header" value="{{ old('header', $post->header) }}" required>
                </div>

                <div class="form-group">
                    <label for="content">Опис:</label>
                    <textarea class="form-control" id="content" name="content" rows="4" required>{{ old('content', $post->content) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="photo">Фото товару (не обов'язково):</label>
                    <input type="file" class="form-control-file" id="photo" name="photo" accept=".jpg, .jpeg, .png">
                </div>

                <div class="form-group my-3">
                    <label for="expiration_datetime">Дата та час закінчення торгів:</label>
                    <input type="datetime-local" class="form-control" id="expiration_datetime" name="expiration_datetime" value="{{ old('expiration_datetime', $post->expiration_datetime) }}" required>
                </div>

                <div class="form-group mt-3">
                    <label for="category_id">Категорія:</label>
                    <select class="form-control" id="category_id" name="category_id">
                        @php
                        $categories = App\Models\Category::all();
                        @endphp
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="div d-flex justify-content-center">
                    <button type="submit" class="btn text-white btn-block mt-4 px-5" style="background-color: #2B2C27;">Зберегти зміни</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
