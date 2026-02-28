@csrf

<div class="form-group">
    <label for="code">Code</label>
    <input type="text" id="code" name="code" value="{{ old('code', $coupon->code ?? '') }}" class="form-control">
    @error('code')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="type">Type</label>
    <select id="type" name="type" class="form-control">
        <option value="fixed" @selected(old('type', $coupon->type ?? 'fixed') === 'fixed')>Fixed amount</option>
        <option value="percent" @selected(old('type', $coupon->type ?? 'fixed') === 'percent')>Percentage</option>
    </select>
    @error('type')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="value">Value</label>
    <input type="number" step="0.01" id="value" name="value" value="{{ old('value', $coupon->value ?? '') }}" class="form-control">
    @error('value')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="description">Description</label>
    <input type="text" id="description" name="description" value="{{ old('description', $coupon->description ?? '') }}" class="form-control">
    @error('description')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="start_date">Start Date</label>
    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', optional($coupon->start_date ?? null)->format('Y-m-d')) }}" class="form-control">
    @error('start_date')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="end_date">End Date</label>
    <input type="date" id="end_date" name="end_date" value="{{ old('end_date', optional($coupon->end_date ?? null)->format('Y-m-d')) }}" class="form-control">
    @error('end_date')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="min_order_amount">Minimum Order Amount</label>
    <input type="number" step="0.01" id="min_order_amount" name="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount ?? '') }}" class="form-control">
    @error('min_order_amount')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="max_uses">Max Uses (leave empty for unlimited)</label>
    <input type="number" id="max_uses" name="max_uses" value="{{ old('max_uses', $coupon->max_uses ?? '') }}" class="form-control">
    @error('max_uses')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>
        <input type="checkbox" name="is_active" value="1"
            {{ old('is_active', $coupon->is_active ?? true) ? 'checked' : '' }}>
        Active
    </label>
    @error('is_active')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mt-md">
    <button type="submit" class="btn">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('coupons.index') }}" class="btn btn-outline">Cancel</a>
</div>

