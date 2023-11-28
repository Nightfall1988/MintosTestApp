<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Http\Controllers\ProfileController;
use App\Http\Services\AccountService;
use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\User;
use Mockery;

class ProfileControllerTest extends TestCase
{
    private ProfileController $profileController;

    protected function setUp(): void
    {
        parent::setUp();
        $account = new Account;
        $accountService = new AccountService($account);
        $this->profileController = new ProfileController($accountService);
        $user = Mockery::mock(User::class)->makePartial();
        $this->actingAs($user);
    }

    public function testIndex()
    {
        $response = $this->get('/create-account');
        $response->assertViewIs('create-account');
        $response->assertViewHas('currencyCollection');
    }

    public function testStore()
    {
        $request = [
            'user_id' => rand(1,100),
            'currency' => 'MXN'
        ];

        $response = $this->post('/save', $request);

        $response->assertRedirect('/home');
        $response->assertSessionHas('accountCollection');
    }

    public function testShow()
    {
        $response = $this->get('/home');

        $response->assertOk();
        $response->assertViewIs('home');
        $response->assertViewHas('accountCollection');
    }
}