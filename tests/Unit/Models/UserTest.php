<?php

namespace Tests\Unit\Models;

use App\Models\Grade;
use App\Models\Project;
use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_user_has_many_projects_relation()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['owner_id' => $user->id]);

        $this->assertInstanceOf(Project::class, $user->projects->first());
        $this->assertEquals($project->id, $user->projects()->first()->id);

        $this->assertInstanceOf(User::class, $project->owner);
        $this->assertEquals($user->id, $project->owner->id);
    }

    public function test_user_belongs_to_grade_relation()
    {
        $user = User::factory()->create();

        $grade = Grade::factory()->create();

        $this->assertInstanceOf(Grade::class, $user->grade);
    }
}
