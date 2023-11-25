@extends('layouts.app')

@section('content')
<div id='container' class="border-solid border-4 mt-10">
    <form method="GET" action="/home">
        @csrf
        <div class="flex justify-center space-x-1.5">
            <table>
                <tr class="table-row space-x-0.5">
                    <th class="p-2">Transaction type</th>
                    <th class="p-2">Sender account ID</th>
                    <th class="p-2">Amount</th>
                    <th class="p-2">Currency</th>
                    <th class="p-2">Recipient Account ID</th>
                    <th class="p-2">Transaction Time</th>
                </tr>
        @foreach ($tansactionCollection->all() as $transaction)
        <tr class="border-solid border-2 border-blue-800">

                @if ($transaction->sender_id == $accountId)
                    <td class="border-solid border-2 border-blue-800 p-2">Sent</td>
                @elseif ($transaction->recipient_id == $accountId)
                    <td class="border-solid border-2 border-blue-800 p-2">Received</td>
                @endif
                <td class="border-solid border-2 border-blue-800 p-2">{{ $transaction->sender_id }}</td>
                <td class="border-solid border-2 border-blue-800 p-2">{{ $transaction->amount }}</td>
                <td class="border-solid border-2 border-blue-800 p-2">{{ $transaction->currency }}</td>
                <td class="border-solid border-2 border-blue-800 p-2">{{ $transaction->recipient_id }}</td>
                <td class="border-solid border-2 border-blue-800 p-2">{{ date('d-M-Y H:i:s', strtotime($transaction->created_at)) }}</td>
                </tr>
        @endforeach
            </table>
        </div>
        <br>
        <div class="flex justify-center mt-4">
            {{ $tansactionCollection->links() }}
        </div>
        <br>
        <div class="flex justify-center">
        <button class="bg-green-800 hover:bg-green-600 text-white font-bold py-2 px-4 border border-black-700 rounded ml-10 mt-3 mb-10">Back to Homepage</button>
        </div>
    </form>
</div>
@endsection
