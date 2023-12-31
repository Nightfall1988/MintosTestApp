<?php
use Mockery;
use Illuminate\Http\Request;
use App\Http\Services\AccountService;
use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tests\TestCase;

class AccountServiceTest extends TestCase
{
    private AccountService $accountService;

    protected function setUp(): void
    {
        parent::setUp();
        $account = new Account();
        $this->accountService = new AccountService($account);
        
    }

    public function testExecute()
    {
        $user = Mockery::mock(User::class);
        $this->actingAs($user);

        $accountModelMock = Mockery::spy(Account::class);

        $request = new Request(['currency' => 'USD', 'user_id' => 1]);
        $result = $this->accountService->execute($request);
        $accountModelMock->shouldReceive()->once()->andReturn($result);

        $this->assertInstanceOf(Account::class, $result);

        Mockery::close();
    }

    public function testRetrieveAccounts()
    {
        $user = Mockery::mock(User::class)->makePartial();
        $this->actingAs($user);
        
        $account = Account::factory()->create(['user_id' => 1]);
        $accountCollection = $this->accountService->retrieveAccounts();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $accountCollection);
    }
}
