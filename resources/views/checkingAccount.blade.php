@extends('layouts.app')

@section('content')
<div id='container' class="border-solid border-4 border-blue-800 m-10">
    <form method="POST" onsubmit="check($event)" action="/verified-transaction" id='transferForm'>
        @csrf
        <div class="m-10">
        <div id='account_info'>
            <div class="flex">
            <label id='account_type_label' for='account_type'><b>Account Type: </b></label>
                <p name='account_type' class=""> {{$account->account_type}}</p>
            </div>
            <div class="flex">
            <label id='account_number_label' for='account_number'><b>IBAN: </b></label>
                <p name='account_number'> {{$account->account_number}}</p>
                <input name='account_number' id='senderIBAN' type="hidden" value="{{$account->account_number}}"/>
            </div>
            <div class="flex">
                <label id='balance' for='balance'><b>Balance: </b> </label>
                <input id='id' type="hidden" value="{{$account->id}}" />
                <input name='senderCurrency' id='currency' type="hidden" value="{{$account->currency}}" />
                <p name='balance'> {{$account->current_balance}} {{ $account->currency }}</p>
                <input name='currency' type="hidden" value="{{ $account->currency }}"/>
            </div>
        </div>
        <div class="flex flex-col">
            <label for='recipientIBAN'><b>Recipient IBAN:</b></label>
            <input  id='recipientIBAN' class="outline-black" name='recipientIBAN' type="text"/>
        </div>
        <br>
        <input class="flex flex-col outline-black" name='transferAmount' id="amount" type="text"/>
        <br>
        <account-balance></account-balance>
        </div>
    </form>
</div>
@endsection
