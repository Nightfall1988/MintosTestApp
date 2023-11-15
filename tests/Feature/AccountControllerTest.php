<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\AccountController;
use App\Http\Services\AccountService;
use Illuminate\Http\Request;
use Mockery;

class AccountControllerTest extends TestCase
{
    public function testShowInvestmentAccount()
    {
        $accountServiceMock = Mockery::mock(AccountService::class);
        $accountServiceMock->shouldReceive('findAccount')->andReturn((object)['account_type' => 'Investment']);
        $accountServiceMock->shouldReceive('findShares');
        $accountServiceMock->shouldReceive('getCheckingAccounts');

        $controller = new AccountController($accountServiceMock);

        $request = Request::create('/show', 'GET', ['account_number' => '123']);
        $response = $controller->show($request);

        $this->assertEquals('investmentAccount', $response->name());
    }

    public function testShowCheckingAccount()
    {
        $accountServiceMock = Mockery::mock(AccountService::class);
        $accountServiceMock->shouldReceive('findAccount')->andReturn((object)['account_type' => 'Checking']);

        $controller = new AccountController($accountServiceMock);

        $request = Request::create('/show', 'GET', ['account_number' => '456']);
        $response = $controller->show($request);

        $this->assertEquals('checkingAccount', $response->name());
    }

    public function testVerifyTransaction()
    {
        $accountServiceMock = Mockery::mock(AccountService::class);
        $accountServiceMock->shouldReceive('sendMoney');

        $controller = new AccountController($accountServiceMock);

        $request = Request::create('/verifyTransaction', 'POST', ['transferAmount' => 100, 'currency' => 'USD']);
        $response = $controller->verifyTransaction($request);

        $this->assertEquals('verification', $response->name());
        $this->assertEquals(100, $response->getData()['transferAmount']);
        $this->assertEquals('USD', $response->getData()['currency']);
    }

    public function testBalance()
    {
        $accountServiceMock = Mockery::mock(AccountService::class);
        $accountServiceMock->shouldReceive('findAccountById')->andReturn((object)['current_balance' => 500]);

        $controller = new AccountController($accountServiceMock);

        $request = Request::create('/balance', 'GET', ['id' => 789]);
        $response = $controller->balance($request);

        $this->assertEquals(500, $response);
    }
}