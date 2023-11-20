<!-- ban-form.blade.php -->

@extends('shared/layout')

@section('content')
    <div class="container text-white text-center">
        <h2>Форма блокування користувача: {{$user->name}}</h2>
        <form action="{{ route('admin.process-ban-form', $user) }}" method="POST">
            @csrf

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="ban_expiration">Термін блокування:</label>
                <input type="datetime-local" name="ban_expiration" class="form-control">
            </div>

            <div class="form-group" style="margin-top: 30px;">
                <button type="submit" class="btn btn-danger">Заблокувати користувача</button>
            </div>
        </form>
    </div>
@endsection
