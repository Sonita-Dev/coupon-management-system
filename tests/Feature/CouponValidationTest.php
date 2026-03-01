<?php

namespace Tests\Feature;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CouponValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_coupon_code_can_be_reused_after_soft_delete(): void
    {
        $user = User::factory()->create();

        $coupon = Coupon::create([
            'code' => '2028',
            'type' => 'fixed',
            'value' => 12,
            'is_active' => true,
        ]);

        $coupon->delete();

        $response = $this
            ->actingAs($user)
            ->post(route('coupons.store'), [
                'code' => '2028',
                'type' => 'fixed',
                'value' => 15,
                'is_active' => true,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('coupons.index'));

        $this->assertDatabaseHas('coupons', [
            'code' => '2028',
            'value' => 15,
            'deleted_at' => null,
        ]);
    }

    public function test_coupon_code_must_still_be_unique_among_non_deleted_records(): void
    {
        $user = User::factory()->create();

        Coupon::create([
            'code' => '2028',
            'type' => 'fixed',
            'value' => 12,
            'is_active' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->from(route('coupons.create'))
            ->post(route('coupons.store'), [
                'code' => '2028',
                'type' => 'fixed',
                'value' => 15,
                'is_active' => true,
            ]);

        $response
            ->assertRedirect(route('coupons.create'))
            ->assertSessionHasErrors('code');
    }
}
