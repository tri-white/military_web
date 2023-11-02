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
                    <button type="submit" class="btn btn-success">Підтвердити</button>
                    <button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#disapproveReason" aria-expanded="false" aria-controls="disapproveReason">
                        Відхилити
                    </button>
                </div>
            </form>

            <div class="collapse mt-2" id="disapproveReason">
                <form method="post" action="{{ route('disapprove-verification', ['id' => $request->id]) }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="reason" placeholder="Reason for Disapproval" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Відхилити</button>
                </form>
            </div>
        @elseif ($request->approved === 'Підтверджено' || $request->approved === 'Відмовлено')
            <form method="post" action="{{ route('verification-to-waiting', ['id' => $request->id]) }}">
                @csrf
                <button type="submit" class="btn btn-warning">Змінити на "Очікування"</button>
            </form>
        @endif
    </div>

    <div class="container text-center mb-3">
        <a href="{{ asset('storage/'.$request->ticket_photo) }}" download="{{ $user->email }}_verification.jpg" class="btn btn-primary">завантажити файл</a>
    </div>
@endsection
