<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Edit coupon</h2>
            <p class="mt-1 text-sm text-slate-600">Update configuration and publishing status.</p>
        </div>
    </x-slot>

    <div class="mx-auto mt-8 max-w-4xl px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('coupons.update', $coupon) }}" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            @method('PUT')
            @include('coupons.form', ['submitLabel' => 'Update'])
        </form>
    </div>
</x-app-layout>
