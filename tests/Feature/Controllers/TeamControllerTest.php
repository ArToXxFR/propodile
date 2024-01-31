<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use App\Models\Project;
use App\Models\Team;
use App\Models\TeamJoinRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Tests\TestCase;

class TeamControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_sendInvitation_successfully_sends_invitation(): void
    {
        $this->actingAs($user = User::factory()->create());
        $project = Project::factory()->create();

        $request = new Request(['id' => $project->id]);

        $response = (new TeamController())->sendInvitation($request);

        $this->assertNotNull($response);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    public function test_sendInvitation_not_found(): void
    {
        $this->actingAs($user = User::factory()->create());

        $request = new Request(['id' => 999999]);

        $response = (new TeamController())->sendInvitation($request);

        $this->assertNotNull($response);
        $this->assertInstanceOf(Response::class, $response);
    }

    public function test_sendInvitation_cant_send_mail(): void
    {
        $this->actingAs($user = User::factory()->create());
        $project = Project::factory()->create(['owner_id' => $user->id]);

        $request = new Request(['id' => $project->id]);

        $response = (new TeamController())->sendInvitation($request);

        $this->assertNotNull($response);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    public function test_acceptInvitation_success(): void
    {
        $this->actingAs($user = User::factory()->create());
        $fakeuser = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id]);

        TeamJoinRequest::create([
            'team_id' => $team->id,
            'user_id' => $fakeuser->id,
        ]);

        $response = (new TeamController())->acceptInvitation($team->id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    public function test_acceptInvitation_gate_fail(): void
    {
        $this->actingAs($user = User::factory()->create());
        $team = Team::factory()->create();

        TeamJoinRequest::create([
            'team_id' => $team->id,
            'user_id' => $user->id,
        ]);

        $response = (new TeamController())->acceptInvitation($team->id);

        $this->assertNotNull($response);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    public function test_acceptInvitation_not_found(): void
    {
        $this->actingAs($user = User::factory()->create());

        $response = (new TeamController())->acceptInvitation(9999999);

        $this->assertNotNull($response);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function test_dashboard_success(): void
    {
        $this->actingAs($user = User::factory()->create());

        $response = (new TeamController())->dashboard();

        $this->assertNotNull($response);
        $this->assertInstanceOf(View::class, $response);
    }
}
