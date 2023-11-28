<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    protected $homeController;

    public function setUp(): void
    {
        parent::setUp();
        $this->homeController = new HomeController();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testIndex()
    {
        $this->mockMiddleware('auth');
        $response = $this->homeController->index();
        $this->assertEquals('home', $response->name());
    }

    protected function mockMiddleware($middleware)
    {
        $this->app['router']->middlewareGroup($middleware, []);
        $this->homeController->middleware($middleware);
    }
}