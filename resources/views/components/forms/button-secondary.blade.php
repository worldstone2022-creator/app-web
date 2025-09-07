<button type="button" @disabled($disabled)
    {{ $attributes->merge(['class' => 'tw-bg-[#838383] tw-p-2 px-3 hover:tw-bg-[#838383]/70  hover:tw-text-white  tw-rounded-md !tw-text-white']) }}>
    @if (!is_null($icon))
        <i class="fa fa-{{ $icon }} mr-1"></i>
    @endif
    {{ $slot }}
</button>
