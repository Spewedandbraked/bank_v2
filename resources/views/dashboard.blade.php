<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-row">
        <div class="relative m-1 h-min">
            <x-anyMenu :z='10'>
                <x-slot name="text">
                    {{ __('ВВедите email кореша ') }}
                </x-slot>
                <x-slot name="svg">
                    <x-svg.AddFriend />
                </x-slot>

                <form method="POST" action="{{ route('addFriend') }}" class="p-1">
                    @csrf

                    <x-text-input name="email" class="block" />
                    <x-primary-button :href="route('addFriend')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        ==></x-primary-button>
                </form>
            </x-anyMenu>
            <div class="border-2 border-user w-80 flex flex-col ">
                <span class='text-center'>Кореша:</span>
                @isset($friends)
                    @foreach ($friends as $friend)
                        @switch($friend->getOriginal('pivot_state'))
                            @case('pending')
                                <a href="{{ route('viewUser', ['selected' => $friend['email']]) }}" class="border-2 m-1 relative">
                                    <p class="text-lg">{{ $friend['name'] }}</p>
                                    <p class="text-md opacity-30">{{ $friend['email'] }}</p>
                                </a>
                            @break

                            @case('pester')
                                <a href="{{ route('viewUser', ['selected' => $friend['email']]) }}"
                                    class="border-2 m-1 relative border-success">
                                    <p class="text-lg">{{ $friend['name'] }}</p>
                                    <p class="text-md opacity-30">{{ $friend['email'] }}</p>
                                </a>
                            @break

                            @case('declined')
                                <a href="{{ route('viewUser', ['selected' => $friend['email']]) }}"
                                    class="border-2 m-1 relative border-error">
                                    <p class="text-lg">{{ $friend['name'] }}</p>
                                    <p class="text-md opacity-30">{{ $friend['email'] }}</p>
                                </a>
                            @break

                            @default
                                дерьмо сломалось? - срочно скажите мне на spewedandbraked@gmail.com
                        @endswitch
                    @endforeach
                @else
                    <div class="p-4 opacity-40">
                        {{ __('Корешей нет!') }}
                    </div>
                @endisset
            </div>
        </div>
        <div>

        </div>
        <div class="border-2 border-user w-screen m-1 relative">
            @isset($selectedUser)
                @isset($selectedFriend)
                    <div class="absolute z-10 right-[-2px] top-[-2px]">
                        {{-- <span class='text-center'>Статус дружбы:</span> --}}
                        <x-anyMenu :z='10'>
                            <x-slot name="text">
                                {{ __('Дружба ==> ') }}
                            </x-slot>
                            <x-slot name="svg">
                                <x-svg.Status />
                            </x-slot>
                            <div class="w-60 pt-4 pb-1 border-t border-gray-200">
                                <div class="px-4">
                                    <div class="font-medium text-base text-gray-800">Статус: {{ $selectedFriend['state'] }}
                                    </div>
                                </div>
                                <div class="mt-3 space-y-1">
                                    <form method="POST" action="{{ route('addFriend') }}"
                                        class="block w-full ps-3 pe-4 py-2 border-l-4 text-gray-600">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ $selectedUser['email'] }}">
                                        <button
                                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                            добавить друга</button>
                                    </form>
                                    <form method="POST" action="{{ route('blockFriend') }}"
                                        class="block w-full ps-3 pe-4 py-2 border-l-4 text-gray-600">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ $selectedUser['email'] }}">
                                        <button
                                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                            заблокировать друга</button>
                                    </form>
                                </div>
                            </div>
                        </x-anyMenu>
                    </div>
                @else
                    <form method="POST" action="{{ route('addFriend') }}"
                        class="block ps-3 pe-4 py-2 border-t-4 text-gray-600 w-fit absolute right-[-2px] top-[-2px]">
                        @csrf
                        <input type="hidden" name="email" value="{{ $selectedUser['email'] }}">
                        <button
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            добавить друга</button>
                    </form>
                @endisset
                <p class="text-lg">Имя: {{ __($selectedUser['name']) }}</p>
                <p class="text-lg">Емейл: {{ __($selectedUser['email']) }}</p>
            @else
                {{ __('TODO: если не выбрано - отобразить смешное меню с крутыми функциями типо кенты недавно зареганные и тому подобное...') }}
                <br><br><br>
                {{ __('Выберите друга, выбор в меню слева <==') }}
            @endisset
        </div>
    </div>
</x-app-layout>
