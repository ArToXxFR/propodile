<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\ProjectController;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;
use Illuminate\View\View;
use Exception;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_create_method_redirects_on_success(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.png');

        $request = new Request([
            'title' => 'Test Project',
            'description' => 'Test description',
            'image' => $file,
            'status_id' => 1,
            'owner_id' => 1
        ]);

        $response = (new ProjectController())->create($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());

        $project_id = Project::latest('id')->first()->id;

        $this->assertDatabaseHas('projects', [
            'id' => $project_id,
            'title' => 'Test Project',
            'description' => 'Test description',
            'status_id' => 1,
        ]);
    }

    public function test_create_method_redirects_on_validation_failure(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $request = new Request([
            'title' => 'Test Project',
            'description' => 'Test description',
            'status_id' => 'Robert',
            'image' => null,
            'owner_id' => $user->id
        ]);

        $response = (new ProjectController())->create($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    public function test_create_method_redirects_on_exception(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $request = new Request([
            'title' => 'Test Project',
            'description' => 'Test description',
            'status_id' => 1,
            'image' => $this->faker->image(),
            'owner_id' => $user->id
        ]);

        $this->mock(ProjectController::class, function ($mock) use ($request) {
            $mock->shouldReceive('create')->andThrow(new \Exception($request));
        });

        $response = (new ProjectController())->create($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());

    }

    public function test_delete_method_redirects_on_success(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create(['owner_id' => $user->id]);

        $projectId = $project->id;

        $response = (new ProjectController())->delete($projectId);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    public function test_delete_method_redirects_on_exception(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create();

        $projectId = $project->id;

        $response = (new ProjectController())->delete($projectId);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_delete_method_redirects_on_not_found(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $projectId = 999999;

        $response = (new ProjectController())->delete($projectId);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function test_show_method_redirects_on_success(): void
    {
        $project = Project::factory()->create();

        $response = (new ProjectController())->show($project->id);

        $this->assertInstanceOf(View::class, $response);
    }

    public function test_show_method_redirects_on_not_found(): void
    {
        $response = (new ProjectController())->show(99999999);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function test_index_method_redirects_on_exception(): void
    {
        $this->mock(ProjectController::class, function ($mock) {
            $mock->shouldReceive('index')->andThrow(new \Mockery\Exception('Erreur simulée'));
        });

        $response = (new ProjectController())->index();

        $this->assertInstanceOf(View::class, $response);
    }

    public function test_update_method_redirects_on_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create(['owner_id' => $user->id]);

        $request = new Request([
            'title' => 'Test Project',
            'description' => 'Test description',
            'image' => $this->faker->image(),
            'status_id' => 1,
        ]);

        $response = (new ProjectController())->update($request, $project->id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(302, $response->getStatusCode());

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Test Project',
            'description' => 'Test description',
            'status_id' => 1,
        ]);
    }

    public function test_update_method_redirects_on_gate_fail()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create();

        $request = new Request([
            'title' => 'Test Project',
            'description' => 'Test description',
            'image' => $this->faker->image(),
            'status_id' => 1,
        ]);

        $response = (new ProjectController())->update($request, $project->id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    public function test_update_method_redirects_on_validator_fail()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create(['owner_id' => $user->id]);

        $request = new Request([
            'title' => 'Test Project',
            'description' => 'Test description',
            'image' => $this->faker->image(),
            'status_id' => 'Robert',
        ]);

        $response = (new ProjectController())->update($request, $project->id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    public function test_update_method_redirects_on_not_found()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $request = new Request([
            'title' => 'Test Project',
            'description' => 'Test description',
            'image' => $this->faker->image(),
            'status_id' => 'Robert',
        ]);

        $response = (new ProjectController())->update($request, 99999);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function test_get_update_form_method_redirects_on_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create(['owner_id' => $user->id]);


        $response = (new ProjectController())->updateForm($project->id);

        $this->assertInstanceOf(View::class, $response);
    }

    public function test_get_update_form_method_redirects_on_not_found()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create(['owner_id' => $user->id]);


        $response = (new ProjectController())->updateForm(9999999);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function test_get_update_form_method_redirects_on_gate_fail()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create();

        $response = (new ProjectController())->updateForm($project->id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

}
