@extends('layouts.app')
@push('datatable-styles')
    @include('sections.datatable_css')
@endpush


@section('filter-section')
    <!-- FILTER START -->
    <!-- PROJECT HEADER STARTmplete -->
    <div class="d-flex filter-box project-header bg-white">

        <div class="mobile-close-overlay w-100 h-100" id="close-client-overlay"></div>
        <div class="project-menu d-lg-flex" id="mob-client-detail">

            <a class="d-none close-it" href="javascript:;" id="close-client-detail">
                <i class="fa fa-times"></i>
            </a>
            <nav class="tabs">
                <ul class="-primary">
                    <x-tab :href="route('vendor-credits.show', $vendorCredit->id)" :text="__('purchase::modules.vendor.overView')" class="overview" />

                    <x-tab :href="route('vendor-credits.show', $vendorCredit->id). '?tab=history'" ajax="false" :text="__('purchase::modules.vendor.history')"
                        class="history" />
                </ul>
            <nav>
        </div>

        <a class="mb-0 d-block d-lg-none text-dark-grey ml-auto mr-2 border-left-grey"
            onclick="openClientDetailSidebar()"><i class="fa fa-ellipsis-v "></i></a>

    </div>
    <!-- FILTER END -->
    <!-- PROJECT HEADER END -->

@endsection

@push('styles')
<script src="{{ asset('vendor/jquery/Chart.min.js') }}"></script>
@endpush

@section('content')

    <div class="tw-p-2 quentin-9-08_2025 border-top-0 client-detail-wrapper">
        @include($view)
    </div>

@endsection

@push('scripts')
    <script>
        $("body").on("click", ".ajax-tab", function(event) {
            event.preventDefault();

            $('.project-menu .p-sub-menu').removeClass('active');
            $(this).addClass('active');


            const requestUrl = this.href;

            $.easyAjax({
                url: requestUrl,
                blockUI: true,
                container: ".tw-p-2 quentin-9-08_2025",
                historyPush: true,
                success: function(response) {
                    if (response.status == "success") {
                        $('.tw-p-2 quentin-9-08_2025').html(response.html);
                        init('.tw-p-2 quentin-9-08_2025');
                    }
                }
            });
        });

    </script>
    <script>
        const activeTab = "{{ $activeTab }}";
        $('.project-menu .' + activeTab).addClass('active');

    </script>
@endpush
