<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Http\Controllers\TransactionController;
use App\Http\Services\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    private TransactionController $transactionController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transactionController = new TransactionController();
    }

    public function testSendWithCurrencyMismatch()
    {
        $request = new Request([
            'recipientId' => 1,
            'currency' => 'USD',
            'senderCurrency' => 'EUR',
            'id' => 2,
            'transferAmount' => 100,
        ]);

        $response = $this->transactionController->send($request);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertViewIs('errors.currency-mismatch');
    }

    public function testSendWithCurrencyMatch()
    {
        $request = new Request([
            'recipientId' => 1,
            'currency' => 'USD',
            'senderCurrency' => 'USD',
            'id' => 2,
            'transferAmount' => 100,
        ]);

        // Assuming you have mocked the TransactionService and covered its tests
        // You can mock the TransactionService if it interacts with external services or databases
        // $this->mock(TransactionService::class)->shouldReceive('transfer');

        $response = $this->transactionController->send($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewIs('transactionApproved');
    }

    public function testGetRecieverCurrencyWithValidRecipientId()
    {
        $account = factory(Account::class)->create(['currency' => 'USD']);

        $currency = $this->transactionController->getRecieverCurrency($account->id);

        $this->assertEquals('USD', $currency);
    }

    public function testGetRecieverCurrencyWithInvalidRecipientId()
    {
        $currency = $this->transactionController->getRecieverCurrency(999);

        $this->assertEquals('0', $currency);
    }

    // Add more tests for the show and sellStock methods as needed
}
