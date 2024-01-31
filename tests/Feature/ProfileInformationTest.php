<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_current_profile_information_is_available(): void
    {
        $this->actingAs($user = User::factory()->create());

        $component = Livewire::test(UpdateProfileInformationForm::class);

        $this->assertEquals($user->username, $component->state['username']);
        $this->assertEquals($user->email, $component->state['email']);
    }

    public function test_profile_information_can_be_updated(): void
    {
        $this->actingAs($user = User::factory()->create());

        Livewire::test(UpdateProfileInformationForm::class)
            ->set('state', ['username' => 'Test Name', 'email' => 'test@example.com', 'description' => 'Test desc', 'grade_id' => '1'])
            ->call('updateProfileInformation');

        $this->assertEquals('Test Name', $user->fresh()->username);
        $this->assertEquals('test@example.com', $user->fresh()->email);
        $this->assertEquals('Test desc', $user->fresh()->description);
        $this->assertEquals('1', $user->fresh()->grade_id);
    }
}
