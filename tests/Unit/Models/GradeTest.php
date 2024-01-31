<?php

namespace Tests\Unit\Models;

use App\Models\Grade;
use App\Models\User;
use Tests\TestCase;

class GradeTest extends TestCase
{
    public function test_users_method_returns_has_many_relation()
    {
        $grade = Grade::factory()->create();

        User::factory(3)->create(['grade_id' => $grade->id]);

        $relation = $grade->users();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $relation);

        $this->assertEquals('grade_id', $relation->getForeignKeyName());

        $this->assertEquals('id', $relation->getLocalKeyName());
    }
}
