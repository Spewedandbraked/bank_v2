<x-anyMenu :z='50'>
    <x-slot name="text">
        {{ __('Menu ==>') }}
    </x-slot>
    <x-slot name="svg">
        <x-application-logo class="block h-9 fill-current" />
    </x-slot>

    <div class="pt-2 pb-3 space-y-1 sm:hidden">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('moneybox')" :active="request()->routeIs('moneybox')">
            {{ __('Moneybox') }}
        </x-responsive-nav-link>
    </div>
    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-gray-200">
        <div class="px-4">
            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
        </div>

        <div class="mt-3 space-y-1">
            <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</x-anyMenu>

<div class="absolute right-10 flex hidden sm:flex">
    <x-responsive-nav-link-bottom :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-responsive-nav-link-bottom>
    <x-responsive-nav-link-bottom :href="route('moneybox')" :active="request()->routeIs('moneybox')">
        {{ __('Moneybox') }}
    </x-responsive-nav-link-bottom>
</div>
