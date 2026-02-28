@extends('layouts.app')

@section('title', 'Test Coupon')

@section('content')
    <h1>Test / Apply Coupon</h1>
    <p class="text-muted">Use this page to simulate applying a coupon to a fake cart.</p>

    <form method="POST" action="{{ route('coupons.apply') }}" class="mt-md">
        @csrf
        <div class="form-group">
            <label for="code">Coupon code</label>
            <input type="text" id="code" name="code" value="{{ old('code') }}" class="form-control">
            @error('code')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="cart_total">Cart total (RM)</label>
            <input type="number" step="0.01" id="cart_total" name="cart_total"
                   value="{{ old('cart_total', 100) }}" class="form-control">
            @error('cart_total')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn">Apply Coupon</button>
    </form>

    @if (session('result'))
        @php $result = session('result'); @endphp
        <div class="mt-lg">
            <h2>Result</h2>
            <table>
                <tbody>
                <tr>
                    <th>Code</th>
                    <td>{{ $result['code'] }}</td>
                </tr>
                <tr>
                    <th>Cart Total</th>
                    <td>RM {{ number_format($result['cart_total'], 2) }}</td>
                </tr>
                <tr>
                    <th>Discount</th>
                    <td>RM {{ number_format($result['discount'], 2) }}</td>
                </tr>
                <tr>
                    <th>New Total</th>
                    <td>RM {{ number_format($result['new_total'], 2) }}</td>
                </tr>
                <tr>
                    <th>Coupon Type</th>
                    <td>{{ ucfirst($result['type']) }} ({{ $result['value'] }})</td>
                </tr>
                </tbody>
            </table>
        </div>
    @endif
@endsection

