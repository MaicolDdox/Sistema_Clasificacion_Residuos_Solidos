<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Areas\Models\Area;
use Modules\ProductiveUnits\Models\ProductiveUnit;
use Modules\Wastes\Models\HazardouWaste;
use Modules\Wastes\Models\Waste;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_authenticated_users_can_visit_the_dashboard(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/dashboard')->assertStatus(200);
    }

    public function test_dashboard_exposes_expected_aggregates_and_series(): void
    {
        $authUser = User::factory()->create();
        $this->actingAs($authUser);

        $anotherUserWithoutRole = User::factory()->create();
        $userWithRole = User::factory()->create();

        $role = Role::create([
            'name' => 'Test Dashboard Role',
            'guard_name' => 'web',
        ]);
        $userWithRole->assignRole($role);

        $area = Area::create([
            'name' => 'Area Test Dashboard',
            'description' => null,
        ]);

        $unitA = ProductiveUnit::create([
            'area_id' => $area->id,
            'name' => 'Unidad A',
            'description' => null,
        ]);
        $unitB = ProductiveUnit::create([
            'area_id' => $area->id,
            'name' => 'Unidad B',
            'description' => null,
        ]);
        $unitC = ProductiveUnit::create([
            'area_id' => $area->id,
            'name' => 'Unidad C',
            'description' => null,
        ]);

        Waste::create([
            'productive_unit_id' => $unitA->id,
            'user_id' => $authUser->id,
            'entry_date' => now(),
            'waste_type' => 'Residuo Organico',
            'amount' => 10,
            'observations' => null,
        ]);
        Waste::create([
            'productive_unit_id' => $unitA->id,
            'user_id' => $anotherUserWithoutRole->id,
            'entry_date' => now(),
            'waste_type' => 'Residuo Ordinarios',
            'amount' => 15,
            'observations' => null,
        ]);
        Waste::create([
            'productive_unit_id' => $unitC->id,
            'user_id' => $authUser->id,
            'entry_date' => now(),
            'waste_type' => 'Residuo Reciclables',
            'amount' => 5,
            'observations' => null,
        ]);

        HazardouWaste::create([
            'productive_unit_id' => $unitA->id,
            'user_id' => $authUser->id,
            'entry_date' => now(),
            'waste_type' => 'Residuo Quimico',
            'amount' => 7,
            'observations' => null,
        ]);
        HazardouWaste::create([
            'productive_unit_id' => $unitB->id,
            'user_id' => $userWithRole->id,
            'entry_date' => now(),
            'waste_type' => 'Residuo Biologico',
            'amount' => 9,
            'observations' => null,
        ]);

        $response = $this->get('/dashboard');

        $response
            ->assertStatus(200)
            ->assertViewIs('dashboard::index')
            ->assertViewHas('totalResol', 30)
            ->assertViewHas('totalRespel', 16)
            ->assertViewHas('totalUsersWithoutRole', 2)
            ->assertViewHas('pieSeries', [30, 16])
            ->assertViewHas('unitLabels', ['Unidad A', 'Unidad B', 'Unidad C'])
            ->assertViewHas('resolByUnitSeries', [25, 0, 5])
            ->assertViewHas('respelByUnitSeries', [7, 9, 0]);
    }

    public function test_dashboard_handles_units_without_waste_records_with_zero_series(): void
    {
        $authUser = User::factory()->create();
        $this->actingAs($authUser);

        $area = Area::create([
            'name' => 'Area Zero Data',
            'description' => null,
        ]);

        ProductiveUnit::create([
            'area_id' => $area->id,
            'name' => 'Unidad Zero A',
            'description' => null,
        ]);
        ProductiveUnit::create([
            'area_id' => $area->id,
            'name' => 'Unidad Zero B',
            'description' => null,
        ]);

        $response = $this->get('/dashboard');

        $response
            ->assertStatus(200)
            ->assertViewHas('totalResol', 0)
            ->assertViewHas('totalRespel', 0)
            ->assertViewHas('totalUsersWithoutRole', 1)
            ->assertViewHas('pieSeries', [0, 0])
            ->assertViewHas('unitLabels', ['Unidad Zero A', 'Unidad Zero B'])
            ->assertViewHas('resolByUnitSeries', [0, 0])
            ->assertViewHas('respelByUnitSeries', [0, 0]);
    }

    public function test_dashboard_verification_middleware_behavior_for_unverified_users(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        if ($user instanceof MustVerifyEmail) {
            $response->assertRedirect(route('verification.notice', absolute: false));
            return;
        }

        $response->assertOk();
    }
}
