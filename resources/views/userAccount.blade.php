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
        <recipient-currency></recipient-currency>
            <br>
        <div class="flex flex-row ">
            <div class="flex-col">
                <label for='transferAmount'><b>Transfer amount:&nbsp;&nbsp;</b></label>
                <input class="flex flex-col outline-black" name='transferAmount' id="amount" type="text" style="width: 11rem;"/>
            </div>
            <div class="flex-col ml-2">
                <label for='currency'><b>Currency:&nbsp;&nbsp;</b></label>
                <br>
                <select class='ml-2' name='currency' id='reciever-currency' placeholder='Currency'>
                    <option>EUR</option>
                    @foreach ($currencyCollection->all() as $currency)
                        <option>{{ $currency->symbol }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <account-balance></account-balance>
        </div>
        <div>        
            <a class="bg-blue-800 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-black-700 rounded ml-10 mt-3 mb-10" href="/transaction-history/{{$account->id}}">Account transaction hisory</a>
        </div>
        <br>
    </form>
</div>
@endsection
