<div
    {{ $attributes->merge(['class' => 'card-quentin bg-white tw-p-4  d-flex justify-content-between align-items-center']) }}>
    <div class="d-block ">
        <h5 class="f-13 f-w-500 text-darkest-grey">{{ $title }}
            @if (!is_null($info))
                <i class="fa fa-question-circle" data-toggle="popover" data-placement="top"
                    data-content="{{ $info }}" data-html="true" data-trigger="hover"></i>
            @endif
        </h5>
        <div class="d-flex">
            <p class="mb-0 " style="font-size:19px;color: black;font-weight: 500"><span
                    id="{{ $widgetId }}">{{ $value }}</span>
            </p>
        </div>
    </div>
    <div class="d-block">
        <i class="fa fa-{{ $icon }} text-lightest" style="font-size: 30px"></i>
    </div>
</div>
