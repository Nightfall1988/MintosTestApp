<?php
namespace App\Http\Services;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Share;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class AccountService 
{
    private Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }
    public function execute(Request $request)
    {
        $accountNumber = $this->createAccountNumber();
        while ($this->checkIfUniqueAccount($accountNumber) == true) 
        {
            $accountNumber = $this->createAccountNumber();
        }

        $this->account->user_id = Auth::user()->id;
        $this->account->current_balance = 0;
        $this->account->account_type = $request->type;
        $this->account->account_number = $accountNumber;
        $this->account->currency = $request->currency;
        $this->account->save();
    }

    public function createAccountNumber() {
        $accountNumber = '';
    
        for($i = 0; $i < 19; $i++) {
            $accountNumber .= mt_rand(0, 9);
        }
        $accountNumber = 'NB' . $accountNumber;

        return $accountNumber;
    }

    public function checkIfUniqueAccount(string $accountNumber)
    {
        if (Account::where('account_number', '=', $accountNumber)->exists()) {
            return true;
         } else {
             return false;
         }
    }

    public function retrieveAccounts()
    {
        $accountCollection = Account::where('user_id', Auth::user()->id)->get();
        return $accountCollection;
    }

    public function findAccount(string $accountNr)
    {
        $account = Account::where('account_number', $accountNr)->first();
        return $account;
    }

    public function findShares($id)
    {
        $shareCollection = Share::where('account_id', $id)->get();
        return $shareCollection;
    }

    public function findAccountById($id)
    {
        $account = Account::where('id', $id)->first();
        return $account;
    }

    public function getCheckingAccounts()
    {
        $accountCollection = Account::where('user_id',  Auth::user()->id)->where('account_type', 'Checking')->get();
        return $accountCollection;
    }
}

?>
