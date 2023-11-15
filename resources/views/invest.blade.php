@extends('layouts.app')

@section('content')
<div id='container' class="border-solid border-4 border-light-blue-500">
    <form method="POST" action="/verified-transaction">
        @csrf
    </form>
</div>
@endsection
