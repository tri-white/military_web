@extends('shared/layout')

@section('content')
    <div class="container text-center">
        <h1>Заява на верифікацію</h1>
        
        <img src="{{ asset('storage/'.$request->ticket_photo) }}" alt="Verification Photo" style="max-width: 300px; margin: 0 auto;">

        @php
            $user = App\Models\User::where('id', $request->user_id)->first();
        @endphp

        <p>Користувач: <a href="{{ route('profile', $user->id) }}">{{ $user->email }}</a></p>
        <p>Статус: {{ $request->approved }}</p>

        @if ($request->approved === 'Очікування')
            <form method="post" action="{{ route('approve-verification', ['id' => $request->id]) }}">
                @csrf
                <div class="btn-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Підтвердити заяву
                    </button>
                    <button type="button" class="btn btn-danger" href="#disapproveReason" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="disapproveReason">
                        <i class="fas fa-times"></i> Відхилити
                    </button>

                </div>

            </form>
            <div class="collapse mt-2" id="disapproveReason">
                <form method="post" action="{{ route('disapprove-verification', ['id' => $request->id]) }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="reason" placeholder="Причина відхилення заяви" required>
                    </div>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Відхилити заяву
                    </button>
                </form>
            </div>
         

            <form method="post" action="{{ route('remove-verification', ['id' => $request->id]) }}">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Видалити заяву
                </button>
            </form>
        @elseif ($request->approved === 'Підтверджено' || $request->approved === 'Відмовлено')
            <form method="post" action="{{ route('verification-to-waiting', ['id' => $request->id]) }}">
                @csrf
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-undo"></i> Змінити на "Очікування"
                </button>
            </form>
        @endif
    </div>

    <div class="container text-center mb-3">
        <a href="{{ asset('storage/'.$request->ticket_photo) }}" download="{{ $user->email }}_verification.jpg" class="btn btn-primary">
            <i class="fas fa-download"></i> завантажити картинку
        </a>
    </div>

@endsection
