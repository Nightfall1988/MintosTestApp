<?php

use App\Http\Services\TransactionService;
use App\Models\Account;
use App\Models\Currency;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;

class TransactionServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testCheckCurrencyWithSameCurrency()
    {
        $userSender = User::factory()->create();
        $userRecipient = User::factory()->create();

        $accountSender = Account::factory()->create([
            'currency' => 'USD', 
            'user_id' => $userSender->id,
            'current_balance' => 1000, 
        ]);

        $accountRecipient = Account::factory()->create([
            'currency' => 'USD', 
            'user_id' => $userRecipient->id,
            'current_balance' => 0, 
        ]);

        $transactionService = new TransactionService($accountSender->id, $accountRecipient->id, 100);
        $result = $transactionService->checkCurrency();

        $this->assertTrue($result);
    }

    public function testSaveToHistory()
    {
        $userSender = User::factory()->create();
        $userRecipient = User::factory()->create();

        $accountSender = Account::factory()->create([
            'currency' => 'USD', 
            'user_id' => $userSender->id,
            'current_balance' => 1000, 
        ]);

        $accountRecipient = Account::factory()->create([
            'currency' => 'USD', 
            'user_id' => $userRecipient->id,
            'current_balance' => 0, 
        ]);
        $transactionService = new TransactionService($accountSender->id, $accountRecipient->id, 100);

        Auth::loginUsingId($userSender->id);

        $transactionService->transfer();

        $this->assertDatabaseHas('transactions', [
            'client_id' => $accountSender->user_id,
            'sender_id' => $accountSender->id,
            'recipient_id' => $accountRecipient->id,
            'amount' => 100,
            'currency' => 'USD',
        ]);
    }
}
