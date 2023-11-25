<?php
namespace App\Http\Controllers;
use App\Http\Services\AccountService;
use Illuminate\Http\Request;
use App\Models\Currency;

class AccountController extends Controller
{
    public function __construct(AccountService $accountService)
    {
        $this->service = $accountService;
    }

    public function show(Request $request) 
    {
        $currencyCollection = Currency::all();
        
        $account = $this->service->findAccountById($request->id);
        return view('userAccount', compact('account', 'currencyCollection')); // RETURN CHECKING ACCOUNT VIEW
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
