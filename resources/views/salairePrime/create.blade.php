@php
    $deleteDesignationPermission = user()->permission('delete_designation');
@endphp
<style type="text/css">
    .form-control{height: 39px !important; font-size: 14px;}
</style>
<div class="modal-header">
    <h5 class="modal-title" id="modelHeading">@lang('app.salPrime')</h5>
    <button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <x-table class="table-bordered" headType="thead-light">
        <x-slot name="thead">
            <th>#</th>
            <th class="w-50">Prime et Indemnité</th>
            <th class="w-25">Impôt</th>
            <th class="w-20">Nbre Jour</th>
            <th class="text-right">@lang('app.action')</th>
        </x-slot>

        @forelse($salairePrime as $key=>$item)
            <tr id="row-{{ $item->id }}">
                <td>{{ $key + 1 }}</td>
                <td id="libelle_prime{{ $item->id }}" data-row-id="{{ $item->id }}"  contenteditable="true">{{ ucwords($item->libelle_prime) }}</td>
                <td>
                    <select id="type_prime{{ $item->id }}" class="form-control select-picker assign_type_prime" data-size="8" data-row-id="{{ $item->id }}" contenteditable="true">
                        <option value="Imposable" @if($item->type_prime=='Imposable') selected @endif>Imposable</option>
                    <option value="Non imposable" @if($item->type_prime=='Non imposable') selected @endif>Non imposable</option>
                    </select>
                    
                </td>
                <td id="nbreJTaux{{ $item->id }}" data-row-id="{{ $item->id }}" contenteditable="true" >{{ ucwords($item->nbreJTaux) }}</td>
                <td class="text-right">
                    @if ($deleteDesignationPermission == 'all' || $deleteDesignationPermission == 'added')
                        <x-forms.button-secondary data-row-id="{{ $item->id }}" icon="trash" class="delete-row">
                        </x-forms.button-secondary>
                    @endif
            </tr>
        @empty
            <tr>
                <td colspan="3">@lang('messages.noRecordFound')</td>
            </tr>
        @endforelse
    </x-table>

    <x-form id="createSalairePrime">
        <div class="row border-top-grey ">
            <div class="col-sm-12 otherText">
                <x-forms.text fieldId="libelle_prime" fieldLabel="Prime et Indemnité" fieldName="libelle_prime"
                    fieldRequired="true" fieldPlaceholder="Entrer la Prime et Indemnité">
                </x-forms.text>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <x-forms.select fieldId="type_prime" fieldLabel="Salaire de la catégorie" fieldName="type_prime" >
                    <option value="Imposable" selected>Imposable</option>
                    <option value="Non imposable">Non imposable</option>
                </x-forms.select>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <x-forms.number fieldId="nbreJTaux" fieldLabel="Nombre de jour appliqué" fieldName="nbreJTaux"
                    minValue="1" fieldPlaceholder="Ex:30">
                </x-forms.number>
            </div>

        </div>
    </x-form>
</div>
<div class="modal-footer">
    <x-forms.button-cancel data-dismiss="modal" class="border-0 mr-3">@lang('app.close')</x-forms.button-cancel>
    <x-forms.button-primary id="save-salairePrime" icon="check">@lang('app.save')</x-forms.button-primary>
</div>

<script>
    $('.delete-row').click(function() {

        var id = $(this).data('row-id');
        var url = "{{ route('salairePrime.destroy', ':id') }}";
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

    $('#save-salairePrime').click(function() {
        var url = "{{ route('salairePrime.store') }}";
        //console.log(url);
        $.easyAjax({
            url: url,
            container: '#createSalairePrime',
            type: "POST",
            data: $('#createSalairePrime').serialize(),
            disableButton: true,
            blockUI: true,
            buttonSelector: "#save-salairePrime",
            success: function(response) {
                
                if (response.status == 'success') {
                    if (response.status == 'success') {
                        $('#employee_designation').html(response.data);
                        $('#employee_designation').selectpicker('refresh');
                        $(MODAL_LG).modal('hide');
                    }
                }
            }
        })
    });
    function _updateSalairePrime(id) {
        var libelle_prime=$('#libelle_prime'+id).html();
        var type_prime=$('#type_prime'+id).val();
        var nbreJTaux=$('#nbreJTaux'+id).html();
        var url = "{{ route('salairePrime.update', ':id') }}";
        url = url.replace(':id', id);
        var token = "{{ csrf_token() }}";

        $.easyAjax({
            url: url,
            container: '#row-' + id,
            type: "POST",
            data: {
                'libelle_prime': libelle_prime,
                'type_prime': type_prime,
                'nbreJTaux': nbreJTaux,
                '_token': token,
                '_method': 'PUT'
            },
            blockUI: true,
            success: function(response) {
                return response;
                if (response.status == 'success') {
                    $('#employee_designation').html(response.data);
                    $('#employee_designation').selectpicker('refresh');
                }
            }
        })
    }
    
    $('body').on('change', '.assign_type_prime', function() {
        let id = $(this).data('row-id');
        _updateSalairePrime(id);
    });
    // $('[contenteditable=true]').focus(function() {
    //     $(this).data("initialText", $(this).html());
    //     let rowId = $(this).data('row-id');
    // }).blur(function() {
    //     if ($(this).data("initialText") !== $(this).html()) {
    //         let id = $(this).data('row-id');
    //         _updateSalairePrime(id);
    //     }
    // });

</script>
