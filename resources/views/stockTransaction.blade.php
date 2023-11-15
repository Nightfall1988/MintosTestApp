@extends('layouts.app')

@section('content')
<div id='container' class="border-solid border-4 border-light-blue-500">
    <form method="GET" action="/invest">
        @csrf
        <input name='symbol' />
        <input name='amount' />
        <input type='hidden' name='accountId' value="{{ $id }}"/>
        <button>Buy</button>
    </form>
</div>
@endsection
