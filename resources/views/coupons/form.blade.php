@csrf

<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div>
        <label for="code" class="mb-2 block text-sm font-medium text-slate-700">Code</label>
        <input type="text" id="code" name="code" value="{{ old('code', $coupon->code ?? '') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required>
        @error('code')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="type" class="mb-2 block text-sm font-medium text-slate-700">Discount type</label>
        <select id="type" name="type" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
            <option value="fixed" @selected(old('type', $coupon->type ?? 'fixed') === 'fixed')>Fixed amount</option>
            <option value="percent" @selected(old('type', $coupon->type ?? 'fixed') === 'percent')>Percentage</option>
        </select>
        @error('type')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="value" class="mb-2 block text-sm font-medium text-slate-700">Discount</label>
        <input type="number" step="0.01" id="value" name="value" value="{{ old('value', $coupon->value ?? '') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required>
        @error('value')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="description" class="mb-2 block text-sm font-medium text-slate-700">Description</label>
        <input type="text" id="description" name="description" value="{{ old('description', $coupon->description ?? '') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
        @error('description')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="start_date" class="mb-2 block text-sm font-medium text-slate-700">Start date</label>
        <input type="date" id="start_date" name="start_date" value="{{ old('start_date', optional($coupon->start_date ?? null)->format('Y-m-d')) }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
        @error('start_date')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="end_date" class="mb-2 block text-sm font-medium text-slate-700">End date</label>
        <input type="date" id="end_date" name="end_date" value="{{ old('end_date', optional($coupon->end_date ?? null)->format('Y-m-d')) }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
        @error('end_date')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="min_order_amount" class="mb-2 block text-sm font-medium text-slate-700">Minimum order amount</label>
        <input type="number" step="0.01" id="min_order_amount" name="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount ?? '') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
        @error('min_order_amount')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="max_uses" class="mb-2 block text-sm font-medium text-slate-700">Max uses</label>
        <input type="number" id="max_uses" name="max_uses" value="{{ old('max_uses', $coupon->max_uses ?? '') }}"
            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
        @error('max_uses')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>
</div>

<label class="mt-5 flex items-center gap-2 text-sm text-slate-700">
    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $coupon->is_active ?? true) ? 'checked' : '' }} class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
    Coupon is active
</label>
@error('is_active')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('coupons.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Cancel</a>
</div>
