@extends('layouts.app')

@section('title', 'Coupons')

@section('content')
    <div class="flex justify-between items-center">
        <div>
            <h1>Coupons</h1>
            <p class="text-muted">Manage all discount coupons.</p>
        </div>
        <a href="{{ route('coupons.create') }}" class="btn">Create Coupon</a>
    </div>

    <form method="GET" action="{{ route('coupons.index') }}" class="mt-md">
        <div class="flex gap-sm items-center">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                   placeholder="Search by code...">
            <select name="status">
                <option value="">All statuses</option>
                <option value="active" @selected(request('status') === 'active')>Active</option>
                <option value="expired" @selected(request('status') === 'expired')>Expired</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
            </select>
            <button type="submit" class="btn btn-outline">Filter</button>
        </div>
    </form>

    <table class="mt-md">
        <thead>
        <tr>
            <th>Code</th>
            <th>Type</th>
            <th>Value</th>
            <th>Validity</th>
            <th>Min Order</th>
            <th>Uses</th>
            <th>Status</th>
            <th class="text-right">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($coupons as $coupon)
            <tr>
                <td>{{ $coupon->code }}</td>
                <td>{{ ucfirst($coupon->type) }}</td>
                <td>
                    @if($coupon->type === 'percent')
                        {{ $coupon->value }}%
                    @else
                        RM {{ number_format($coupon->value, 2) }}
                    @endif
                </td>
                <td>
                    @if($coupon->start_date)
                        {{ $coupon->start_date->format('Y-m-d') }}
                    @else
                        -
                    @endif
                    –
                    @if($coupon->end_date)
                        {{ $coupon->end_date->format('Y-m-d') }}
                    @else
                        No end
                    @endif
                </td>
                <td>
                    @if($coupon->min_order_amount)
                        RM {{ number_format($coupon->min_order_amount, 2) }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    {{ $coupon->used_count }}
                    @if(!is_null($coupon->max_uses))
                        / {{ $coupon->max_uses }}
                    @endif
                </td>
                <td>
                    @php
                        $now = now()->toDateString();
                        $isExpired = $coupon->end_date && $coupon->end_date->lt($now);
                    @endphp
                    @if(!$coupon->is_active)
                        <span class="badge badge-danger">Inactive</span>
                    @elseif($isExpired)
                        <span class="badge badge-danger">Expired</span>
                    @else
                        <span class="badge badge-success">Active</span>
                    @endif
                </td>
                <td class="text-right">
                    <a href="{{ route('coupons.show', $coupon) }}" class="btn btn-outline" style="font-size: 0.8rem;">View</a>
                    <a href="{{ route('coupons.edit', $coupon) }}" class="btn btn-outline" style="font-size: 0.8rem;">Edit</a>
                    <form action="{{ route('coupons.destroy', $coupon) }}" method="POST" style="display:inline"
                          onsubmit="return confirm('Delete this coupon?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="font-size: 0.8rem;">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">No coupons found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-md">
        {{ $coupons->links() }}
    </div>
@endsection

