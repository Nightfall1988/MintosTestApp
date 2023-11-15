@extends('layouts.app')

@section('content')
<div class="m-10">
    <div id='container' class="border-solid border-4 border-blue-500">
        <form method="GET" action="/home">
            @csrf
            <div class="flex flex-col">
                <div class="flex-col">
                    <div class="flex justify-center">
                        <p><b>Transaction Successful</b></p>
                    </div>
                    <div class="flex justify-center">
                        <p>Your transaction of {{ $amount }} {{ $currency }} has been successful!</p>
                    </div>
                </div>
                <button class="bg-green-800 hover:bg-green-600 text-white font-bold py-2 px-4 border border-black-700 rounded mr-10 ml-10 mt-3 mb-10">Back to Homepage</button>
            </div>
        </form>
    </div>
</div>
@endsection
