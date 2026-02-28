@extends('layouts.app')

@section('title', 'Edit Coupon')

@section('content')
    <h1>Edit Coupon</h1>
    <form method="POST" action="{{ route('coupons.update', $coupon) }}" class="mt-md">
        @method('PUT')
        @include('coupons.form', ['submitLabel' => 'Update'])
    </form>
@endsection

