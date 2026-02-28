<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Coupons') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Manage all discount coupons.</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Search by code or filter by status to quickly find the coupon you need.
                            </p>
                        </div>
                        <a href="{{ route('coupons.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700">
                            Create Coupon
                        </a>
                    </div>

                    <form method="GET" action="{{ route('coupons.index') }}"
                          class="flex flex-col md:flex-row md:items-end gap-3 mb-4">
                        <div class="flex-1">
                            <label for="q" class="block text-sm font-medium text-gray-700 mb-1">
                                Search by code
                            </label>
                            <input
                                type="text"
                                id="q"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="e.g. WELCOME10"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            />
                        </div>

                        <div class="w-full md:w-48">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                Status
                            </label>
                            <select
                                id="status"
                                name="status"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            >
                                <option value="">All statuses</option>
                                <option value="active" @selected(request('status') === 'active')>Active</option>
                                <option value="expired" @selected(request('status') === 'expired')>Expired</option>
                                <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                            </select>
                        </div>

                        <div class="flex items-end gap-2">
                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md text-sm font-medium text-white hover:bg-gray-900"
                            >
                                Filter
                            </button>
                            @if(request('q') || request('status'))
                                <a href="{{ route('coupons.index') }}"
                                   class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left font-semibold text-gray-700">Code</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-700">Type</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-700">Value</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-700">Validity</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-700">Min Order</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-700">Uses</th>
                                <th class="px-3 py-2 text-left font-semibold text-gray-700">Status</th>
                                <th class="px-3 py-2 text-right font-semibold text-gray-700">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($coupons as $coupon)
                                <tr>
                                    <td class="px-3 py-2 font-mono text-xs text-gray-900">
                                        {{ $coupon->code }}
                                    </td>
                                    <td class="px-3 py-2 text-gray-700">
                                        {{ ucfirst($coupon->type) }}
                                    </td>
                                    <td class="px-3 py-2 text-gray-700">
                                        @if($coupon->type === 'percent')
                                            {{ number_format($coupon->value, 0) }}%
                                        @else
                                            RM {{ number_format($coupon->value, 2) }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-gray-700">
                                        @if($coupon->start_date)
                                            {{ $coupon->start_date->format('Y-m-d') }}
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                        <span class="text-gray-300">–</span>
                                        @if($coupon->end_date)
                                            {{ $coupon->end_date->format('Y-m-d') }}
                                        @else
                                            <span class="text-gray-400">No end</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-gray-700">
                                        @if($coupon->min_order_amount)
                                            RM {{ number_format($coupon->min_order_amount, 2) }}
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-gray-700">
                                        {{ $coupon->used_count }}
                                        @if(!is_null($coupon->max_uses))
                                            <span class="text-gray-400 text-xs">/ {{ $coupon->max_uses }}</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        @php $isExpired = $coupon->end_date && $coupon->end_date->isPast(); @endphp
                                        @if(!$coupon->is_active)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                Inactive
                                            </span>
                                        @elseif($isExpired)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                Expired
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                                Active
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-right space-x-1">
                                        <a href="{{ route('coupons.show', $coupon) }}"
                                           class="inline-flex items-center px-2 py-1 border border-gray-300 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50">
                                            View
                                        </a>
                                        <a href="{{ route('coupons.edit', $coupon) }}"
                                           class="inline-flex items-center px-2 py-1 border border-indigo-300 rounded-md text-xs font-medium text-indigo-700 hover:bg-indigo-50">
                                            Edit
                                        </a>
                                        <form action="{{ route('coupons.destroy', $coupon) }}" method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Delete this coupon?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-2 py-1 border border-red-300 rounded-md text-xs font-medium text-red-700 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-3 py-6 text-center text-sm text-gray-500">
                                        No coupons found. Try adjusting your search or filters.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $coupons->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>