@php
    $deleteDesignationPermission = user()->permission('delete_designation');
@endphp

<div class="modal-header">
    <h5 class="modal-title" id="modelHeading">@lang('app.salCat')</h5>
    <button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">×</span></button>
</div>
 <div class="modal-body">
    <x-table class="table-bordered" headType="thead-light">
        <x-slot name="thead">
            <th>#</th>
            <th class="w-25">Catégorie</th>
            <th class="w-40">Salaire de la catégorie</th>
            <th class="text-right">@lang('app.action')</th>
        </x-slot>

        @forelse($salaireCategoriel as $key=>$item)
            <tr id="row-{{ $item->id }}">
                <td>{{ $key + 1 }}</td>
                <td data-row-id="{{ $item->id }}" data-row-type="categorie_sc" data-row-value="{{$item->salaire_sc}}" contenteditable="true">{{ ucwords($item->categorie_sc) }}</td>
                <td data-row-id="{{ $item->id }}" data-row-type="salaire_sc" data-row-value="{{$item->categorie_sc}}" contenteditable="true">{{ ucwords($item->salaire_sc) }}</td>
                <td class="text-right">
                    @if ($deleteDesignationPermission == 'all' || $deleteDesignationPermission == 'added')
                        <x-forms.button-secondary data-row-id="{{ $item->id }}" icon="trash" class="delete-row">
                            @lang('app.delete')</x-forms.button-secondary>
                    @endif
            </tr>
        @empty
            <tr>
                <td colspan="3">@lang('messages.noRecordFound')</td>
            </tr>
        @endforelse
    </x-table>

    <x-form id="createSalaireCategoriel">
        <div class="row border-top-grey ">
            <div class="col-sm-12 otherText">
                <x-forms.text fieldId="categorie_sc" fieldLabel="Catégorie" fieldName="categorie_sc"
                    fieldRequired="true" fieldPlaceholder="Entrer la catégorie">
                </x-forms.text>
                <x-forms.number fieldId="salaire_sc" fieldLabel="Salaire de la catégorie" fieldName="salaire_sc"
                    fieldRequired="true" fieldPlaceholder="Entrer le salaire de cette catégorie">
                </x-forms.number>
            </div>

        </div>
    </x-form> 
</div>
<div class="modal-footer">
    <x-forms.button-cancel data-dismiss="modal" class="border-0 mr-3">@lang('app.close')</x-forms.button-cancel>
    <x-forms.button-primary id="save-salaireCategoriel" icon="check">@lang('app.save')</x-forms.button-primary>
</div>

<script>
    $('.delete-row').click(function() {

        var id = $(this).data('row-id');
        var url = "{{ route('salaireCategoriel.destroy', ':id') }}";
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
                            $('#salaire_categoriel').html(response.data);
                            $('#salaire_categoriel').selectpicker('refresh');
                        }
                    }
                });
            }
        });

    });

    $('#save-salaireCategoriel').click(function() {
        var url = "{{ route('salaireCategoriel.store') }}";
        console.log(url);
        $.easyAjax({
            url: url,
            container: '#createSalaireCategoriel',
            type: "POST",
            data: $('#createSalaireCategoriel').serialize(),
            disableButton: true,
            blockUI: true,
            buttonSelector: "#save-salaireCategoriel",
            success: function(response) {
                
                if (response.status == 'success') {
                    if (response.status == 'success') {
                        $('#salaire_categoriel').html(response.data);
                        $('#salaire_categoriel').selectpicker('refresh');
                        $(MODAL_LG).modal('hide');
                    }
                }
            }
        })
    });

    // $('[contenteditable=true]').focus(function() {
    //     $(this).data("initialText", $(this).html());
    //     let rowId = $(this).data('row-id');
    // }).blur(function() {
    //     if ($(this).data("initialText") !== $(this).html()) {
    //         let id = $(this).data('row-id');
    //         let value = $(this).html();
    //         let lib =$(this).data('row-type');
    //         let otherValue =$(this).data('row-value');
    //         if (lib=='categorie_sc') {
    //             var categorie_sc=value;
    //             var salaire_sc=otherValue;
    //         }
    //         if (lib=='salaire_sc') {
    //             var salaire_sc=value;
    //             var categorie_sc=otherValue;
    //         }
    //         var url = "{{ route('salaireCategoriel.update', ':id') }}";
    //         url = url.replace(':id', id);

    //         var token = "{{ csrf_token() }}";

    //         $.easyAjax({
    //             url: url,
    //             container: '#row-' + id,
    //             type: "POST",
    //             data: {
    //                 'categorie_sc': categorie_sc,
    //                 'salaire_sc': salaire_sc,
    //                 '_token': token,
    //                 '_method': 'PUT'
    //             },
    //             blockUI: true,
    //             success: function(response) {
    //                 return response;
    //                 if (response.status == 'success') {
    //                     $('#salaire_categoriel').html(response.data);
    //                     $('#salaire_categoriel').selectpicker('refresh');
    //                 }
    //             }
    //         })
    //     }
    // });

</script>
