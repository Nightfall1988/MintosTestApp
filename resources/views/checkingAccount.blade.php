@extends('layouts.app')

@section('content')
<div id='container' class="border-solid border-4 border-blue-800 m-10">
    <form method="POST" onsubmit="check($event)" action="/verified-transaction" id='transferForm'>
        @csrf
        <div class="m-10">
        <div id='account_info'>
            <div class="flex">
            <label id='account_id_label' for='id'><b>Account ID:&nbsp;</b></label>
                <p name='id'> {{$account->id}}</p>
                <input name='id' id='senderId' type="hidden" value="{{$account->id}}"/>
            </div>
            <div class="flex">
                <label id='balance' for='balance'><b>Balance:&nbsp;</b> </label>
                <input name='senderCurrency' id='currency' type="hidden" value="{{$account->currency}}" />
                <p name='balance'> {{$account->current_balance}} {{ $account->currency }}</p>
                <input name='currency' type="hidden" value="{{ $account->currency }}"/>
            </div>
        </div>
        <div class="flex flex-row">
            <label for='recipientId'><b>Recipient account ID:&nbsp;&nbsp;</b></label>
            <input  id='recipientId' class="outline-black" name='recipientId' type="text" style="width: 11rem;"/>
        </div>
            <br>
        <div class="flex flex-row">
            <label for='transferAmount'><b>Transfer amount:&nbsp;&nbsp;</b></label>
            <input class="flex flex-col outline-black" name='transferAmount' id="amount" type="text" style="width: 11rem;"/>
        </div>
        <br>
        <account-balance></account-balance>
        </div>
    </form>
</div>
@endsection
