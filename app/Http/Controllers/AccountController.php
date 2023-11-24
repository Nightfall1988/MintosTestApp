<?php
namespace App\Http\Controllers;
use App\Http\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(AccountService $accountService)
    {
        $this->service = $accountService;
    }

    public function show(Request $request) 
    {
        $account = $this->service->findAccountById($request->id);
        return view('checkingAccount', compact('account')); // RETURN CHECKING ACCOUNT VIEW
    }

    public function verifyTransaction(Request $request)
    {
        $transferAmount = $request->transferAmount;
        $currency = $request->currency;
        $this->service->sendMoney($transferAmount, $currency);
        return view('verification', compact('transferAmount', 'currency'));
    }


    public function balance($id)
    {
        $account = $this->service->findAccountById($id);
        return $account->current_balance;
    }
}
