@extends('shared/layout')

@section('content')
<div class="container mt-5">
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

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Електронна скринька</th>
                    <th>Дата та час</th>
                    <th>Стан</th>
                </tr>
            </thead>
            <tbody>
                @foreach($verificationRequests as $request)
                    <tr onclick="window.location='{{ route('view-verification', ['id' => $request->id]) }}';" style="cursor: pointer;">
                        @php
                            $user = App\Models\User::where('id', $request->user_id)->first();
                            $approvedClass = '';
                            if ($request->approved === 'Очікування') {
                                $approvedClass = 'text-secondary';
                            } elseif ($request->approved === 'Відмовлено') {
                                $approvedClass = 'text-danger';
                            } elseif ($request->approved === 'Підтверджено') {
                                $approvedClass = 'text-success';
                            }
                        @endphp
                        <td>{{ $user->email }}</td>
                        <td>{{ $request->created_at }}</td>
                        <td class="{{ $approvedClass }}">{{ $request->approved }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
