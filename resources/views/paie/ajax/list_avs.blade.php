@extends('layouts.app')

@push('datatable-styles')
    @include('sections.datatable_css')
@endpush

@php
$addAvanceAcompte = user()->permission('add_avance_acompte');
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
@section('filter-section')

    

@endsection
@section('content')
<x-filters.filter-box>
        <!-- CLIENT START -->
        <div class="select-box py-2 d-flex pr-2 border-right-grey border-right-grey-sm-0">
            <p class="mb-0 pr-3 f-14 text-dark-grey d-flex align-items-center">@lang('app.employee')</p>
            <div class="select-status">
                <select class="form-control select-picker" name="employee" id="employee" data-live-search="true"
                    data-size="8">
                    @if ($employees->count() > 1)
                        <option value="all">@lang('app.all')</option>
                    @endif
                    @foreach ($employees as $employee)
                        <option
                            data-content="<div class='d-inline-block mr-1'><img class='taskEmployeeImg rounded-circle' src='{{ $employee->image_url }}' ></div> {{ ucfirst($employee->name) }} {{ ucfirst($employee->lastname) }}"
                            value="{{ $employee->id }}">{{ ucfirst($employee->name) }} {{ ucfirst($employee->lastname) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- CLIENT END -->

        


        <!-- SEARCH BY TASK START -->
        <div class="task-search d-flex  py-1 px-lg-3 px-0 border-right-grey align-items-center">
            <form class="w-100 mr-1 mr-lg-0 mr-md-1 ml-md-1 ml-0 ml-lg-0">
                <div class="input-group bg-grey rounded">
                    <div class="input-group-prepend">
                        <span class="input-group-text border-0 bg-additional-grey">
                            <i class="fa fa-search f-13 text-dark-grey"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control f-14 p-1 border-additional-grey" id="search-text-field"
                        placeholder="@lang('app.startTyping')">
                </div>
            </form>
        </div>
        <!-- MORE FILTERS END -->
    </x-filters.filter-box>
<div class="tw-p-2">
{{-- 
<link rel="stylesheet" href="{{ asset('vendor/css/tagify.css') }}">

<div class="row add-client bg-white rounded">
    <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
      Gestion des avances/acomptes</h4>
  <div class="col-md-12">
  
    
  </div>
</div> --}}

<!-- CONTENT WRAPPER START -->
<div class="tw-p-2 quentin-9-08_2025">
    <!-- Add Task Export Buttons Start -->

    <div class="d-flex justify-content-between action-bar">

        @if ($addAvanceAcompte=='all')
            <div id="table-actions" class="d-block d-lg-flex align-items-center">
                <x-forms.link-primary :link="route('salaireAVS.create')" class="mr-3 float-left" icon="plus"> @lang('app.add') une demande d'@lang('app.avs')
                </x-forms.link-primary>
            </div>
        @endif
        

    </div>
    <!-- Add Task Export Buttons End -->
    <!-- Task Box Start -->
    {{--<div class="d-flex flex-column w-tables rounded mt-3 bg-white">
          <x-table class="table-bordered " headType="thead-light">
              <x-slot name="thead">
                  <th>#</th>
                  <th class="w-25">Nom et Prénoms</th>
                  <th class="w-20">Date d'emprunt</th>
                  <th class="w-25">Motif</th>
                  <th class="w-10">Montant emprunté</th>
                  <th class="w-10">Montant remboursé</th>
                  <th class="w-10">Reste à remboursé</th>
              </x-slot>

              @forelse($listAVS as $key=>$item)
                  <tr id="row-{{ $item->id }}">
                      <td>{{ $key + 1 }}</td>
                      <td>{{$item->name}} {{$item->lastname}}</td>
                      <td>{{$item->dateAVS}}</td>
                      <td>{{ ucwords($item->motif_avs) }}</td>
                      <td>{{ ucwords($item->montant_avs) }}</td>
                      <td>{{ ucwords($item->rembourse_avs) }}</td>
                      <td>{{ ucwords($item->reste_avs) }}</td>
                  </tr>
              @empty
                  <tr>
                      <td class="text-center" colspan="7">@lang('messages.noRecordFound')</td>
                  </tr>
              @endforelse
          </x-table>

    </div>--}}

    <div class="d-flex flex-column w-tables rounded mt-3 bg-white">

        {!! $dataTable->table(['class' => 'table table-hover border-0 w-100']) !!}

    </div>
    <!-- Task Box End -->
</div>
          
      

<script src="{{ asset('vendor/jquery/tagify.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('#salaireAVS').click(function() {
      var id = $("#user_id").val();
      if (id==undefined) {
        id="";
      }
      var url = "{{ route('salaireAVS.create', 'id=:id') }}";
      url = url.replace(':id', id);


      $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
      $.ajaxModal(MODAL_LG, url);
    });
    $('body').on('click', '.edit-row', function() {
        var id = $(this).data('row-id');

      var url = "{{ route('showAVS', 'id=:id') }}";
      url = url.replace(':id', id);


      $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
      $.ajaxModal(MODAL_LG, url);
    });
    $('body').on('click', '.delete-row', function(){

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
                                showTable();
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
    @include('sections.datatable_js')

    <script>

        var startDate = null;
        var endDate = null;
        var lastStartDate = null;
        var lastEndDate = null;

        @if(request('startDate') != '' && request('endDate') != '' )
            startDate = '{{ request("startDate") }}';
            endDate = '{{ request("endDate") }}';
        @endif

        @if(request('lastStartDate') !=='' && request('lastEndDate') !=='' )
            lastStartDate = '{{ request("lastStartDate") }}';
            lastEndDate = '{{ request("lastEndDate") }}';
        @endif

        $('#employees-table').on('preXhr.dt', function(e, settings, data) {
            var employee = $('#employee').val();
            var searchText = $('#search-text-field').val();
            data['employee'] = employee;
            data['searchText'] = searchText;

            /* If any of these following filters are applied, then dashboard conditions will not work  */
            if( employee == "all" || searchText == ""){
                data['startDate'] = startDate;
                data['endDate'] = endDate;
                data['lastStartDate'] = lastStartDate;
                data['lastEndDate'] = lastEndDate;
            }

        });

        const showTable = () => {
            window.LaravelDataTables["employees-table"].draw();
        }

        $('#employee,#search-text-field').on('change keyup',
            function() {
                if ($('#employee').val() != "all") {
                    $('#reset-filters').removeClass('d-none');
                    showTable();
                } else if ($('#search-text-field').val() != "") {
                    $('#reset-filters').removeClass('d-none');
                    showTable();
                } else {
                    $('#reset-filters').addClass('d-none');
                    showTable();
                }
            });

        $('#reset-filters').click(function() {
            $('#filter-form')[0].reset();
            $('.filter-box .select-picker').selectpicker("refresh");
            $('#reset-filters').addClass('d-none');
            showTable();
        });

        $('#reset-filters-2').click(function() {
            $('#filter-form')[0].reset();
            $('.filter-box .select-picker').selectpicker("refresh");
            $('#reset-filters').addClass('d-none');
            showTable();
        });

        $('#quick-action-type').change(function() {
            const actionValue = $(this).val();
            if (actionValue != '') {
                $('#quick-action-apply').removeAttr('disabled');

                if (actionValue == 'change-status') {
                    $('.quick-action-field').addClass('d-none');
                    $('#change-status-action').removeClass('d-none');
                } else {
                    $('.quick-action-field').addClass('d-none');
                }
            } else {
                $('#quick-action-apply').attr('disabled', true);
                $('.quick-action-field').addClass('d-none');
            }
        });

        $('#quick-action-apply').click(function() {
            const actionValue = $('#quick-action-type').val();
            if (actionValue == 'delete') {
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
                        applyQuickAction();
                    }
                });

            } else {
                applyQuickAction();
            }
        });

        const applyQuickAction = () => {
            var rowdIds = $("#employees-table input:checkbox:checked").map(function() {
                return $(this).val();
            }).get();

            var url = "{{ route('employees.apply_quick_action') }}?row_ids=" + rowdIds;

            $.easyAjax({
                url: url,
                container: '#quick-action-form',
                type: "POST",
                disableButton: true,
                buttonSelector: "#quick-action-apply",
                data: $('#quick-action-form').serialize(),
                blockUI: true,
                success: function(response) {
                    if (response.status == 'success') {
                        showTable();
                        resetActionButtons();
                        deSelectAll();
                    }
                }
            })
        };


        
    </script>
@endpush
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

        //const container = document.querySelector('.tabs');
        //const primary = container.querySelector('.-primary');
        //const primaryItems = container.querySelectorAll('.-primary > li:not(.-more)');
        //container.classList.add('--jsfied'); // insert "more" button and duplicate the list

        /*primary.insertAdjacentHTML('beforeend', `
        <li class="-more">
            <button type="button" class="px-4 h-100 bg-grey d-none d-lg-flex align-items-center" aria-haspopup="true" aria-expanded="false">
            {{__('app.more')}} <span>&darr;</span>
            </button>
            <ul class="-secondary" id="hide-project-menues">
            ${primary.innerHTML}
            </ul>
        </li>
        `);*/
        /*const secondary = container.querySelector('.-secondary');
        const secondaryItems = secondary.querySelectorAll('li');
        const allItems = container.querySelectorAll('li');
        const moreLi = primary.querySelector('.-more');
        const moreBtn = moreLi.querySelector('button');
        moreBtn.addEventListener('click', e => {
            e.preventDefault();
            container.classList.toggle('--show-secondary');
            moreBtn.setAttribute('aria-expanded', container.classList.contains('--show-secondary'));
        }); // adapt tabs
*/
        /*const doAdapt = () => {
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
        });*/
        /*******************************************************
                 More btn in projects menu End
        *******************************************************/
    </script>
@endpush



