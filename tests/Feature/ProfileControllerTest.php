<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Http\Controllers\ProfileController;
use App\Http\Services\AccountService;
use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    private ProfileController $profileController;

    protected function setUp(): void
    {
        parent::setUp();
        $accountService = new AccountService(); // You might need to mock this service
        $this->profileController = new ProfileController($accountService);
    }

    public function testIndex()
    {
        $response = $this->profileController->index();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewIs('create-account');
        $this->assertViewHas('currencyCollection');
    }

    public function testStore()
    {
        $request = new Request([
            // Provide necessary request data
        ]);

        // Assuming you have mocked the AccountService and covered its tests
        // You can mock the AccountService if it interacts with external services or databases
        // $this->mock(AccountService::class)->shouldReceive('execute', 'retrieveAccounts')->andReturn('someReturnValue');

        $response = $this->profileController->store($request);

        $this->assertRedirect('/home');
        $this->assertSessionHas('accountCollection');
    }

    public function testShow()
    {
        // Assuming you have mocked the AccountService and covered its tests
        // You can mock the AccountService if it interacts with external services or databases
        // $this->mock(AccountService::class)->shouldReceive('retrieveAccounts')->andReturn('someReturnValue');

        $response = $this->profileController->show();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewIs('home');
        $this->assertViewHas('accountCollection');
    }

    // Add more tests as needed
}