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
        $account = $this->service->findAccount($request->account_number);
        if ($account->account_type == 'Investment') {
            $shares = $this->service->findShares($request->accountId);
            $checkingAccounts = $this->service->getCheckingAccounts();
            return view('investmentAccount', compact('account', 'shares', 'checkingAccounts')); // RETURN INVESTMENT ACCOUNT VIEW
        } else {
            return view('checkingAccount', compact('account')); // RETURN CHECKING ACCOUNT VIEW
        }
    }

    public function verifyTransaction(Request $request)
    {
        $transferAmount = $request->transferAmount;
        $currency = $request->currency;
        $this->service->sendMoney($transferAmount, $currency);
        return view('verification', compact('transferAmount', 'currency'));
    }


    public function balance(Request $request)
    {
        $account = $this->service->findAccountById($request->id);
        return $account->current_balance;
    }
}
