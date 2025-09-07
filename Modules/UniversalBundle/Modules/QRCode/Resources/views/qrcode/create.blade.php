@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap-colorpicker.css') }}"/>
@endpush
@section('content')

    <div class="tw-p-2 quentin-9-08_2025">
        @include($view)
    </div>

@endsection
@push('scripts')
<script src="{{ asset('vendor/jquery/bootstrap-colorpicker.js') }}"></script>
@endpush
