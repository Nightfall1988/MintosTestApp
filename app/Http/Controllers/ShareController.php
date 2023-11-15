<?php

namespace App\Http\Controllers;
use App\Models\Share;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Services\ShareService;
use App\Models\Account;

class ShareController extends Controller
{
    public ShareService $shareService;

    public function __construct(ShareService $shareService)
    {
        $this->shareService = $shareService;
    }

    public function index(Request $request)
    {
        $shares = $this->shareService->getShares($request);
        $account = Account::where('id', $shares->all()[0]->account_id)->first();
        return view('investmentAccount', compact('account', 'shares'));
    }

    public function sell()
    {
        
    }
}