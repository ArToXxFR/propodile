<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Tests\TestCase;
use \Illuminate\Http\Request;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_listusers_success(): void
    {
        $this->actingAs($user = User::factory()->create(['role' =>  'admin']));

        $response = (new AdminController())->listUsers();

        $this->assertNotNull($response);
        $this->assertInstanceOf(View::class, $response);
    }

    public function test_listbannedusers_success(): void
    {
        $this->actingAs($user = User::factory()->create(['role' =>  'admin']));

        $response = (new AdminController())->listBannedUsers();

        $this->assertNotNull($response);
        $this->assertInstanceOf(View::class, $response);
    }

    public function test_listprojects_success(): void
    {
        $this->actingAs($user = User::factory()->create(['role' =>  'admin']));

        $response = (new AdminController())->listProjects();

        $this->assertNotNull($response);
        $this->assertInstanceOf(View::class, $response);
    }

    public function test_dashboard_success(): void
    {
        $this->actingAs($user = User::factory()->create(['role' =>  'admin']));

        $response = (new AdminController())->dashboard();

        $this->assertNotNull($response);
        $this->assertInstanceOf(View::class, $response);
    }

    public function test_ban_and_unban_success(): void
    {
        $this->actingAs($user = User::factory()->create(['role' =>  'admin']));
        $request = new Request([
           'date' => now()->toDateString()
        ]);

        $response = (new AdminController())->ban($request, $user->id);
        $this->assertNotNull($response);
        $this->assertInstanceOf(RedirectResponse::class, $response);

        $response = (new AdminController())->unban($user->id);
        $this->assertNotNull($response);
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function test_delete_success(): void
    {
        $this->actingAs($user = User::factory()->create(['role' =>  'admin']));

        $response = (new AdminController())->delete($user->id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }
}
