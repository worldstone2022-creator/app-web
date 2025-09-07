@php
$addDesignationPermission = user()->permission('add_designation');
$addDepartmentPermission = user()->permission('add_department');
@endphp

<link rel="stylesheet" href="{{ asset('vendor/css/tagify.css') }}">

<div class="row add-client bg-white rounded">
    <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
      Gestion des avances/acomptes de <b>{{$employee->name}} {{$employee->lastname}} </b></h4>
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
            <x-forms.button-primary class="mr-3 mb-2 mb-lg-0" icon="plus" id="salaireAVS">
                @lang('app.add') une demande d'@lang('app.avs')
            </x-forms.button-primary>
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
                  <th class="w-10">Date d'emprunt</th>
                  <th class="w-30">Motif</th>
                  <th class="w-20" style="width: 200px">Montant emprunté</th>
                  <th class="w-20" style="width: 200px">Montant remboursé</th>
                  <th class="w-20" style="width: 200px">Reste à remboursé</th>
                  <th class="text-right">@lang('app.action')</th>
              </x-slot>

              @forelse($listAVS as $key=>$item)
                  <tr id="row-{{ $item->id }}">
                      <td>{{ $key + 1 }}</td>
                      <td>{{$item->date_avs->format(global_setting()->date_format)}}</td>
                      <td>{{ ucwords($item->motif_avs) }}</td>
                      <td>{{ ucwords($item->montant_avs) }}</td>
                      <td>{{ ucwords($item->rembourse_avs) }}</td>
                      <td>{{ ucwords($item->reste_avs) }}</td>
                      
                      <td class="text-right">
                          {{--@if ($deleteDesignationPermission == 'all' || $deleteDesignationPermission == 'added')--}}
                              <x-forms.button-secondary data-row-id="{{ $item->id }}" icon="trash" class="delete-row">
                              </x-forms.button-secondary>
                              <x-forms.button-secondary data-row-id="{{ $item->id }}" icon="edit" class="edit-row">
                              </x-forms.button-secondary>

                          {{--@endif--}}
                  </tr>
              @empty
                  <tr>
                      <td class="text-center" colspan="7">@lang('messages.noRecordFound')</td>
                  </tr>
              @endforelse 
          </x-table>

    </div>
    <!-- Task Box End -->
</div>

<input type="hidden" id="user_id" name="user_id" value="{{$employee->id}}">
            
      

<script src="{{ asset('vendor/jquery/tagify.min.js') }}"></script>
<script>
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

      var url = "{{ route('showAVS', 'id=:id') }}";
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
