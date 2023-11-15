<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\TransactionController;
use App\Http\Services\TransactionService;
use Illuminate\Http\Request;
use Mockery;

class TransactionControllerTest extends TestCase
{
    public function testShow()
    {
        $request = Request::create('/show', 'GET', ['id' => 123]);

        $transactionModelMock = Mockery::mock('overload:' . Transaction::class);
        $transactionModelMock->shouldReceive('where->get')->andReturn(collect());

        $controller = new TransactionController();

        $response = $controller->show($request);

        $this->assertEquals('transactionHistory', $response->name());
        // Add assertions based on your expectations for the 'transactionHistory' view
    }
}
