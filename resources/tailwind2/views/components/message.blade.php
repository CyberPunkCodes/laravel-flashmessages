<div x-data="{ show: true }" x-show="show" class="px-6 py-4 border-0 rounded relative mb-4 {{ $getClass() }}">
    @if ($shouldShowIcon())
    <span class="text-xl inline-block mr-5 align-middle">
        {!! $getIcon() !!}
    </span>
    @endif
    <span class="inline-block align-middle mr-8">
        @if ($shouldShowTitle())<strong>{{ $getTitle() }}: </strong>@endif {!! $getMessage() !!}
    </span>
    @if ($isDismissable())
    <button @click="show = false" class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none">
        <span>×</span>
    </button>
    @endif
</div>
