@extends('shared/layout')

@section('content')
<div class="container mt-5">
    <h2>Verification Requests</h2>

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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Email</th>
                <th>Date and Time</th>
                <th>Approved State</th>
            </tr>
        </thead>
        <tbody>
            @foreach($verificationRequests as $request)
                <tr>
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
@endsection
