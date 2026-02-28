<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'type' => 'percent',
                'value' => 10,
                'description' => '10% off for new customers',
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(20),
                'min_order_amount' => 50,
                'max_uses' => 100,
                'used_count' => 10,
                'is_active' => true,
            ],
            [
                'code' => 'WELCOME20',
                'type' => 'percent',
                'value' => 20,
                'description' => '20% off limited time',
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(5),
                'min_order_amount' => 100,
                'max_uses' => 50,
                'used_count' => 5,
                'is_active' => true,
            ],
            [
                'code' => 'FLAT5',
                'type' => 'fixed',
                'value' => 5,
                'description' => 'RM 5 off any order',
                'start_date' => now()->subDays(30),
                'end_date' => now()->addDays(30),
                'min_order_amount' => 0,
                'max_uses' => null,
                'used_count' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'FLAT20',
                'type' => 'fixed',
                'value' => 20,
                'description' => 'RM 20 off orders above RM 150',
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(10),
                'min_order_amount' => 150,
                'max_uses' => 20,
                'used_count' => 3,
                'is_active' => true,
            ],
            [
                'code' => 'EXPIRED10',
                'type' => 'percent',
                'value' => 10,
                'description' => 'Expired coupon (for testing)',
                'start_date' => now()->subDays(20),
                'end_date' => now()->subDays(1),
                'min_order_amount' => 50,
                'max_uses' => 10,
                'used_count' => 2,
                'is_active' => true,
            ],
            [
                'code' => 'INACTIVE5',
                'type' => 'fixed',
                'value' => 5,
                'description' => 'Inactive coupon (for testing)',
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(5),
                'min_order_amount' => 20,
                'max_uses' => 10,
                'used_count' => 0,
                'is_active' => false,
            ],
            [
                'code' => 'FUTURE15',
                'type' => 'percent',
                'value' => 15,
                'description' => 'Not yet started coupon (for testing)',
                'start_date' => now()->addDays(3),
                'end_date' => now()->addDays(30),
                'min_order_amount' => 80,
                'max_uses' => 100,
                'used_count' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'LIMITED3',
                'type' => 'fixed',
                'value' => 30,
                'description' => 'Limited to 3 uses (for testing over-used case)',
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(10),
                'min_order_amount' => 100,
                'max_uses' => 3,
                'used_count' => 3,
                'is_active' => true,
            ],
            [
                'code' => 'MINORDER200',
                'type' => 'percent',
                'value' => 25,
                'description' => 'Requires minimum order RM 200 (for testing)',
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(30),
                'min_order_amount' => 200,
                'max_uses' => null,
                'used_count' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'BIGSALE50',
                'type' => 'percent',
                'value' => 50,
                'description' => '50% off big sale',
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(1),
                'min_order_amount' => 300,
                'max_uses' => 100,
                'used_count' => 20,
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $data) {
            Coupon::create($data);
        }
    }
}

