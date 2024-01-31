<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Tag;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'owner_id' => User::factory()->create()->id,
            'status_id' => 1,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Project $project) {
            Tag::factory()->create(['project_id' => $project->id]);
            Team::factory()->create(['project_id' => $project->id, 'name' => $project->title, 'user_id' => $project->owner_id]);
        });
    }
}
