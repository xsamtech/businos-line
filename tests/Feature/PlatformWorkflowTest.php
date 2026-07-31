<?php

namespace Tests\Feature;

use App\Models\AboutSubject;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PlatformWorkflowTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_first_visit_creates_multilingual_reference_data(): void
    {
        $this->get('/')->assertOk();
        $this->assertSame(3, Role::count());
        $this->assertSame(3, AboutSubject::count());
        $this->assertSame('Administrateur', Role::where('slug', 'administrator')->firstOrFail()->getTranslation('role_name', 'fr'));
    }

    public function test_member_cannot_access_admin_but_administrator_can(): void
    {
        $this->get('/');
        $member = User::factory()->create();
        $this->actingAs($member)->get('/admin')->assertForbidden();
        $member->roles()->attach(Role::where('slug', 'administrator')->firstOrFail(), ['assigned_at' => now()]);
        $this->actingAs($member)->get('/admin')->assertOk();
    }

    public function test_uuid_is_generated_and_used_for_route_binding(): void
    {
        $user = User::factory()->create();
        $this->assertNotEmpty($user->uuid);
        $this->assertSame($user->uuid, $user->getRouteKey());
    }
}
