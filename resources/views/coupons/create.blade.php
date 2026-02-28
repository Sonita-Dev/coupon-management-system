<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Create coupon</h2>
            <p class="mt-1 text-sm text-slate-600">Define discount rules and availability window.</p>
        </div>
    </x-slot>

    <div class="mx-auto mt-8 max-w-4xl px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('coupons.store') }}" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            @include('coupons.form', ['submitLabel' => 'Create'])
        </form>
    </div>
</x-app-layout>
