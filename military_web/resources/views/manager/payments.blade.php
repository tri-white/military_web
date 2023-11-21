@extends('shared/layout')

@section('content')
<div class="container mt-5 text-white border-white">
    <h2>Історія платежів</h2>

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
                    <th>Сума</th>
                    <th>Призначення</th>
                    <th>Дата створення</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $request)
                    <tr>
                        <td>{{ $request->value }}</td>
                        <td>{{ $request->subject }}</td>
                        <td>{{ $request->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
