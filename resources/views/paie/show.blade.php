@extends('layouts.app')

@push('datatable-styles')
    @include('sections.datatable_css')
@endpush

@php


@endphp

@section('filter-section')
    <!-- FILTER START -->
    <!-- PROJECT HEADER START -->

    
    <div class="d-flex d-lg-block filter-box project-header bg-white">
        <div class="mobile-close-overlay w-100 h-100" id="close-client-overlay"></div>

        <div class="project-menu" id="mob-client-detail">
            <a class="d-none close-it" href="javascript:;" id="close-client-detail">
                <i class="fa fa-times"></i>
            </a>

            <nav class="tabs">
                <ul class="-primary">
                    <li>
                        <x-tab :href="route('paie.show', $employee->id)" :text="__('modules.employees.profile')" class="profile" />
                    </li>
                    <li>
                        <x-tab :href="route('paie.show', $employee->id) . '?tab=liste_paie'" text="Liste Des Bulletins De Salaire" class="liste_paie" />
                    </li>
                    <li>
                        <x-tab :href="route('paie.show', $employee->id) . '?tab=calcul'" :text="__('app.menu.paie')" class="calcul" id="refresh_page" />
                    </li>
                    <li>
                        <x-tab :href="route('paie.show', $employee->id) . '?tab=avs'" :text="__('app.avs')" class="avs" />
                    </li>
                    
                </ul>
            </nav>
        </div>

        <a class="mb-0 d-block d-lg-none text-dark-grey ml-auto mr-2 border-left-grey" onclick="openClientDetailSidebar()"><i class="fa fa-ellipsis-v "></i></a>
    </div>

    <!-- PROJECT HEADER END -->
@endsection

@section('content')
    <div class="tw-p-2">
        @include($view)
    </div>
@endsection

@push('scripts')
    <script>
      

    </script>
    <script>
        const activeTab = "{{ $activeTab }}";
        $('.project-menu .' + activeTab).addClass('active');
       
        $("body").on("click", ".project-menu .ajax-tab#refresh_page", function(event) {
            location.reload(true);
        });
        
    </script>
   
@endpush
