@extends('layouts.app')

@section('content')
<form method="POST">
    @csrf
    <div class="text-xl flex h-screen justify-center flex-col p-10">
        <div class="flex justify-center text-l m-auto border-solid border-4 border-blue-800 p-10 mt-10">
            <div class="flex flex-col">
            <label>{{ __('Name') }}</label>
            <input type="text" name="name" />

            <label>{{ __('Email') }}</label>
            <input type="text" name="email" />

            <label>{{ __('Password') }}</label>
            <input type="password" name="password" />

            <label>{{ __('Confirm Password') }}</label>
            <input type="password" name="password_confirmation" />

            <button class="bg-blue-800 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-black-700 rounded mt-3">
                Submit
            </button>
            </div>
        </div>
    </div>
</form>
@endsection