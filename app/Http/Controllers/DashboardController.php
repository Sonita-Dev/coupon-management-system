<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = now()->toDateString();

        $totalCoupons = Coupon::count();

        $activeCoupons = Coupon::where('is_active', true)
            ->where(function ($query) use ($today) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $today);
            })
            ->count();

        $expiredCoupons = Coupon::whereNotNull('end_date')
            ->where('end_date', '<', $today)
            ->count();

        $totalUsedCount = Coupon::sum('used_count');

        $usageRate = $totalCoupons > 0
            ? round(($totalUsedCount / $totalCoupons), 1)
            : 0;

        $recentCoupons = Coupon::query()
            ->latest()
            ->limit(5)
            ->get();

        $topCoupons = Coupon::query()
            ->orderByDesc('used_count')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalCoupons',
            'activeCoupons',
            'expiredCoupons',
            'totalUsedCount',
            'usageRate',
            'recentCoupons',
            'topCoupons'
        ));
    }
}
