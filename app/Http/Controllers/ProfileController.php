<?php

namespace App\Http\Controllers;
use App\Http\Services\AccountService;
use App\Models\Account;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private AccountService $service;

    public function __construct(AccountService $accountService)
    {
        $this->service = $accountService;
    }

    public function index() 
    {
        // ADD CURRENCY
        Artisan::call('currency:import');
        $currencyCollection = Currency::all();
        return view('create-account', compact('currencyCollection'));
    }

    public function store(Request $request) 
    {
        $this->service->execute($request);
        $accountCollection = $this->service->retrieveAccounts();
        if ($accountCollection) {
            return redirect('/home')->with('accountCollection',$accountCollection);
        }
    }

    public function show() 
    {
        $accountCollection = $this->service->retrieveAccounts();
        return view('home', compact('accountCollection'));
    }
}
