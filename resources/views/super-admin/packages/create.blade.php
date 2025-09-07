@extends('layouts.app')

@push('styles')
<style>
    input[type=radio].form-check-input  {
        height: 15px;
    }
</style>
@endpush

@section('content')

    <div class="tw-p-2 quentin-9-08_2025">
        @include($view)
    </div>

@endsection
