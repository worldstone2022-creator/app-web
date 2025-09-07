<div class=" px-4 py-3  d-flex justify-content-between align-items-center">
    <h4 class="f-14 f-w-500 mb-0">{{ $slot }}</h4>

    @if($action)
        {!! $action !!}
    @endif

</div>
