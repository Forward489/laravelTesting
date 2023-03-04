@extends('template')

@section('container')
    <h1>Welcome, {{ auth()->user()->name }}</h1>

    <form action="/logout" method="post">
        @csrf
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure ?')">Logout</button>
    </form>
@endsection