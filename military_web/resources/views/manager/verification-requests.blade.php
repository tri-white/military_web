@extends('shared/layout')

@section('content')
<div class="container mt-5 text-white border-white">
    <h2>Верифікація військових</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-responsive text-white border-white">
        <table class="table table-bordered text-white border-white">
            <thead>
                <tr>
                    <th>Електронна скринька</th>
                    <th>Дата та час</th>
                    <th>Стан</th>
                </tr>
            </thead>
            <tbody>
                @foreach($verificationRequests as $request)
                    <tr onclick="window.location='{{ route('view-verification', ['id' => $request->id]) }}';" style="cursor: pointer;" class="@if($request->approved === 'Очікування') bg-secondary @elseif($request->approved === 'Відмовлено') bg-danger @elseif($request->approved === 'Підтверджено') bg-success @endif">
                        @php
                            $user = App\Models\User::where('id', $request->user_id)->first();
                        @endphp
                        <td>{{ $user->email }}</td>
                        <td>{{ $request->created_at }}</td>
                        <td>{{ $request->approved }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
