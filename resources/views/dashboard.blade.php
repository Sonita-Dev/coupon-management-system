<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Dashboard</h2>
                <p class="mt-1 text-sm text-slate-600">Overview of coupon performance and recent activity.</p>
            </div>
            <a href="{{ route('coupons.create') }}" class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">
                + Create coupon
            </a>
        </div>
    </x-slot>

    <div class="mx-auto mt-8 max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Total coupons</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalCoupons }}</p>
            </div>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
                <p class="text-sm text-emerald-700">Currently active</p>
                <p class="mt-2 text-3xl font-bold text-emerald-800">{{ $activeCoupons }}</p>
            </div>
            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-5 shadow-sm">
                <p class="text-sm text-rose-700">Expired</p>
                <p class="mt-2 text-3xl font-bold text-rose-800">{{ $expiredCoupons }}</p>
            </div>
            <div class="rounded-2xl border border-indigo-200 bg-indigo-50 p-5 shadow-sm">
                <p class="text-sm text-indigo-700">Total redemptions</p>
                <p class="mt-2 text-3xl font-bold text-indigo-800">{{ $totalUsedCount }}</p>
                <p class="mt-1 text-xs text-indigo-700/80">Avg {{ $usageRate }} uses per coupon</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-base font-semibold text-slate-900">Recently created</h3>
                    <a href="{{ route('coupons.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                </div>
                <div class="space-y-3">
                    @forelse ($recentCoupons as $coupon)
                        <div class="rounded-xl border border-slate-100 bg-slate-50 p-3">
                            <p class="font-semibold text-slate-800">{{ $coupon->code }}</p>
                            <p class="mt-1 text-xs text-slate-500">
                                {{ ucfirst($coupon->type) }} • {{ $coupon->type === 'percent' ? $coupon->value.'%' : 'USD '.number_format($coupon->value, 2) }}
                            </p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No coupons created yet.</p>
                    @endforelse
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="mb-4 text-base font-semibold text-slate-900">Top redeemed coupons</h3>
                <div class="space-y-3">
                    @forelse ($topCoupons as $coupon)
                        <div class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50 p-3">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $coupon->code }}</p>
                                <p class="text-xs text-slate-500">{{ ucfirst($coupon->type) }} discount</p>
                            </div>
                            <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">{{ $coupon->used_count }} uses</span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No usage data yet.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
