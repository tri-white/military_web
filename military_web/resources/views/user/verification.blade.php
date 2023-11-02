@extends('shared/layout')

@section('content')
<main>
    <form action="{{ route('verify', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="verification_photo">Завантажте фотографію ваших документів, які підтверджують вашу особу як військовозобов'язаного</label>
        <input type="file" id="verification_photo" name="verification_photo">
        <button type="submit">Підтвердити</button>
    </form>
</main>
@endsection
