@extends('layouts.app')

@section('content')
<div class="flex h-screen justify-center flex-col p-10">
    <div class="flex justify-center text-l m-auto border-solid border-4 border-blue-800 p-10 mt-10 flex-col">
        <div class="flex justify-center">
            <p class="text-3xl text-black-600">Mintos Test App</p>
        </div>

        <form method="POST">
                @csrf
                <div class="flex-col">
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
                    <div class="flex justify-center">
                        <p>Don't have an account? </p>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-blue"><b>&nbsp;&nbsp;Register</b></a>
                        @endif
                    </div>
                </div>
        </form>
    </div>
</div>
@endsection