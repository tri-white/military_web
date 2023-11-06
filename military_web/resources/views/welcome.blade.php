@extends('shared/layout')

@push('css')
<style>
    main {
        background-image: none; /* Replace with the URL of your background image */
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center center;
        height: 100vh; /* Make the content take up the full viewport height */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    h1 {
        color: #fff; /* Set the text color to white */
        font-size: 36px; /* Adjust the font size as needed */
        text-align: center;
    }
</style>
@endpush

@section('content')
<main>
    <h1>Hi world</h1>
</main>
@endsection

@push('js')
    <!-- Your JavaScript scripts go here -->
@endpush
