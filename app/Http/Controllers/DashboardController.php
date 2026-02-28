<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalCoupons = Coupon::count();

        $activeCoupons = Coupon::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now()->toDateString());
            })
            ->count();

        $expiredCoupons = Coupon::whereNotNull('end_date')
            ->where('end_date', '<', now()->toDateString())
            ->count();

        $totalUsedCount = Coupon::sum('used_count');

        return view('dashboard', compact(
            'totalCoupons',
            'activeCoupons',
            'expiredCoupons',
            'totalUsedCount'
        ));
    }
}

