@extends('layouts.app')

@section('content')
<div class="flex justify-center">
    <p class="text-8xl text-black-600">NanoBank</p>
</div>
<form method="POST">
    @csrf
<div class='flex flex-col justify-center text-xl m-24'>
    <label>{{ __('Email') }}</label>
    <input type="text" name="email" />

    <label>{{ __('Password') }}</label>
    <input type="password" name="password" />
<br>
    <button class="bg-green-800 hover:bg-green-600 text-white font-bold py-2 px-4 border border-black-700 rounded">
        Submit
    </button>
</div>
</form>
@endsection