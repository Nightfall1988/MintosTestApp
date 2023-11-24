@extends('layouts.app')

@section('content')
<div id='container' class="border-solid border-4 mt-10">
    <form method="GET" action="/home">
        @csrf
        <div class="flex justify-center space-x-1.5">
            <table>
                <tr class="table-row space-x-0.5">
                    <th>Sender account ID</th>
                    <th>Amount</th>
                    <th>Currency</th>
                    <th>Recipient Account ID</th>
                    <th>Transaction Time</th>
                </tr>
        @foreach ($tansactionCollection->all() as $transaction)
                <tr class="border-solid border-2 border-blue-800">
                <td class="border-solid border-2 border-blue-800">{{ $transaction->sender_id }}</td>
                <td class="border-solid border-2 border-blue-800">{{ $transaction->amount }}</td>
                <td class="border-solid border-2 border-blue-800">{{ $transaction->currency }}</td>
                <td class="border-solid border-2 border-blue-800">{{ $transaction->recipient_id }}</td>
                <td class="border-solid border-2 border-blue-800">{{ $transaction->created_at }}</td>
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
