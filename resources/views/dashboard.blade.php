<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500 uppercase tracking-wide">Total Coupons</div>
                        <div class="mt-2 text-2xl font-bold text-gray-900">{{ $totalCoupons }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500 uppercase tracking-wide">Active Coupons</div>
                        <div class="mt-2 text-2xl font-bold text-emerald-600">{{ $activeCoupons }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500 uppercase tracking-wide">Expired Coupons</div>
                        <div class="mt-2 text-2xl font-bold text-red-600">{{ $expiredCoupons }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500 uppercase tracking-wide">Total Used Count</div>
                        <div class="mt-2 text-2xl font-bold text-indigo-600">{{ $totalUsedCount }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage coupons or test applying a coupon on a fake cart.
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('coupons.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Manage Coupons
                        </a>
                        <a href="{{ route('coupons.apply-form') }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700">
                            Test Coupon
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
