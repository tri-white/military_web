@extends('shared/layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="profile-image mx-auto" style="height:150px; width:150px;">
                <img src="{{ asset('images/user_male.jpg') }}"
                     style="width:100%; height:100%; object-fit: contain;"
                     class="rounded-circle border border-1 border-dark" alt="Profile Picture">
            </div>

            <div class="profile-info text-center mt-2">
                <h5>{{ $user->login }}</h5>
                @if(Auth::check())
                @if((Auth::user()->admin == 1 && $user->id !== Auth::user()->id) || Auth::user()->id == $user->id)
                    <form method="POST" action="{{ route('remove-user', ['userid'=>$user->id]) }}">
                        @csrf
                        <button type="submit" style="border: none; background: none; cursor: pointer;">
                            <i class="fa fa-trash-can"></i>
                        </button>
                    </form>
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editUserModal">
                        <i class="fa fa-pencil"></i>
                    </button>
                @endif

                @endif

            </div>
        </div>
        
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="container mt-5">
                <div class="row d-flex justify-content-center">
                    <div class="mb-3 col-lg-12 text-center display-2">
                        Пости
                    </div>
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        @foreach($user->posts as $post)
                            @include('templates/post-card');
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Login -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Редагування логіну користувача</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('edit-user', ['userid'=>$user->id]) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="editedLogin">Відредагувати логін користувача:</label>
                        <input type="text" class="form-control" id="editedLogin" name="editedLogin" value="{{ $user->login }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Зберегти зміни</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
