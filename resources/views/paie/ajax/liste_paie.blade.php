@php
$addDesignationPermission = user()->permission('add_designation');
$addDepartmentPermission = user()->permission('add_department');
@endphp

<link rel="stylesheet" href="{{ asset('vendor/css/tagify.css') }}">
<style type="text/css">
    .action .btn-action{
        border: 1px solid #99A5B5;
        border-radius: 4px;
        display: inline-flex;
        color: #99A5B5;
        padding: 6.3px 5px;
        border-radius: 4px;
        display: inline-block;
        height: 30px;
        width: 30px;
        background: #F2F4F7;
    }
    .action .btn-action:hover{
        background: #ffffff;
        color: #000000;
    }
</style>
<div class="row add-client bg-white rounded">
    <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
      Liste des bulletins de salaire de: <strong>{{ ucfirst($employee->salutation) . ' ' . ucwords($employee->name) . ' ' . ucwords($employee->lastname)}}</strong></h4>
  <div class="col-md-12">
  
    
  </div>
</div>
<!-- CONTENT WRAPPER START -->
<div class="tw-p-2 quentin-9-08_2025">
    <!-- Add Task Export Buttons Start -->

    <div class="d-flex justify-content-between action-bar">

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
                  <th class="w-25">période Salaire</th>
                  <th class="w-20 text-left" style="width: 200px">Salaire de base</th>
                  <th class="text-left" style="width: 200px" >Salaire brut</th>
                  <th class="w-20 text-left" style="width: 200px">Salaire Net</th>
                  <th class="w-10 text-center">Action</th>
              </x-slot>

              @forelse($bulletin as $key=>$item)
                  <?php 
                    $debut=new DateTime ($item->salaire_debut);
                    $fin=new DateTime ($item->salaire_fin);
                  ?>
                  <tr id="row-{{ $key }}">
                        <td>{{ $key + 1 }}</td>
                        <td>Du: {{($debut)->format('d/m/Y')}} Au: {{($fin)->format('d/m/Y')}}</td>
                        <td class="text-left">{{number_format($item->salaire_base, 0, ',', ' ')}} F CFA</td>
                        <td class="text-left">{{number_format($item->total_brut_general, 0, ',', ' ')}} F CFA</td>
                        <td class="text-left"><b>{{number_format($item->net_a_payer, 0, ',', ' ')}} F CFA</b></td>
                        <td class="text-center action">
                            <a class="btn-action align-items-center justify-content-center " title="Détails bulletin de salaire" target="_blank" href="{{ route('generate-bulletin-paie') }}?ref={{$item->id}}"><i class="fa fa-eye"></i></a>

                            <button type="button" class="btn-action align-items-center justify-content-center delete-row" data-row-id="{{$item->id}}" title="Supprimer bulletin de salaire"><i class="fa fa-trash"></i></button>
                        </td>
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

            
      

<script src="{{ asset('vendor/jquery/tagify.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('#example').DataTable();
} );

  $('body').on('click', '.delete-row', function() {
            var id = $(this).data('row-id');
            console.log(id);
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
                    var url = "{{ route('paie.destroy', ':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

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
                                location.reload(true);
                            }
                        }
                    });
                }
            });
        });
</script>
