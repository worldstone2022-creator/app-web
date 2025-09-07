<a href="{{ $link }}" {{ $attributes->merge(['class' => 'tw-bg-[#f76700] tw-p-2 px-3 hover:tw-bg-[#f76700]/70  hover:tw-text-white  tw-rounded-md !tw-text-white']) }}>
    @if ($icon != '')
        <i class="fa fa-{{ $icon }} mr-1"></i>
    @endif
    {{ $slot }}
</a>
