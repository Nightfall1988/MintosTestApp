<?php

use App\Http\Controllers\TransactionController;
use App\Http\Services\TransactionService;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\View;
use Tests\TestCase;
use App\Models\User;


class TransactionControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $transactionController;

    protected function setUp(): void
    {
        parent::setUp();
        $user = Mockery::mock(User::class)->makePartial();
        $this->actingAs($user);
        $this->mock(TransactionService::class, function ($mock) {
            $mock->shouldReceive('transfer');
        });

        $this->transactionController = new TransactionController();
    }

    public function testSendWithCurrencyMismatch()
    {
        $userSender = User::factory()->create();
        $userRecipient = User::factory()->create();

        $this->actingAs($userSender);

        $accountSender = Account::factory()->create([
            'currency' => 'USD', 
            'user_id' => $userSender->id,
            'current_balance' => 1000, 
        ]);

        $accountRecipient = Account::factory()->create([
            'currency' => 'EUR', 
            'user_id' => $userRecipient->id,
            'current_balance' => 0, 
        ]);

        $request = [
            'id' => $accountSender->id,
            'recipientId' =>  $accountRecipient->id,
            'currency' =>  'MXN',
            'senderCurrency' => $accountSender->currency,
            'transferAmount' => 100,
        ];

        $response = $this->post('/verified-transaction', $request);

        $this->assertEquals(400, $response->status());
        $this->assertTrue($response->original instanceof \Illuminate\View\View);
        $this->assertEquals('errors.currency-mismatch', $response->original->name());
    }

    public function testSendWithCurrencyMatch()
    {
        $userSender = User::factory()->create();
        $userRecipient = User::factory()->create();

        $this->actingAs($userSender);

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

        $request = [
            'id' => $accountSender->id,
            'recipientId' =>  $accountRecipient->id,
            'currency' =>  $accountRecipient->currency,
            'senderCurrency' => $accountSender->currency,
            'transferAmount' => 100,
        ];

        $response = $this->post('/verified-transaction', $request);

        $this->assertEquals(200, $response->status());
        $response->assertViewIs('transactionApproved');
    }

    public function testGetReceiverCurrency()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $accountSender = Account::factory()->create([
            'currency' => 'USD', 
            'user_id' => $user->id,
            'current_balance' => 1000, 
        ]);

        $response = $this->get('/get-reciever-currency/' . $accountSender->id);

        $this->assertEquals(200, $response->status());
        $this->assertEquals('USD', $response->original);
    }

    public function testShow()
    {
        $transactionMock = $this->mock(Transaction::class, function ($mock) {
            $mock->shouldReceive('where')->andReturnSelf();
            $mock->shouldReceive('orWhere')->andReturnSelf();
            $mock->shouldReceive('orderBy')->andReturnSelf();
            $mock->shouldReceive('paginate')->andReturn(collect());
        });

        $response = $this->get('/transaction-history/4');
        $this->assertInstanceOf(\Illuminate\View\View::class, $response->original);
        $response->assertViewIs('transactionHistory');
        $this->assertArrayHasKey('tansactionCollection', $response->getOriginalContent()->getData());
        $this->assertArrayHasKey('accountId', $response->getOriginalContent()->getData());
    }
}
