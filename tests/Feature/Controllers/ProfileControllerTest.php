<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_userprofile_success(): void
    {
        $this->actingAs($user = User::factory()->create());

        $response = (new ProfileController())->show($user->username);

        $this->assertNotNull($response);
        $this->assertInstanceOf(View::class, $response);

    }

    public function test_userprofile_not_found(): void
    {
        $response = (new ProfileController())->show($this->faker->word());

        $this->assertNotNull($response);
        $this->assertInstanceOf(Response::class, $response);
    }
}
