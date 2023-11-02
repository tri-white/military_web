@extends('shared/layout')

@section('content')
<main class="d-flex justify-content-center align-items-center" style="height: 75vh;">
    <div class="col-md-6">
        <form action="{{ route('verify', Auth::user()->id) }}" method="POST" enctype="multipart/form-data" class="p-3 bg-light border rounded">
            @csrf
            <h2 class="mb-4">Верифікація військових</h2>
            <div class="mb-3">
                <label for="verification_photo" class="form-label">Завантажте фотографію ваших документів, які підтверджують вашу особу як військовозобов'язаного (формати: .png, .jpeg, .jpg)</label>
                <input type="file" id="verification_photo" name="verification_photo" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Надіслати на обробку</button>
        </form>
    </div>
</main>
@endsection
