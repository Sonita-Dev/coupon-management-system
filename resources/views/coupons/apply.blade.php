<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Test Coupon') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Test / Apply Coupon</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Use this page to simulate applying a coupon to a fake cart amount.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('coupons.apply') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700">
                                Coupon code
                            </label>
                            <input
                                type="text"
                                id="code"
                                name="code"
                                value="{{ old('code') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            />
                            @error('code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cart_total" class="block text-sm font-medium text-gray-700">
                                Cart total (RM)
                            </label>
                            <input
                                type="number"
                                step="0.01"
                                id="cart_total"
                                name="cart_total"
                                value="{{ old('cart_total', 100) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            />
                            @error('cart_total')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700">
                            Apply Coupon
                        </button>
                    </form>

                    @if (session('result'))
                        @php $result = session('result'); @endphp
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <h4 class="text-sm font-semibold text-gray-800 mb-3">Result</h4>
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                                <div>
                                    <dt class="text-gray-500">Code</dt>
                                    <dd class="font-medium text-gray-900">{{ $result['code'] }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Coupon Type</dt>
                                    <dd class="font-medium text-gray-900">
                                        {{ ucfirst($result['type']) }} ({{ $result['value'] }})
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Cart Total</dt>
                                    <dd class="font-medium text-gray-900">
                                        RM {{ number_format($result['cart_total'], 2) }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Discount</dt>
                                    <dd class="font-medium text-emerald-700">
                                        RM {{ number_format($result['discount'], 2) }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">New Total</dt>
                                    <dd class="font-semibold text-indigo-700">
                                        RM {{ number_format($result['new_total'], 2) }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>