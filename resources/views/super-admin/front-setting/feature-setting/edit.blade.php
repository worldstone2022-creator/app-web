<style>
    .iconpicker{
        border-radius:0.25rem !important;
    }
</style>
<div class="modal-header">
    <h5 class="modal-title">@lang('app.update') @lang('superadmin.feature')</h5>

    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>

<div class="modal-body">
    <div class="portlet-body">
        <x-form id="editFeature" method="PUT" class="ajax-form">
            <div class="form-group">
                <div class="row">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <div class="col-lg-6">
                        <x-forms.select fieldId="language" :fieldLabel="__('app.language')" fieldName="language">
                            @foreach ($languageSettings as $language)
                                <option
                                    @if($language->id === $feature->language_setting_id) selected @endif
                                    data-content="<span class='flag-icon flag-icon-{{ $language->flag_code == 'en' ? 'gb' : strtolower($language->flag_code) }} flag-icon-squared'></span> {{ $language->language_name }}"
                                    value="{{ $language->id }}">{{ $language->language_name }}</option>
                            @endforeach
                        </x-forms.select>
                    </div>
                    <div class="col-lg-6">
                        <x-forms.text :fieldLabel="__('app.title')" fieldName="title" autocomplete="off" :fieldValue="$feature->title" fieldId="title" />
                    </div>

                    @if(isset($type) && $type == 'icon')
                        <div class="col-lg-6">
                            <div class="form-group my-3">
                                <x-forms.label class="control-label" fieldId="description" :fieldLabel="__('superadmin.types.icon')">
                                </x-forms.label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text h-100 selected-icon"></span>
                                    </div>
                                    <input type="text" name="icon" value="{{$feature->icon}}" class="form-control iconpicker p-2">
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($type != 'apps')
                        <div class="col-md-12">
                            <div class="form-group my-3">
                                <div class="form-group my-3">
                                    <x-forms.label fieldId="description" :fieldLabel="__('app.description')">
                                    </x-forms.label>
                                    <div id="description">{!! $feature->description !!}</div>
                                    <textarea name="description" id="description_text" class="d-none"></textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ((isset($type) && $type == 'image') || $type == 'apps')
                        <div class="col-md-12">
                            <x-forms.file allowedFileExtensions="png jpg jpeg svg" class="mr-lg-2 mr-md-2 mr-0"
                                :fieldValue="$feature->image_url"
                                :fieldLabel="__('superadmin.types.image') . ' (400x352)'" fieldName="image" fieldId="image" :popover="__('superadmin.featureImageSizeMessage')">
                            </x-forms.file>
                        </div>
                    @endif
                </div>
            </div>
        </x-form>
    </div>
</div>
<div class="modal-footer">
    <x-forms.button-cancel data-dismiss="modal" class="border-0 mr-3">@lang('app.cancel')</x-forms.button-cancel>
    <x-forms.button-primary id="edit-feature" icon="check">@lang('app.save')</x-forms.button-primary>
</div>
<script src="{{ asset('vendor/iconpicker-master/dist/iconpicker.js') }}"></script>

<script>
    $(".select-picker").selectpicker();

    @if($type != 'apps')
        $(document).ready(function() {
            quillImageLoad('#description');
        });
    @endif

    $("#edit-feature").click(function(event) {
        @if($type != 'apps')
            document.getElementById('description_text').value = document.getElementById('description').children[0]
                .innerHTML;
        @endif

        $.easyAjax({
            url: "{{ route('superadmin.front-settings.features-settings.update', $feature->id) }}",
            container: '#editFeature',
            type: "POST",
            blockUI: true,
            file: true,
            data: $('#editFeature').serialize(),
            success: function(response) {
                if (response.status == "success") {
                    $('#table-view').html(response.html);
                    $(MODAL_LG).modal('hide');
                }
            }
        })
    });

    @if($type == 'icon')
        (async () => {
            const response = await fetch("{{asset('vendor/iconpicker-master/dist/iconsets/bootstrap5.json')}}")
            const result = await response.json()
            const iconpicker = new Iconpicker(document.querySelector(".iconpicker"), {
                    icons: result,
                    showSelectedIn: document.querySelector(".selected-icon"),
                    defaultValue: "{{$feature->icon}}",
            });
            iconpicker.set() // Set as empty
            iconpicker.set("{{$feature->icon}}") // Reset with a value
        })()

        new Iconpicker(document.querySelector('.iconpicker'), {
            showSelectedIn: document.querySelector('.selected-icon'),
            icons: ['fa-times', 'fa-check'],
            valueFormat: val => `fa ${val}`
        })

        new Iconpicker(document.querySelector('.iconpicker'), {
            // hide the icon picker on select
            hideOnSelect: true,
            // CSS class added to the selected icon
            selectedClass: 'selected',
            // default icon
            defaultValue: '',
            // all icons
            icons: ['bi-alarm-fill'],
            // is searchable?
            searchable: true,
            // CSS class added to the container
            containerClass: '',
            // element to show selected icon
            showSelectedIn: '',
            // enable fade animation
            fade: false,
            // custom value format
            valueFormat: val => `bi ${val}`,
        })
    @endif

    init('#editFeature');

</script>
