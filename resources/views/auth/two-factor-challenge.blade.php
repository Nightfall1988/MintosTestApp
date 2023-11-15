@extends('layouts.app')

@section('content')
<div class="flex justify-center text-xl mt-24">
<form method="POST" action="/two-factor-challenge">
    @csrf

    <label>{{ __('Security Code: ') }}</label>
    <input type="text" name="code" />
    <br>
    <br>
    <div class="flex justify-center">
    <button class="bg-green-800 hover:bg-green-600 text-white font-bold py-2 px-4 border border-black-700 rounded">
        Login
    </button>
    </div>
</form>
</div>
@endsection
