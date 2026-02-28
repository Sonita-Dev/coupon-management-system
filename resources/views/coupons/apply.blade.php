<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Apply coupon</h2>
            <p class="mt-1 text-sm text-slate-600">Simulate coupon redemption using any live code in your database.</p>
        </div>
    </x-slot>

    <div class="mx-auto mt-8 max-w-4xl space-y-6 px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('coupons.apply') }}" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="code" class="mb-2 block text-sm font-medium text-slate-700">Coupon code</label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}" placeholder="E.g. WELCOME10"
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                    @error('code')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="cart_total" class="mb-2 block text-sm font-medium text-slate-700">Cart total (RM)</label>
                    <input type="number" step="0.01" min="0.01" id="cart_total" name="cart_total" value="{{ old('cart_total') }}" placeholder="0.00"
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                    @error('cart_total')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>
            <button type="submit" class="mt-5 rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Apply</button>
        </form>



        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-base font-semibold text-slate-900">Available active coupons</h3>
            <p class="mt-1 text-sm text-slate-500">These are loaded dynamically from your current coupon records.</p>
            <div class="mt-4 flex flex-wrap gap-2">
                @forelse ($activeCoupons as $coupon)
                    <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-700">
                        {{ $coupon->code }} · {{ $coupon->type === 'percent' ? $coupon->value.'%' : 'RM '.number_format($coupon->value, 2) }}
                    </span>
                @empty
                    <p class="text-sm text-slate-500">No active coupons yet. Create one first.</p>
                @endforelse
            </div>
        </section>

        @if (session('result'))
            @php $result = session('result'); @endphp
            <section class="rounded-2xl border border-indigo-200 bg-indigo-50 p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-indigo-900">Result</h3>
                <dl class="mt-4 grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                    <div><dt class="text-indigo-700/70">Code</dt><dd class="font-semibold text-indigo-900">{{ $result['code'] }}</dd></div>
                    <div><dt class="text-indigo-700/70">Coupon type</dt><dd class="font-semibold text-indigo-900">{{ ucfirst($result['type']) }} ({{ $result['value'] }})</dd></div>
                    <div><dt class="text-indigo-700/70">Cart total</dt><dd class="font-semibold text-indigo-900">RM {{ number_format($result['cart_total'], 2) }}</dd></div>
                    <div><dt class="text-indigo-700/70">Discount</dt><dd class="font-semibold text-indigo-900">RM {{ number_format($result['discount'], 2) }}</dd></div>
                    <div class="sm:col-span-2"><dt class="text-indigo-700/70">New total</dt><dd class="text-xl font-bold text-indigo-900">RM {{ number_format($result['new_total'], 2) }}</dd></div>
                </dl>
            </section>
        @endif
    </div>
</x-app-layout>
