<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl text-gray-800 leading-tight">
            {{ __('Moneybox / Piggy bank') }}
        </h2>
    </x-slot>

    <div class="flex flex-row">
        <div class="relative m-1 h-min">
            <x-anyMenu :z='10'>
                <x-slot name="text">
                    {{ __('Придумайте название') }}
                </x-slot>
                <x-slot name="svg">
                    <x-svg.Create />
                </x-slot>

                <form method="POST" action="{{ route('createCheck') }}" class="p-1">
                    @csrf

                    <x-text-input name="cardName" class="block" />
                    <x-primary-button :href="route('createCheck')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        ==></x-primary-button>
                </form>
            </x-anyMenu>
            <div class="border-2 border-user w-80 flex flex-col ">
                <span class='text-center'>Счета:</span>
                @isset($checks)
                    @foreach ($checks as $check)
                        <a href="{{ url('moneybox', ['selected' => $check['id']]) }}" class="border-2 m-1 relative">
                            <p class="text-lg">{{ $check['name'] }}</p>
                            <p class="text-sm opacity-30">{{ $check['id'] }}</p>
                        </a>
                    @endforeach
                @else
                    <div class="p-4 opacity-40">
                        {{ __('Счетов нет! вон там ^^ тот плюсик для создания нового') }}
                    </div>
                @endisset
            </div>
        </div>
        <div class="border-2 border-user w-screen m-1">

            <p class="text-sm opacity-15">боже так не хочу щас дизайн делать потом будет</p>
            @isset($selected)
                <p class="text-lg">Счет: {{ __($selected['name']) }}</p>
                <p class="text-lg">Деняг: {{ __($selected['money']) }}</p>
                <p class="text-sm opacity-40">Сcылка счета: {{ __($selected['id']) }}</p>
                <x-menuButton>
                    <x-slot name="text">
                        {{ __('Перевести $$$') }}
                    </x-slot>
                    <form method="POST" action="{{ route('createCheck') }}" class="p-1">
                        @csrf

                        <x-text-input name="cardName" class="block " />
                        <x-primary-button :href="route('createCheck')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            ==></x-primary-button>
                    </form>
                </x-menuButton>
                <x-menuButton>
                    <x-slot name="text">
                        {{ __('Поменять данные') }}
                    </x-slot>
                    <form method="POST" action="{{ route('createCheck') }}" class="p-1 flex flex-wrap">
                        @csrf

                        <x-text-input name="cardName" class="block" />
                        <x-primary-button :href="route('createCheck')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            ЗАМЕНИТЬ НАЗВАНИЕ ==></x-primary-button>
                    </form>
                    <form method="POST" action="{{ route('destroyCheck', ['selected' => $selected['id']]) }}"
                        class="p-1 flex">
                        <input type="hidden" name="_method" value="delete">
                        @csrf
                        <x-danger-button :href="route('destroyCheck', ['selected' => $selected['id']])"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            УДАЛИТЬ КАРТУ</x-danger-button>
                    </form>
                </x-menuButton>
            @else
                {{ __('Карта не выбрана, выбор в меню слева <==') }}
            @endisset
        </div>
    </div>
</x-app-layout>
