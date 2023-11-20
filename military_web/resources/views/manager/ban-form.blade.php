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

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="delete_propositions">Видалити пропозиції:</label>
                <input type="checkbox" name="delete_propositions">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="delete_postBids">Видалити аукціони:</label>
                <input type="checkbox" name="delete_postBids">
            </div>
            @if($user->role_id == 2)
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="delete_postAsks">Видалити запити на допомогу:</label>
                <input type="checkbox" name="delete_postAsks">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="delete_postMoneys">Видалити збори коштів:</label>
                <input type="checkbox" name="delete_postMoneys">
            </div>
            @endif

            <div class="form-group" style="margin-top: 30px;">
                <button type="submit" class="btn btn-danger">Заблокувати користувача</button>
            </div>
        </form>
    </div>
@endsection
