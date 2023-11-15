<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use App\Http\Services\TransactionService;
use App\Models\TransactionHistory;
use App\Models\Account;
use App\Models\Transaction;

class TransactionController extends Controller
{
    private TransactionService $service;

    public function send(Request $request)
    {
        $currency = $request->senderCurrency;
        $recipientIBAN = $request->recipientIBAN;
        $senderIBAN = $request->account_number;
        $amount = floatval($request->transferAmount);
        $this->service = new TransactionService($senderIBAN, $recipientIBAN, $amount);
        $this->service->transfer();
        return view('transactionApproved', compact('amount', 'currency'));
    }

    public function show(Request $request)
    {
        $id = $request->id;
        $tansactionCollection = Transaction::where('sender_id', $id)->get();

        return view('transactionHistory', compact('tansactionCollection'));
    }

    public function sellStock(Request $request)
    {
        $data = (json_decode(array_keys($_POST)[0], true));
        
        return ($data);
    }
}

