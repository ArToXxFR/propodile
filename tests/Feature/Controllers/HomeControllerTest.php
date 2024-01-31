<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\View\View;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_home_success(): void
    {
        $response = (new HomeController())->index();

        $this->assertNotNull($response);
        $this->assertInstanceOf(View::class, $response);
    }
}
