<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use App\Http\Services\TransactionService;
use App\Models\TransactionHistory;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    private TransactionService $service;

    public function send(Request $request)
    {
        $currency = $request->senderCurrency;
        $recipientId = $request->recipientId;
        $senderId = $request->id;
        $amount = floatval($request->transferAmount);
        $this->service = new TransactionService($senderId, $recipientId, $amount);
        $this->service->transfer();
        return view('transactionApproved', compact('amount', 'currency'));
    }

    public function show(Request $request)
    {
        $id = Auth::id();
        $tansactionCollection = Transaction::where('client_id', $id)->orderBy('created_at', 'desc')->paginate(10);

        return view('transactionHistory', compact('tansactionCollection'));
    }

    public function sellStock(Request $request)
    {
        $data = (json_decode(array_keys($_POST)[0], true));
        
        return ($data);
    }
}

