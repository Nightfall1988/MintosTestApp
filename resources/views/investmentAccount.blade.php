@extends('layouts.app')

@section('content')
<div id='container'>
    <form method="POST" action="/verified-transaction" id="transferForm">
        @csrf
        <div class="border-solid border-4 border-blue-800 m-10">
            <div class='m-10'>
                <div id='account_info'>
                    <div class="flex">
                    <label id='account_type_label' for='account_type'><b>Account Type: </b></label>
                        <p name='account_type' class=""> {{$account->account_type}}</p>
                    </div>
                    <div class="flex">
                    <label id='account_number_label' for='account_number'><b>IBAN: </b></label>
                        <p name='account_number'> {{$account->account_number}}</p>
                        <input id='senderIBAN' name='account_number' type="hidden" value="{{$account->account_number}}"/>
                    </div>
                    <div class="flex">
                        <label id='balanceLabel' for='balance'><b>Balance: </b> </label>
                        <input id='id' type="hidden" value="{{$account->id}}" />
                        <p name='balance'> {{$account->current_balance}} {{ $account->currency }}</p>
                        <input name='currency' type="hidden" value="{{ $account->currency }}"/>
                    </div>
                <div class="flex flex-col">
                    <label for='recipientIBAN'><b>Recipient IBAN:</b></label>
                    <select id='recipientIBAN' name='recipientIBAN'>
                    @foreach ($checkingAccounts->all() as $account)
                        <option>{{ $account->account_number }}</option>
                    @endforeach
                    </select>
                </div>

                <br>
                <div class='flex'>
                    <input type="hidden" name='accountId' value="{{ $account->id }}" />
                    <input id='amount' class="flex flex-col outline-black" name='transferAmount' type="text"/>
                </div>
                </div>
                <br>
            <account-balance></account-balance>
        </div>
    </div>
    </form>

    <div class="flex justify-center space-x-1.5">
        <form method="POST" id='stockTable'>
            @csrf
        <table id='stockTable'>
            <tr class="table-row space-x-0.5">
                <th>Symbol</th>
                <th>Amount</th>
                <th>Highest price bought</th>
                <th>Money invested</th>
                <th>Current Price</th>
                <th>Difference</th>
            </tr>
            @if (sizeof($shares->all()) > 0)

                @foreach ($shares->all() as $share)
                <tr class="border-solid border-2 border-black-800">
                <td class="border-solid border-2 border-black-800">{{ $share->stock_symbol }}</td>
                <td class="border-solid border-2 border-black-800">{{ $share->amount }}</td>
                <td class="border-solid border-2 border-black-800">{{ $share->price_bought }}</td>
                <td class="border-solid border-2 border-black-800">{{ $share->current_investment }}</td>
                <td class="border-solid border-2 border-black-800">{{ $share->current_price }}</td>
                    @if ($share->difference < 0)
                        <td><p style="color: red;">{{ $share->difference }}%</p></td>
                    @elseif ($share->difference > 0)
                        <td><p style="color: green;">{{ $share->difference }}%</p></td>
                    @elseif ($share->difference == 0)
                        <td><p style="color: black;">{{ $share->difference }}%</p></td>
                    @endif
                    <input id='symbol' name="symbol" type="hidden" value="{{ $share->stock_symbol }}"/>
                    <input id='accountId' name="accountId" type="hidden" value="{{ $account->id }}"/>
                    <td><sell-stock-button></sell-stock-button></td>
                {{-- SELL STONKS --}}
                </tr>
                @endforeach
            @else
                <p>You haven't yet bought any stock</p>
            @endif
        </table>
        </form>
    </div>

    <form method="POST" action="/stock-options">
        @csrf
        <input type="hidden" name='accountId' value="{{ $account->id }}" />
        <br>
        <div class="flex justify-center">
        <button class="bg-blue-800 hover:bg-blue-400 text-white font-bold py-2 px-4 border border-black-700 rounded">Buy Stock</button>
        </div>
    </form>
</div>
@endsection
