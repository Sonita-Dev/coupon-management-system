@extends('layouts.app')

@section('title', 'Create Coupon')

@section('content')
    <h1>Create Coupon</h1>
    <form method="POST" action="{{ route('coupons.store') }}" class="mt-md">
        @include('coupons.form', ['submitLabel' => 'Create'])
    </form>
@endsection

