<nav x-data="{ open: false }" class="border-2 border-user w-fit absolute right-0" style="background: white;">
    {{-- border-user border-admin => сделать автоподкидывание цвета в зависимости от режима --}}
    <!-- Logo-button -->
    <div class="flex items-center flex-row-reverse justify-between">
        <button @click="open = ! open">
            <x-application-logo class="block h-9 fill-current" />
        </button>
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden">Menu =></div>
    </div>
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="null" :active="request()->routeIs('NULL')">
                {{ __('OtherLink') }}
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
    </div>
</nav>
