<?php

namespace Tests\Unit\Models;

use App\Models\Project;
use App\Models\Team;
use Tests\TestCase;

class TeamTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_project_method_returns_belongs_to_relation()
    {
        $team = Team::factory()->create();

        Project::factory()->create(['id' => $team->project_id]);

        $relation = $team->project();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $relation);

        $this->assertEquals('project_id', $relation->getForeignKeyName());

        $this->assertEquals('id', $relation->getOwnerKeyName());
    }
}
