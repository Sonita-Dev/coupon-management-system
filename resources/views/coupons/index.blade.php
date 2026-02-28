<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Coupons</h2>
                <p class="mt-1 text-sm text-slate-600">Create, edit, and monitor all discount codes.</p>
            </div>
            <a href="{{ route('coupons.create') }}" class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">+ New coupon</a>
        </div>
    </x-slot>

    <div class="mx-auto mt-8 max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('coupons.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-4">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by coupon code..."
                    class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 md:col-span-2" />
                <select name="status" class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                    <option value="">All statuses</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="expired" @selected(request('status') === 'expired')>Expired</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                </select>
                <button type="submit" class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100">Apply filter</button>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-xs uppercase tracking-wider text-slate-500">
                            <th class="px-4 py-3">Code</th>
                            <th class="px-4 py-3">Discount</th>
                            <th class="px-4 py-3">Validity</th>
                            <th class="px-4 py-3">Min Order</th>
                            <th class="px-4 py-3">Usage</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($coupons as $coupon)
                            @php
                                $isExpired = $coupon->end_date && $coupon->end_date->isPast();
                                $status = ! $coupon->is_active ? 'Inactive' : ($isExpired ? 'Expired' : 'Active');
                            @endphp
                            <tr class="text-slate-700">
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-slate-900">{{ $coupon->code }}</p>
                                    <p class="text-xs text-slate-500">{{ $coupon->description ?: 'No description' }}</p>
                                </td>
                                <td class="px-4 py-3">{{ $coupon->type === 'percent' ? $coupon->value.'%' : 'RM '.number_format($coupon->value, 2) }}</td>
                                <td class="px-4 py-3 text-xs text-slate-600">
                                    {{ $coupon->start_date?->format('Y-m-d') ?? 'No start' }} → {{ $coupon->end_date?->format('Y-m-d') ?? 'No end' }}
                                </td>
                                <td class="px-4 py-3">{{ $coupon->min_order_amount ? 'RM '.number_format($coupon->min_order_amount, 2) : '-' }}</td>
                                <td class="px-4 py-3">{{ $coupon->used_count }}{{ is_null($coupon->max_uses) ? '' : ' / '.$coupon->max_uses }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $status === 'Active' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">{{ $status }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('coupons.show', $coupon) }}" class="rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">View</a>
                                        <a href="{{ route('coupons.edit', $coupon) }}" class="rounded-lg border border-indigo-200 bg-indigo-50 px-2.5 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-100">Edit</a>
                                        <form method="POST" action="{{ route('coupons.destroy', $coupon) }}" onsubmit="return confirm('Delete this coupon?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1.5 text-xs font-medium text-rose-700 hover:bg-rose-100">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">No coupons found for current filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>{{ $coupons->links() }}</div>
    </div>
</x-app-layout>
