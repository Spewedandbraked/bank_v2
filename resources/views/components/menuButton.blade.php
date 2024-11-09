<div x-data="{ open: false }" :class="{ 'block w-full ps-3 pe-4 py-2 border-l-8 border-indigo-400': open, 'block w-full ps-3 pe-4 py-2 border-l-4 text-gray-600': !open }">
    {{-- border-user border-admin => сделать автоподкидывание цвета в зависимости от режима --}}
    <div class="flex items-center justify-between">
        <button @click="open = ! open">
            {{ $text }}
        </button>
    </div>
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden">
        {{ $slot }}
    </div>
</div>
