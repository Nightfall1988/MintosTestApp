@extends('layouts.app')

@section('content')

<h2 class="text-3xl mb-10 flex justify-center mt-10">Create Account</h2>
<div class="flex justify-center">
<form id='createForm' method='POST' action="/save">
    @csrf
    <label>{{ __('Currency: ') }}</label>
        <select class='ml-10' name='currency' placeholder='Currency'>
            <option>EUR</option>
            @foreach ($currencyCollection->all() as $currency)
                <option>{{ $currency->symbol }}</option>
            @endforeach
        </select>
    <br>
    <br>
    <br>
    <button class="bg-green-800 hover:bg-green-600 text-white font-bold py-2 px-4 border border-black-700 rounded ml-10 mt-3 mb-10">Create Account</button>
</form>
</div>

@endsection


