<?php

namespace Tests\Unit\Models;

use App\Models\Project;
use App\Models\Status;
use App\Models\Tag;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_fillable_attributes(): void
    {
        $project = new Project([
            'title' => 'My beautiful project',
            'description' => 'My beautiful project',
            'status_id' => 1
        ]);

        $this->assertEquals('My beautiful project', $project->title);
        $this->assertEquals('My beautiful project', $project->description);
        $this->assertEquals(1, $project->status_id);
    }

    public function test_project_belongs_to_owner(): void
    {
        $user = User::factory()->create();
        $project = Project::factory(['owner_id' => $user->id])->create();

        $this->assertInstanceOf(User::class, $project->owner);
        $this->assertEquals($user->id, $project->owner->id);
    }

    public function test_project_belongs_to_status(): void
    {
        $project = Project::factory(['status_id' => 1])->create();

        $this->assertInstanceOf(Status::class, $project->status);
        $this->assertEquals(1, $project->status->id);
    }

    public function test_project_has_one_team(): void
    {
        $project = Project::factory()->create();
        Team::factory(['project_id' => $project->id])->create();

        $this->assertInstanceOf(Team::class, $project->team);
    }

    public function test_project_has_many_tags(): void
    {
        $project = Project::factory()->create();
        Tag::factory(['project_id' => $project->id])->count(3)->create();

        $this->assertInstanceOf(Tag::class, $project->tags->first());
        $this->assertCount(4, $project->tags);
    }
}
