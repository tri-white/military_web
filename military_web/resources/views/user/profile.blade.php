@extends('shared/layout')

@section('content')
<main>
    <h1 class="center-header my-5 text-center text-white">Профіль користувача</h1>

    <div class="container">
        <div class="card custom-card mx-auto">
            <div class="card-body text-center">
                <h2>Імя: {{ $user->name }}</h2>
                <p>Електронна скринька: {{ $user->email }}</p>
                <p>Дата реєстрації: {{ $user->created_at->format('Y-m-d') }}</p>
                @php 
                $role = App\Models\Role::find($user->role_id)->name;
               
                @endphp 
                @if($role=="soldier") 
                    @php 
                    $role = "Військовий";
                    @endphp
                @elseif ($role=="manager") 
                @php 
                    $role = "Менеджер";
                    @endphp
                @elseif ($role == "regular") 
                @php 
                    $role = "Звичайний користувач";
                    @endphp
                @endif
                <p>Роль: {{ $role }}</p>
                @if($role=="Військовий")
                <p>Ранг: {{ $user->military_rank }} </p>
                        <p>Склад: {{ $user->composition }}</p>
                        <p>Профіль: {{ $user->profile }}</p>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
