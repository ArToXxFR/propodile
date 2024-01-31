<?php

namespace Tests\Unit\Models;

use App\Models\Project;
use App\Models\Status;
use Tests\TestCase;

class StatusTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $status = Status::factory()->create();

        $project1 = Project::factory()->create(['status_id' => $status->id]);
        $project2 = Project::factory()->create(['status_id' => $status->id]);

        $this->assertInstanceOf(Status::class, $project1->status);
        $this->assertInstanceOf(Status::class, $project2->status);

        $this->assertEquals($status->id, $project1->status->id);
        $this->assertEquals($status->id, $project2->status->id);

        $this->assertCount(2, $status->projects);
        $this->assertTrue($status->projects->contains($project1));
        $this->assertTrue($status->projects->contains($project2));
    }
}
