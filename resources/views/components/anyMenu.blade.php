<nav x-data="{ open: false }" class="border-2 border-user w-fit absolute right-0 z-{{$z ?? 0}}" style="background: white;">
    {{-- border-user border-admin => сделать автоподкидывание цвета в зависимости от режима --}}
    <div class="flex items-center flex-row-reverse justify-between">
        <button @click="open = ! open">
            {{ $svg }}
        </button>
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden p-1">
            {{ $text }}
        </div>
    </div>
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden">
        {{ $slot }}
    </div>
</nav>


{{-- ПРИМЕР ИСПОЛЬЗОВАНИЯ:

    <x-anyMenu>
        <x-slot name="text">
            {{ __('ТЕКСТ') }}                       ТЕКСТ ПОЯСНЯЛКА
        </x-slot>
        <x-slot name="svg">
            <x-svg.AddFriend />                     СВГ ДЛЯ КНОПКИ
        </x-slot>                                                   

        <x-text-input></x-text-input>               ВСЕ ОСТАЛЬНОЕ
        <x-primary-button>==></x-primary-button>
    </x-anyMenu>

--}}
