<div class="modal-header">
    <h5 class="modal-title">@lang('app.addLanguage')</h5>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <x-form id="createLanguage" method="POST" class="form-horizontal">
            <div class="row">

                <div class="col-lg-6">
                    <x-forms.text :fieldLabel="__('app.name')" :fieldPlaceholder="__('placeholders.language.languageName')" fieldName="language_name" fieldId="language_name" fieldValue="" fieldRequired="true"/>
                </div>

                <div class="col-lg-6">
                    <x-forms.text :fieldLabel="__('app.language_code')" :fieldPlaceholder="__('placeholders.language.languageCode')" fieldName="language_code" fieldId="language_code" fieldValue="" fieldRequired="true"/>
                </div>

                <div class="col-lg-6">
                    <x-forms.select fieldId="flag" :fieldLabel="__('modules.flag')" fieldName="flag" search="true" fieldRequired="true">
                        <option value="">--</option>

                        @foreach ($flags as $flag)
                            <option data-content="<span class='flag-icon flag-icon-{{ $flag->code }} flag-icon-squared'></span> {{ $flag->name }}"
                            value="{{ $flag->code }}">{{ $flag->name }}</option>
                        @endforeach
                    </x-forms.select>
                </div>

                <div class="col-lg-6">
                    <x-forms.select fieldId="status" :fieldLabel="__('app.status')" fieldName="status" search="true">
                        <option value="enabled">@lang('app.enabled')</option>
                        <option value="disabled">@lang('app.disabled')</option>
                    </x-forms.select>
                </div>

                <div class="col-lg-4">
                    <div class="form-group my-3">
                        <x-forms.label class="f-14 text-dark-grey mb-12 w-100" fieldId="is_rtl"
                                               :fieldLabel="__('app.rtlTheme')" fieldRequired="true">
                        </x-forms.label>
                        <div class="d-flex">
                            <x-forms.radio fieldId="rtl-yes" :fieldLabel="__('app.yes')" fieldName="is_rtl" fieldValue="1">
                            </x-forms.radio>
                            <x-forms.radio fieldId="rtl-no" :fieldLabel="__('app.no')" fieldValue="0" fieldName="is_rtl" checked="true">
                            </x-forms.radio>
                        </div>
                    </div>
                </div>
            </div>
        </x-form>
    </div>
</div>
<div class="modal-footer">
    <x-forms.button-cancel data-dismiss="modal" class="border-0 mr-3">@lang('app.cancel')</x-forms.button-cancel>
    <x-forms.button-primary id="save-language" icon="check">@lang('app.save')</x-forms.button-primary>
</div>

<script>

    $(".select-picker").selectpicker();

    $('#save-language').click(function () {
        $.easyAjax({
            container: '#createLanguage',
            type: "POST",
            disableButton: true,
            blockUI: true,
            buttonSelector: "#save-language",
            url: "{{route('language-settings.store')}}",
            data: $('#createLanguage').serialize(),
            success: function (response) {
                if (response.status == 'success') {
                    window.location.reload();
                }
            }
        })
    });

</script>

