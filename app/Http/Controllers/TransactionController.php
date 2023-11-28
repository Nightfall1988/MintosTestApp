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

        $recipientAccount = Account::where('id', $request->recipientId)->first();

        if ($recipientAccount->currency != $request->currency) {
            return response()->view('errors.currency-mismatch', [], 400);
        } else {
            $currency = $request->senderCurrency;
            $recipientId = $request->recipientId;
            $senderId = $request->id;
            $amount = floatval($request->transferAmount);
            $this->service = new TransactionService($senderId, $recipientId, $amount);
            $this->service->transfer();
            return view('transactionApproved', compact('amount', 'currency'));
        }
    }

    public function getRecieverCurrency($recipientId) {
        $account = Account::where('id','=', $recipientId)->first();
        if ($account == null) {
            return '0';
        } else {
            return $account->currency;
        }
    }

    public function show($accountId)
    {
        $tansactionCollection = Transaction::where('sender_id', $accountId)
        ->orWhere('recipient_id', $accountId)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('transactionHistory', compact('tansactionCollection', 'accountId'));
    }
}

