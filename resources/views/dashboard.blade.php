@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex justify-between items-center">
        <div>
            <h1>Dashboard</h1>
            <p class="text-muted">Overview of your coupon performance.</p>
        </div>
        <a href="{{ route('coupons.create') }}" class="btn">Create Coupon</a>
    </div>

    <div class="stats-grid mt-md">
        <div class="stat-card">
            <div class="stat-label">Total Coupons</div>
            <div class="stat-value">{{ $totalCoupons }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active Coupons</div>
            <div class="stat-value">{{ $activeCoupons }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Expired Coupons</div>
            <div class="stat-value">{{ $expiredCoupons }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Used Count</div>
            <div class="stat-value">{{ $totalUsedCount }}</div>
        </div>
    </div>

    <div class="mt-lg">
        <h2>Quick Actions</h2>
        <div class="mt-sm">
            <a href="{{ route('coupons.index') }}" class="btn btn-outline">Manage Coupons</a>
            <a href="{{ route('coupons.apply-form') }}" class="btn btn-outline">Test Coupon</a>
        </div>
    </div>
@endsection

