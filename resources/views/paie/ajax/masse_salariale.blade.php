@extends('layouts.app')

@push('datatable-styles')
    @include('sections.datatable_css')
@endpush

@php
$viewEmployeeTasks = user()->permission('view_employee_tasks');
$viewTickets = user()->permission('view_tickets');
$viewEmployeeProjects = user()->permission('view_employee_projects');
$viewEmployeeTimelogs = user()->permission('view_employee_timelogs');
$manageEmergencyContact = user()->permission('manage_emergency_contact');
$manageRolePermissionSetting = user()->permission('manage_role_permission_setting');
$manageShiftPermission = user()->permission('view_shift_roster');

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

           
        </div>

        <a class="mb-0 d-block d-lg-none text-dark-grey ml-auto mr-2 border-left-grey" onclick="openClientDetailSidebar()"><i class="fa fa-ellipsis-v "></i></a>
    </div>

    <!-- PROJECT HEADER END -->
@endsection

@section('content')
    <div class="tw-p-2">

<link rel="stylesheet" href="{{ asset('vendor/css/tagify.css') }}">

<div class="row add-client bg-white rounded">
    <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
      Registre de paiement</h4>
  <div class="col-md-12">
  
    
  </div>
</div>
<!-- CONTENT WRAPPER START -->
<div class="tw-p-2 quentin-9-08_2025">
    <!-- Add Task Export Buttons Start -->

    <div class="d-flex justify-content-between action-bar">

        <div id="table-actions" class="d-block d-lg-flex align-items-center">
            

            {{--@if ($addDesignationPermission == 'all' || $addDesignationPermission == 'added')
            @if ($viewDesignationPermission == 'all')--}}
            {{--<x-forms.button-secondary class="mr-3 mb-2 mb-lg-0" icon="plus" id="salaireAVS">
                @lang('app.add') une demande d'@lang('app.avs')
            </x-forms.button-secondary>--}}
            {{--@endif
            @endif--}}

            
            
            
        </div>

        <x-datatable.actions>
            <div class="select-status mr-3 pl-3">
                <select name="action_type" class="form-control select-picker" id="quick-action-type" disabled>
                    <option value="">@lang('app.selectAction')</option>
                    <option value="change-status">@lang('modules.tasks.changeStatus')</option>
                    <option value="delete">@lang('app.delete')</option>
                </select>
            </div>
            <div class="select-status mr-3 d-none quick-action-field" id="change-status-action">
                <select name="status" class="form-control select-picker">
                    <option value="deactive">@lang('app.inactive')</option>
                    <option value="active">@lang('app.active')</option>
                </select>
            </div>
        </x-datatable.actions>

    </div>
    <!-- Add Task Export Buttons End -->
    <!-- Task Box Start -->



    <div class="d-flex flex-column w-tables rounded mt-3 bg-white">
          <x-table class="table-bordered " headType="thead-light">
              <x-slot name="thead">
                  <th>#</th>
                  <th class="w-25">Mois</th>
                  <th class="w-20">Année</th>
                  <th class="w-25 text-right">Total Net</th>
              </x-slot>

              @forelse($listMasseSalariale as $key=>$item)
                  <tr id="row-{{ $key }}">
                      <td>{{ $key + 1 }}</td>
                      <td>{{$item->mois}}</td>
                      <td>{{$item->annee}}</td>
                      <td class="text-right">{{number_format($item->totalNet, 0, ',', ' ')}} F CFA</td>
                  </tr>
              @empty
                  <tr>
                      <td class="text-center" colspan="7">@lang('messages.noRecordFound')</td>
                  </tr>
              @endforelse
          </x-table>

    </div>
    <!-- Task Box End -->
          
      
@include('sections.datatable2_js')
<script src="{{ asset('vendor/jquery/tagify.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('#example').DataTable();
} );
  $(document).ready(function() {
    $('#salaireAVS').click(function() {
      const id = $("#user_id").val();
      //const url = "{{ route('salaireAVS.create') }}";

      var url = "{{ route('salaireAVS.create', 'id=:id') }}";
      url = url.replace(':id', id);


      $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
      $.ajaxModal(MODAL_LG, url);
    });
    $('.edit-row').click(function() {
      var id = $(this).data('row-id');

      var url = "{{ route('salaireAVS.index', 'id=:id') }}";
      url = url.replace(':id', id);


      $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
      $.ajaxModal(MODAL_LG, url);
    });
    $('.delete-row').click(function() {

        var id = $(this).data('row-id');
        var url = "{{ route('salaireAVS.destroy', ':id') }}";
        url = url.replace(':id', id);

        var token = "{{ csrf_token() }}";

        Swal.fire({
            title: "@lang('messages.sweetAlertTitle')",
            text: "@lang('messages.recoverRecord')",
            icon: 'warning',
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: "@lang('messages.confirmDelete')",
            cancelButtonText: "@lang('app.cancel')",
            customClass: {
                confirmButton: 'btn btn-primary mr-3',
                cancelButton: 'btn btn-secondary'
            },
            showClass: {
                popup: 'swal2-noanimation',
                backdrop: 'swal2-noanimation'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.easyAjax({
                    type: 'POST',
                    url: url,
                    blockUI: true,
                    data: {
                        '_token': token,
                        '_method': 'DELETE'
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            $('#row-' + id).fadeOut();
                            $('#employee_designation').html(response.data);
                            $('#employee_designation').selectpicker('refresh');
                        }
                    }
                });
            }
        });

    });
  });
</script>

    </div>
@endsection

@push('scripts')
    <script>
        $("body").on("click", ".project-menu .ajax-tab", function(event) {
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
        /*******************************************************
                 More btn in projects menu Start
        *******************************************************/

        const container = document.querySelector('.tabs');
        const primary = container.querySelector('.-primary');
        const primaryItems = container.querySelectorAll('.-primary > li:not(.-more)');
        container.classList.add('--jsfied'); // insert "more" button and duplicate the list

        primary.insertAdjacentHTML('beforeend', `
        <li class="-more">
            <button type="button" class="px-4 h-100 bg-grey d-none d-lg-flex align-items-center" aria-haspopup="true" aria-expanded="false">
            {{__('app.more')}} <span>&darr;</span>
            </button>
            <ul class="-secondary" id="hide-project-menues">
            ${primary.innerHTML}
            </ul>
        </li>
        `);
        const secondary = container.querySelector('.-secondary');
        const secondaryItems = secondary.querySelectorAll('li');
        const allItems = container.querySelectorAll('li');
        const moreLi = primary.querySelector('.-more');
        const moreBtn = moreLi.querySelector('button');
        moreBtn.addEventListener('click', e => {
            e.preventDefault();
            container.classList.toggle('--show-secondary');
            moreBtn.setAttribute('aria-expanded', container.classList.contains('--show-secondary'));
        }); // adapt tabs

        const doAdapt = () => {
            // reveal all items for the calculation
            allItems.forEach(item => {
                item.classList.remove('--hidden');
            }); // hide items that won't fit in the Primary

            let stopWidth = moreBtn.offsetWidth;
            let hiddenItems = [];
            const primaryWidth = primary.offsetWidth;
            primaryItems.forEach((item, i) => {
                if (primaryWidth >= stopWidth + item.offsetWidth) {
                    stopWidth += item.offsetWidth;
                } else {
                    item.classList.add('--hidden');
                    hiddenItems.push(i);
                }
            }); // toggle the visibility of More button and items in Secondary

            if (!hiddenItems.length) {
                moreLi.classList.add('--hidden');
                container.classList.remove('--show-secondary');
                moreBtn.setAttribute('aria-expanded', false);
            } else {
                secondaryItems.forEach((item, i) => {
                    if (!hiddenItems.includes(i)) {
                        item.classList.add('--hidden');
                    }
                });
            }
        };

        doAdapt(); // adapt immediately on load

        window.addEventListener('resize', doAdapt); // adapt on window resize
        // hide Secondary on the outside click

        document.addEventListener('click', e => {
            let el = e.target;

            while (el) {
                if (el === secondary || el === moreBtn) {
                    return;
                }

                el = el.parentNode;
            }

            container.classList.remove('--show-secondary');
            moreBtn.setAttribute('aria-expanded', false);
        });
        /*******************************************************
                 More btn in projects menu End
        *******************************************************/
    </script>
@endpush
