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
                                <a href="{{ route('test', ['selected' => $friend['email']]) }}" class="border-2 m-1 relative">
                                    <p class="text-lg">{{ $friend['name'] }}</p>
                                    <p class="text-md opacity-30">{{ $friend['email'] }}</p>
                                    <form method="POST" action="{{ route('addFriend') }}" class="p-1">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ $friend['email'] }}">
                                        <button
                                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                            добавить друга</button>
                                    </form>
                                    <form method="POST" action="{{ route('blockFriend') }}" class="p-1">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ $friend['email'] }}">
                                        <button
                                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                            удалить друга</button>
                                    </form>
                                </a>
                            @break

                            @case('pester')
                                <a href="{{ route('test', ['selected' => $friend['email']]) }}"
                                    class="border-2 m-1 relative border-success">
                                    <p class="text-lg">{{ $friend['name'] }}</p>
                                    <p class="text-md opacity-30">{{ $friend['email'] }}</p>
                                    <form method="POST" action="{{ route('blockFriend') }}" class="p-1">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ $friend['email'] }}">
                                        <button
                                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                            удалить друга</button>
                                    </form>
                                </a>
                            @break

                            @case('declined')
                                <a href="{{ route('test', ['selected' => $friend['email']]) }}"
                                    class="border-2 m-1 relative border-error">
                                    <p class="text-lg">{{ $friend['name'] }}</p>
                                    <p class="text-md opacity-30">{{ $friend['email'] }}</p>
                                    <form method="POST" action="{{ route('blockFriend') }}" class="p-1">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ $friend['email'] }}">
                                        <button
                                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                            удалить друга</button>
                                    </form>
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
        <div class="border-2 border-user w-screen m-1">
            чата нет
        </div>
    </div>
</x-app-layout>
