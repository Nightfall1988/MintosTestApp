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
        $this->account->user_id = $request->user_id;
        $this->account->current_balance = 0;
        $this->account->currency = $request->currency;
        $this->account->save();
        return $this->account;
    }

    public function retrieveAccounts()
    {
        $accountCollection = Account::where('user_id', Auth::user()->id)->get();
        return $accountCollection;
    }

    public function findAccountById($id)
    {
        $account = Account::where('id', $id)->first();
        return $account;
    }
}

?>
