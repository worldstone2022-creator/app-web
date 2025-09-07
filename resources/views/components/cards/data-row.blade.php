@if (!$html)
    <div class="col-12 px-0 pb-2 d-lg-flex d-md-flex d-block">
        <p class="mb-0 text-lightest f-13 w-30  {{ $labelClasses }}">{{ $label }}</p>
        <p class="mb-0 text-dark-grey f-13 w-70 text-wrap {{ $otherClasses }}">{!! $value !!}</p>
    </div>
@else
    <div class="col-12 px-0 pb-2 d-lg-flex d-md-flex d-block">
        <p class="mb-0 text-lightest f-13 w-30  {{ $labelClasses }}">{{ $label }}</p>
        <div class="mb-0 text-dark-grey f-13 w-70 text-wrap ql-editor p-0 {{ $otherClasses }}">{!! nl2br($value) !!}</div>
    </div>
@endif
