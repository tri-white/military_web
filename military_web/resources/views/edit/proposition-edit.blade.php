@extends('shared/layout')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center mt-4 mb-4 text-white">Редагувати пропозицію</h2>

                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Зробити пропозицію</h5>
                                <form method="POST" action="{{ route('edit_proposition', ['propositionid' => $proposition->id, 'userid'=>Auth::user()->id]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="price">Ціна</label>
                                        <input type="number" value="{{$proposition->price}}" name="price" required min="0" id="price" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Фотографія (необов'язково)</label>
                                        <input type="file" name="photo" id="photo" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Коментар</label>
                                        <textarea name="message" id="message" class="form-control" required>{{$proposition->message}}</textarea>
                                    </div>
                                    <div class="div d-flex justify-content-center">
                    <button type="submit" class="btn text-white btn-block mt-4 px-5" style="background-color: #2B2C27;">Зберегти зміни</button>
                </div>
                                </form>
                            </div>
                        </div>
               
        </div>
    </div>
</div>

@endsection
