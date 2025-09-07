<button type="button" @if ($disabled) disabled @endif {{ $attributes->merge(['class' => 'tw-bg-[#838383] tw-text-start tw-p-2 px-3 hover:tw-bg-[#838383]/70 hover:tw-text-white tw-rounded-md !tw-text-white']) }}>
    @if ($icon != '')
        <i class="fa fa-{{ $icon }} mr-1"></i>
    @endif
    {{ $slot }}
</button>

@include('sections.password-autocomplete-hide')
