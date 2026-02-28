@extends('layouts.app')

@section('title', 'Coupon Details')

@section('content')
    <div class="flex justify-between items-center">
        <h1>Coupon Details</h1>
        <a href="{{ route('coupons.index') }}" class="btn btn-outline">Back to list</a>
    </div>

    <div class="mt-md">
        <table>
            <tbody>
            <tr>
                <th>Code</th>
                <td>{{ $coupon->code }}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>{{ ucfirst($coupon->type) }}</td>
            </tr>
            <tr>
                <th>Value</th>
                <td>
                    @if($coupon->type === 'percent')
                        {{ $coupon->value }}%
                    @else
                        RM {{ number_format($coupon->value, 2) }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $coupon->description }}</td>
            </tr>
            <tr>
                <th>Start Date</th>
                <td>{{ $coupon->start_date?->format('Y-m-d') ?? '-' }}</td>
            </tr>
            <tr>
                <th>End Date</th>
                <td>{{ $coupon->end_date?->format('Y-m-d') ?? 'No end date' }}</td>
            </tr>
            <tr>
                <th>Minimum Order Amount</th>
                <td>
                    @if($coupon->min_order_amount)
                        RM {{ number_format($coupon->min_order_amount, 2) }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Max Uses</th>
                <td>{{ $coupon->max_uses ?? 'Unlimited' }}</td>
            </tr>
            <tr>
                <th>Used Count</th>
                <td>{{ $coupon->used_count }}</td>
            </tr>
            <tr>
                <th>Status</th>
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
            </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-md">
        <a href="{{ route('coupons.edit', $coupon) }}" class="btn">Edit</a>
        <form action="{{ route('coupons.destroy', $coupon) }}" method="POST" style="display:inline"
              onsubmit="return confirm('Delete this coupon?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
@endsection

