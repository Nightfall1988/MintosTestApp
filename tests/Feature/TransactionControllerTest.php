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
        $accountMock = $this->mock(Account::class, function ($mock) {
            $mock->shouldReceive('getAttribute')->andReturn('USD'); // Adjust as needed
        });

        $request = [
            'recipientId' => 1,
            'currency' => 'EUR',
        ];

        $response = $this->post('/verified-transaction', $request);

        $this->assertTrue($response->original instanceof \Illuminate\View\View);
        $this->assertEquals(400, $response->status());
        $this->assertEquals('errors.currency-mismatch', $response->original->name());
    }

    public function testSendWithCurrencyMatch()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $accountMock = $this->mock(Account::class, function ($mock) {
            $mock->shouldReceive('getAttribute')->andReturn('USD');
        });

        $request = [
            'id' => 4,
            'recipientId' => 2,
            'currency' => 'USD',
            'senderCurrency' => 'USD',
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
        $accountMock = $this->mock(Account::class, function ($mock) {
            $mock->shouldReceive('getAttribute')->andReturn('USD');
        });

        $response = $this->get('/get-reciever-currency/1');

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
