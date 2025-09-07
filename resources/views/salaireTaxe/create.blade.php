@php
    $deleteDesignationPermission = user()->permission('delete_designation');
@endphp
<style type="text/css">
    .form-control{height: 39px !important; font-size: 14px;}
</style>
<div class="modal-header">
    <h5 class="modal-title" id="modelHeading">@lang('app.salTaxe')</h5>
    <button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">×</span></button>
</div>
<div class="modal-body TableTaxe">
    <x-form id="createSalaireTaxe">
        <div class="row border-top-grey ">
            <div class="col-lg-12 col-md-12 col-sm-12 nameText">
                <x-forms.text fieldId="libelle_taxe" fieldLabel="Libellé Taxe" fieldName="libelle_taxe"
                    fieldRequired="true" fieldPlaceholder="Entrer le Libellé Taxe">
                </x-forms.text>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <x-forms.select fieldId="methodeCalcul" fieldLabel="Méthode de Calcul" fieldName="methodeCalcul" >
                    <option value="Normal" selected>Normal (Taux * Base)</option>
                    <option value="ITS">ITS (Impôt Sur Traitement De Salaire)</option>
                </x-forms.select>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <x-forms.select fieldId="type_obligation" fieldLabel="Type obligation" fieldName="type_obligation" fieldRequired="true">
                    <option value="">---</option>
                    <option value="sociale">Obligation sociale</option>
                    <option value="fiscale">Obligation fiscale</option>
                </x-forms.select>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <x-forms.number fieldId="taux_salarial" fieldLabel="Taux part Salariale" fieldName="taux_salarial"
                 minValue="1" fieldPlaceholder="Entrer le Taux part Salariale">
                </x-forms.number>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <x-forms.number fieldId="taux_patronal" fieldLabel="Taux part Patronale" fieldName="taux_patronal"
                    minValue="1" fieldPlaceholder="Entrer le Taux part Patronale">
                </x-forms.number>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <x-forms.number fieldId="baseCalcule" fieldLabel="Taux Base de Calcule (N% SBI) ou Montant fixe" fieldName="baseCalcule"
                    minValue="1" fieldPlaceholder="Taux sur SBI ou Mnt Fixe">
                </x-forms.number>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <x-forms.select fieldId="TypeApplicable" fieldLabel="Méthode Applicable" fieldName="TypeApplicable" >
                    <option value="Taux" selected>Taux Applicable au SBI</option>
                    <option value="Montant">Montant Fixe</option>
                </x-forms.select>
            </div>

        </div>
    </x-form>
    <x-forms.button-primary id="save-salaireTaxe" icon="check">@lang('app.save')</x-forms.button-primary>

    
</div>
<div class="modal-footer">
    <x-table class="table-bordered " headType="thead-light">
        <x-slot name="thead">
            <th>#</th>
            <th class="tw-w-42">Libellé Taxe</th>
            <th class="w-18">Taux part Salariale</th>
            <th class="w-18">Taux part Patronale</th>
            <th class="w-20">Méthode Calcul</th>
            <th class="w-18">Taux Base ou Montant</th>
            <th class="w-20">Méthode Applicable</th>
            <th class="w-20">Type obligation</th>
            <th class="text-right">@lang('app.action')</th>
        </x-slot>

        @forelse($salaireTaxe as $key=>$item)
            <tr id="row-{{ $item->id }}">
                <td>{{ $key + 1 }}</td>
                <td data-row-id="{{ $item->id }}" contenteditable="true" id="libelle_taxe{{ $item->id }}">{{ ucwords($item->libelle_taxe) }}</td>
                <td data-row-id="{{ $item->id }}" contenteditable="true" id="taux_salarial{{ $item->id }}">{{ ucwords($item->taux_salarial) }}</td>
                <td data-row-id="{{ $item->id }}" contenteditable="true" id="taux_patronal{{ $item->id }}">{{ ucwords($item->taux_patronal) }}</td>
                <td>
                    <select name="methodeCalcul" id="methodeCalcul{{ $item->id }}" class="form-control select-picker assign_Update" data-size="8" data-row-id="{{ $item->id }}" contenteditable="true">
                        <option value="Normal" @if($item->methodeCalcul=='Normal') selected @endif>Normal</option>
                        <option value="ITS" @if($item->methodeCalcul=='ITS') selected @endif>ITS</option>
                    </select>
                </td>

                <td data-row-id="{{ $item->id }}" contenteditable="true" id="baseCalcule{{ $item->id }}">{{ ucwords($item->baseCalcule) }}</td>
                <td>
                    <select name="TypeApplicable" id="TypeApplicable{{ $item->id }}" class="form-control select-picker assign_Update" data-size="8" data-row-id="{{ $item->id }}" contenteditable="true">
                        <option value="Taux" @if($item->TypeApplicable=='Taux') selected @endif>Taux Applicable au SBI</option>
                        <option value="Montant" @if($item->TypeApplicable=='Montant') selected @endif>Montant Fixe</option>
                    </select>
                </td>
                <td>
                    <select name="type_obligation" id="type_obligation{{ $item->id }}" class="form-control select-picker assign_Update" data-size="8" data-row-id="{{ $item->id }}" contenteditable="true">
                        <option value="sociale" @if($item->type_obligation=='sociale') selected @endif>Sociale</option>
                        <option value="fiscale" @if($item->type_obligation=='fiscale') selected @endif>Fiscale</option>
                    </select>
                </td>
                <td class="text-right">
                    @if ($deleteDesignationPermission == 'all' || $deleteDesignationPermission == 'added')
                        <x-forms.button-secondary data-row-id="{{ $item->id }}" icon="trash" class="delete-row">
                            </x-forms.button-secondary>
                    @endif
            </tr>
        @empty
            <tr>
                <td class="text-center" colspan="8">@lang('messages.noRecordFound')</td>
            </tr>
        @endforelse
    </x-table>
    <x-forms.button-cancel data-dismiss="modal" class="border-0 mr-3">@lang('app.close')</x-forms.button-cancel>
</div>
<script>
    $('.delete-row').click(function() {

        var id = $(this).data('row-id');
        var url = "{{ route('salaireTaxe.destroy', ':id') }}";
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

    $('#save-salaireTaxe').click(function() {
        var url = "{{ route('salaireTaxe.store') }}";
        console.log(url);
        $.easyAjax({
            url: url,
            container: '#createSalaireTaxe',
            type: "POST",
            data: $('#createSalaireTaxe').serialize(),
            disableButton: true,
            blockUI: true,
            buttonSelector: "#save-salaireTaxe",
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
    function _updateSalaireTaxe(id) {
        var TypeApplicable=$('#TypeApplicable'+id).val();
        var type_obligation=$('#type_obligation'+id).val();
        var libelle_taxe=$('#libelle_taxe'+id).html();
        var taux_salarial=$('#taux_salarial'+id).html();
        var taux_patronal=$('#taux_patronal'+id).html();
        var baseCalcule=$('#baseCalcule'+id).html();
        var methodeCalcul=$('#methodeCalcul'+id).val();
        var url = "{{ route('salaireTaxe.update', ':id') }}";
            url = url.replace(':id', id);
            var token = "{{ csrf_token() }}";
            $.easyAjax({
                url: url,
                container: '#row-' + id,
                type: "POST",
                data: {
                    'libelle_taxe': libelle_taxe,
                    'taux_salarial': taux_salarial,
                    'taux_patronal': taux_patronal,
                    'TypeApplicable': TypeApplicable,
                    'type_obligation': type_obligation,
                    'baseCalcule': baseCalcule,
                    'methodeCalcul': methodeCalcul,
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
    $('body').on('change', '.assign_Update', function() {
        let id = $(this).data('row-id');
        _updateSalaireTaxe(id)
    });

    // $('[contenteditable=true]').focus(function() {
    //     $(this).data("initialText", $(this).html());
    //     let rowId = $(this).data('row-id');
    // }).blur(function() {
    //     if ($(this).data("initialText") !== $(this).html()) {
    //         let id = $(this).data('row-id');
    //         _updateSalaireTaxe(id)
    //     }
    // });

</script>
