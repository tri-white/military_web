
@extends('shared/layout')

@section('content')
    <div class="container my-5 text-white">
        <div class="row">
            <div class="col-12">
                <h2>Видалення пропозиції</h2>
                <form action="{{ route('remove-proposition', ['propositionid' => $proposition->id, 'userid'=>Auth::user()->id]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="reason">Причина видалення</label>
                        <input type="text" name="reason" class="form-control" id="reason" placeholder="Причина видалення" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Видалити пропозицію</button>
                </form>
            </div>
        </div>
    </div>
@endsection
