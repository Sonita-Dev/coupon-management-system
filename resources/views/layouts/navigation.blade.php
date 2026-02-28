<nav x-data="{ open: false }" class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="rounded-xl bg-indigo-600 p-2 text-white shadow-lg shadow-indigo-200">
                        <x-application-logo class="h-5 w-5 fill-current" />
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Coupon CMS</p>
                        <p class="text-xs text-slate-500">Management console</p>
                    </div>
                </a>

                <div class="hidden items-center gap-2 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('coupons.index')" :active="request()->routeIs('coupons.*')">
                        {{ __('Coupons') }}
                    </x-nav-link>
                    <x-nav-link :href="route('coupons.apply-form')" :active="request()->routeIs('coupons.apply-form')">
                        {{ __('Apply Test') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-700">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            {{ Auth::user()->name }}
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <button @click="open = ! open" class="inline-flex items-center justify-center rounded-md p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 sm:hidden">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-slate-200 bg-white sm:hidden">
        <div class="space-y-1 px-4 py-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Dashboard') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('coupons.index')" :active="request()->routeIs('coupons.*')">{{ __('Coupons') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('coupons.apply-form')" :active="request()->routeIs('coupons.apply-form')">{{ __('Apply Test') }}</x-responsive-nav-link>
        </div>

        <div class="border-t border-slate-200 px-4 py-4">
            <p class="text-sm font-medium text-slate-800">{{ Auth::user()->name }}</p>
            <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
