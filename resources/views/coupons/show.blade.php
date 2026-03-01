<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Coupon details</h2>
                <p class="mt-1 text-sm text-slate-600">Inspect coupon configuration and usage status.</p>
            </div>
            <a href="{{ route('coupons.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Back</a>
        </div>
    </x-slot>

    @php
        $isExpired = $coupon->end_date && $coupon->end_date->lt(today());
        $status = ! $coupon->is_active ? 'Inactive' : ($isExpired ? 'Expired' : 'Active');
    @endphp

    <div class="mx-auto mt-8 max-w-4xl space-y-5 px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <dl class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">
                <div><dt class="text-slate-500">Code</dt><dd class="font-semibold text-slate-900">{{ $coupon->code }}</dd></div>
                <div><dt class="text-slate-500">Type</dt><dd class="font-semibold text-slate-900">{{ ucfirst($coupon->type) }}</dd></div>
                <div><dt class="text-slate-500">Value</dt><dd class="font-semibold text-slate-900">{{ $coupon->type === 'percent' ? $coupon->value.'%' : 'USD '.number_format($coupon->value, 2) }}</dd></div>
                <div><dt class="text-slate-500">Status</dt><dd><span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $status === 'Active' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">{{ $status }}</span></dd></div>
                <div><dt class="text-slate-500">Start date</dt><dd class="font-semibold text-slate-900">{{ $coupon->start_date?->format('Y-m-d') ?? '-' }}</dd></div>
                <div><dt class="text-slate-500">End date</dt><dd class="font-semibold text-slate-900">{{ $coupon->end_date?->format('Y-m-d') ?? 'No end date' }}</dd></div>
                <div><dt class="text-slate-500">Minimum order</dt><dd class="font-semibold text-slate-900">{{ $coupon->min_order_amount ? 'USD '.number_format($coupon->min_order_amount, 2) : '-' }}</dd></div>
                <div><dt class="text-slate-500">Usage</dt><dd class="font-semibold text-slate-900">{{ $coupon->used_count }}{{ is_null($coupon->max_uses) ? ' (unlimited)' : ' / '.$coupon->max_uses }}</dd></div>
                <div class="md:col-span-2"><dt class="text-slate-500">Description</dt><dd class="font-semibold text-slate-900">{{ $coupon->description ?: 'No description provided.' }}</dd></div>
            </dl>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('coupons.edit', $coupon) }}" class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">Edit</a>
            <form method="POST" action="{{ route('coupons.destroy', $coupon) }}" onsubmit="return confirm('Delete this coupon?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-100">Delete</button>
            </form>
        </div>
    </div>
</x-app-layout>
