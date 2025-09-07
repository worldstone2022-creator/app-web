@php
$addDesignationPermission = user()->permission('add_designation');
$addDepartmentPermission = user()->permission('add_department');
@endphp

<link rel="stylesheet" href="{{ asset('vendor/css/tagify.css') }}">

<div class="row">
    <div class="col-sm-12">
        <x-form id="save-employee-data-form">

            @include('sections.password-autocomplete-hide')

            <div class="add-client bg-white rounded">
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('modules.employees.accountDetails')</h4>
                <div class="row p-20">
                    <div class="col-lg-9 col-xl-10">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <x-forms.text fieldId="employee_id" :fieldLabel="__('modules.employees.employeeId')"
                                    fieldName="employee_id" :fieldValue="($lastEmployeeID+1)" fieldRequired="true"
                                    :fieldPlaceholder="__('modules.employees.employeeIdInfo')">
                                </x-forms.text>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <x-forms.text fieldId="name" :fieldLabel="__('modules.employees.employeeName')"
                                    fieldName="name" fieldRequired="true" :fieldPlaceholder="__('placeholders.name')">
                                </x-forms.text>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <x-forms.text fieldId="lastname" :fieldLabel="__('modules.employees.lastname')"
                                    fieldName="lastname" fieldRequired="true" :fieldPlaceholder="__('placeholders.lastname')">
                                </x-forms.text>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <x-forms.datepicker fieldId="date_of_birth" :fieldLabel="__('modules.employees.dateOfBirth')"
                                    fieldName="date_of_birth" :fieldPlaceholder="__('placeholders.date')" />
                            </div>
                            <div class="col-lg-3 col-md-6">
                              <x-forms.text fieldId="birth_place" :fieldLabel="__('modules.employees.birth_place')"
                                  fieldName="birth_place" :fieldPlaceholder="__('placeholders.birth_place')">
                              </x-forms.text>
                            </div>
                            <div class="col-lg-3 col-md-6">
                              <x-forms.select fieldId="country" :fieldLabel="__('app.country')" fieldName="country"
                                  search="true">
                                  <option value="">--</option>
                                  @foreach ($countries as $item)
                                    <option data-tokens="{{ $item->iso3 }}"
                                      data-content="<span class='flag-icon flag-icon-{{ strtolower($item->iso) }} flag-icon-squared'></span> {{ $item->nicename }}"
                                      value="{{ $item->id }}">{{ $item->nicename }}
                                    </option>
                                  @endforeach
                              </x-forms.select>
                            </div>
                            <div class="col-lg-2 col-md-4">
                              <x-forms.select fieldId="gender" :fieldLabel="__('modules.employees.gender')"
                                  fieldName="gender">
                                  <option value="">--</option>
                                  <option value="male">@lang('app.male')</option>
                                  <option value="female">@lang('app.female')</option>
                              </x-forms.select>
                            </div>
                            <div class="col-lg-2 col-md-4">
                              <x-forms.select fieldId="marital_status" :fieldLabel="__('modules.employees.marital_status')"
                                  fieldName="marital_status">
                                  <option value="">--</option>
                                  <option value="Célibataire">@lang('app.Single')</option>
                                  <option value="Marié">@lang('app.Married')</option>
                                  <option value="Divorcé">@lang('app.Divorced')</option>
                                  <option value="Veuf">@lang('app.Widowed')</option>
                              </x-forms.select>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <x-forms.number fieldId="children_number" :fieldLabel="__('modules.employees.children_number')" step=".01" min="0"
                                    fieldName="children_number" fieldRequired="false" :fieldPlaceholder="__('placeholders.children_number')">
                                </x-forms.number>
                            </div>

                            
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-2">
                        <x-forms.file allowedFileExtensions="png jpg jpeg" class="mr-0 mr-lg-2 mr-md-2 cropper"
                            :fieldLabel="__('modules.profile.profilePicture')" fieldName="image" fieldId="image"
                            fieldHeight="119" :popover="__('messages.fileFormat.ImageFile')" />
                    </div>
                    
                    <div class="col-lg-2 col-md-4">
                      <x-forms.select fieldId="type_ID" :fieldLabel="__('modules.employees.type_ID')"
                          fieldName="type_ID">
                        <option value="">--</option>
                        <option value="CNI">CNI</option>
                        <option value="Attestation d'identité">Attestation d'identité</option>
                        <option value="Passeport">Passeport</option>
                        <option value="Autre">Autre</option>
                      </x-forms.select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                      <x-forms.text fieldId="num_ID" :fieldLabel="__('modules.employees.num_ID')"
                          fieldName="num_ID" :fieldPlaceholder="__('placeholders.num_ID')">
                      </x-forms.text>
                    </div>
                    <div class="col-lg-2 col-md-4">
                      <x-forms.text fieldId="email" :fieldLabel="__('modules.employees.employeeEmail')"
                          fieldName="email" fieldRequired="true" :fieldPlaceholder="__('placeholders.email')">
                      </x-forms.text>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <x-forms.label class="mt-3" fieldId="password"
                            :fieldLabel="__('app.password')" fieldRequired="true">
                        </x-forms.label>
                        <x-forms.input-group>

                            <input type="password" name="password" id="password"
                                class="form-control height-35 f-14">
                            <x-slot name="preappend">
                                <button type="button" data-toggle="tooltip"
                                    data-original-title="@lang('app.viewPassword')"
                                    class="btn btn-outline-secondary border-grey height-35 toggle-password"><i
                                        class="fa fa-eye"></i></button>
                            </x-slot>
                            <x-slot name="append">
                                <button id="random_password" type="button" data-toggle="tooltip"
                                    data-original-title="@lang('modules.client.generateRandomPassword')"
                                    class="btn btn-outline-secondary border-grey height-35"><i
                                        class="fa fa-random"></i></button>
                            </x-slot>
                        </x-forms.input-group>
                        <small class="form-text text-muted">@lang('placeholders.password')</small>
                    </div>
                    <div class="col-lg-2 col-md-4">
                      <x-forms.tel fieldId="mobile" :fieldLabel="__('app.mobile')" fieldName="mobile"
                      fieldPlaceholder="EX:0701010101"></x-forms.tel>
                    </div>
                    <div class="col-lg-2 col-md-4">
                      <x-forms.tel fieldId="other_mobile" :fieldLabel="__('app.other_mobile')" fieldName="other_mobile"
                      fieldPlaceholder="EX:0102030405"></x-forms.tel>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <x-forms.label class="my-3" fieldId="category_id"
                            :fieldLabel="__('app.designation')" fieldRequired="true">
                        </x-forms.label>
                        <x-forms.input-group>
                            <select class="form-control select-picker" name="designation"
                                id="employee_designation" data-live-search="true">
                                <option value="">--</option>
                                @foreach ($designations as $designation)
                                    <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                @endforeach
                            </select>

                            @if ($addDesignationPermission == 'all' || $addDesignationPermission == 'added')
                                <x-slot name="append">
                                    <button id="designation-setting-add" type="button"
                                        class="btn btn-outline-secondary border-grey">@lang('app.add')</button>
                                </x-slot>
                            @endif
                        </x-forms.input-group>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <x-forms.label class="my-3" fieldId="category_id"
                            :fieldLabel="__('app.department')" fieldRequired="true">
                        </x-forms.label>
                        <x-forms.input-group>
                            <select class="form-control select-picker" name="department"
                                id="employee_department" data-live-search="true">
                                <option value="">--</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                @endforeach
                            </select>

                            @if ($addDepartmentPermission == 'all' || $addDepartmentPermission == 'added')
                                <x-slot name="append">
                                    <button type="button"
                                        class="btn btn-outline-secondary border-grey department-setting">@lang('app.add')</button>
                                </x-slot>
                            @endif
                        </x-forms.input-group>
                    </div>
                    <div class="col-lg-3 col-md-6">
                      <x-forms.text fieldId="num_cnps" :fieldLabel="__('modules.employees.num_cnps')"
                          fieldName="num_cnps" :fieldPlaceholder="__('placeholders.num_cnps')">
                      </x-forms.text>
                    </div>
                    <div class="col-lg-3 col-md-6">
                      <x-forms.text fieldId="bank_account_num" :fieldLabel="__('modules.employees.bank_account_num')" fieldName="bank_account_num"
                      fieldPlaceholder="N° de compte bancaire"></x-forms.text>
                    </div>
                    <div class="col-lg-2 col-md-4">
                      <x-forms.datepicker fieldId="joining_date" :fieldLabel="__('modules.employees.joiningDate')"
                          fieldName="joining_date" :fieldPlaceholder="__('placeholders.date')" fieldRequired="true"
                          :fieldValue="now(global_setting()->timezone)->format(global_setting()->date_format)" />
                    </div>
                    <div class="col-lg-2 col-md-4">
                      <x-forms.datepicker fieldId="date_end_contrat" :fieldLabel="__('modules.employees.date_end_contrat')"
                          fieldName="date_end_contrat" :fieldPlaceholder="__('placeholders.date')" />
                    </div>
                    <div class="col-lg-2 col-md-4">
                      <x-forms.select fieldId="type_contrat" :fieldLabel="__('modules.employees.type_contrat')"
                          fieldName="type_contrat">
                          <option value="">--</option>
                          <option value="CDD">CDD</option>
                          <option value="CDI">CDI</option>
                          <option value="Intérim">Intérim</option>
                          <option value="Consultance">Consultance</option>
                          <option value="Freelance">Freelance</option>
                          <option value="Temps partiel">Temps partiel</option>
                          <option value="Saisonnier">Saisonnier</option>
                          <option value="Apprentissage">Apprentissage</option>
                      </x-forms.select>
                    </div>
                    <div class="col-lg-6 col-md-6">
                      <x-forms.text fieldId="address" :fieldLabel="__('app.address')"
                          fieldName="address" fieldRequired="false" :fieldPlaceholder="__('placeholders.address')">
                      </x-forms.text>
                    </div>

                </div>

                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-top-grey">
                    @lang('modules.client.clientOtherDetails')</h4>
                <div class="row p-20">
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.client.clientCanLogin')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="login-yes" :fieldLabel="__('app.yes')" fieldName="login"
                                    fieldValue="enable" checked="true">
                                </x-forms.radio>
                                <x-forms.radio fieldId="login-no" :fieldLabel="__('app.no')" fieldValue="disable"
                                    fieldName="login"></x-forms.radio>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.emailSettings.emailNotifications')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="notification-yes" :fieldLabel="__('app.yes')" fieldValue="yes"
                                    fieldName="email_notifications" checked="true">
                                </x-forms.radio>
                                <x-forms.radio fieldId="notification-no" :fieldLabel="__('app.no')" fieldValue="no"
                                    fieldName="email_notifications">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4">
                      <x-forms.label class="my-3" fieldId="hourly_rate"
                          :fieldLabel="__('modules.employees.hourlyRate')"></x-forms.label>
                      <x-forms.input-group>
                          <x-slot name="prepend">
                              <span
                                  class="input-group-text f-14 bg-white-shade">{{ global_setting()->currency->currency_symbol }}</span>
                          </x-slot>

                          <input type="number" step=".01" min="0" class="form-control height-35 f-14"
                              name="hourly_rate" id="hourly_rate">
                      </x-forms.input-group>
                    </div>
                    <div class="col-lg-2 col-md-4">
                      <x-forms.label class="my-3" fieldId="nbre_heure_semaine"
                          :fieldLabel="__('modules.employees.nbre_heure_semaine')"></x-forms.label>
                      <x-forms.input-group>
                          <x-slot name="prepend">
                              <span
                                  class="input-group-text f-14 bg-white-shade"><i class="fa fa-clock" aria-hidden="true"></i></span>
                          </x-slot>

                          <input type="number" step=".01" min="0" class="form-control height-35 f-14"
                              name="nbre_heure_semaine" id="nbre_heure_semaine">
                      </x-forms.input-group>
                    </div>
                    

                    <div class="col-lg-3 col-md-6" style="display:none">
                        <x-forms.label class="my-3" fieldId="slack_username"
                            :fieldLabel="__('modules.employees.slackUsername')"></x-forms.label>
                        <x-forms.input-group>
                            <x-slot name="prepend">
                                <span class="input-group-text f-14 bg-white-shade">@</span>
                            </x-slot>

                            <input type="text" class="form-control height-35 f-14" name="slack_username"
                                id="slack_username" value="">
                        </x-forms.input-group>
                    </div>

                    <div class="col-md-12">
                        <x-forms.text fieldId="tags" :fieldLabel="__('app.skills')" fieldName="tags"
                            :fieldPlaceholder="__('placeholders.skills')" />
                    </div>

                    @if (function_exists('sms_setting') && sms_setting()->telegram_status)
                        <div class="col-md-4">
                            <x-forms.number fieldName="telegram_user_id" fieldId="telegram_user_id"
                                fieldLabel="<i class='fab fa-telegram'></i> {{ __('sms::modules.telegramUserId') }}"
                                :popover="__('sms::modules.userIdInfo')" />
                        </div>
                    @endif

                </div>

                @if (isset($fields) && count($fields) > 0)
                    <div class="row p-20">
                        @foreach ($fields as $field)
                            <div class="col-md-4">
                                @if ($field->type == 'text')
                                    <x-forms.text fieldId="custom_fields_data[{{ $field->name . '_' . $field->id }}]"
                                        :fieldLabel="$field->label"
                                        fieldName="custom_fields_data[{{ $field->name . '_' . $field->id }}]"
                                        :fieldPlaceholder="$field->label"
                                        :fieldRequired="($field->required === 'yes') ? true : false">
                                    </x-forms.text>
                                @elseif($field->type == 'wordword')
                                    <x-forms.password
                                        fieldId="custom_fields_data[{{ $field->name . '_' . $field->id }}]"
                                        :fieldLabel="$field->label"
                                        fieldName="custom_fields_data[{{ $field->name . '_' . $field->id }}]"
                                        :fieldPlaceholder="$field->label"
                                        :fieldRequired="($field->required === 'yes') ? true : false">
                                    </x-forms.password>
                                @elseif($field->type == 'number')
                                    <x-forms.number
                                        fieldId="custom_fields_data[{{ $field->name . '_' . $field->id }}]"
                                        :fieldLabel="$field->label"
                                        fieldName="custom_fields_data[{{ $field->name . '_' . $field->id }}]"
                                        :fieldPlaceholder="$field->label"
                                        :fieldRequired="($field->required === 'yes') ? true : false">
                                    </x-forms.number>
                                @elseif($field->type == 'textarea')
                                    <x-forms.textarea :fieldLabel="$field->label"
                                        fieldName="custom_fields_data[{{ $field->name . '_' . $field->id }}]"
                                        fieldId="custom_fields_data[{{ $field->name . '_' . $field->id }}]"
                                        :fieldRequired="($field->required === 'yes') ? true : false"
                                        :fieldPlaceholder="$field->label">
                                    </x-forms.textarea>
                                @elseif($field->type == 'radio')
                                    <div class="form-group my-3">
                                        <x-forms.label
                                            fieldId="custom_fields_data[{{ $field->name . '_' . $field->id }}]"
                                            :fieldLabel="$field->label"
                                            :fieldRequired="($field->required === 'yes') ? true : false">
                                        </x-forms.label>
                                        <div class="d-flex">
                                            @foreach ($field->values as $key => $value)
                                                <x-forms.radio fieldId="optionsRadios{{ $key . $field->id }}"
                                                    :fieldLabel="$value"
                                                    fieldName="custom_fields_data[{{ $field->name . '_' . $field->id }}]"
                                                    :fieldValue="$value" :checked="($key == 0) ? true : false" />
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif($field->type == 'select')
                                    <div class="form-group my-3">
                                        <x-forms.label
                                            fieldId="custom_fields_data[{{ $field->name . '_' . $field->id }}]"
                                            :fieldLabel="$field->label"
                                            :fieldRequired="($field->required === 'yes') ? true : false">
                                        </x-forms.label>
                                        {!! Form::select('custom_fields_data[' . $field->name . '_' . $field->id . ']', $field->values, isset($editUser) ? $editUser->custom_fields_data['field_' . $field->id] : '', ['class' => 'form-control select-picker']) !!}
                                    </div>
                                @elseif($field->type == 'date')
                                    <x-forms.datepicker custom="true"
                                        fieldId="custom_fields_data[{{ $field->name . '_' . $field->id }}]"
                                        :fieldRequired="($field->required === 'yes') ? true : false"
                                        :fieldLabel="$field->label"
                                        fieldName="custom_fields_data[{{ $field->name . '_' . $field->id }}]"
                                        :fieldValue="now()->timezone(global_setting()->timezone)->format(global_setting()->date_format)"
                                        :fieldPlaceholder="$field->label" />
                                @elseif($field->type == 'checkbox')
                                    <div class="form-group my-3">
                                        <x-forms.label
                                            fieldId="custom_fields_data[{{ $field->name . '_' . $field->id }}]"
                                            :fieldLabel="$field->label"
                                            :fieldRequired="($field->required === 'yes') ? true : false">
                                        </x-forms.label>
                                        <div class="d-flex checkbox-{{ $field->id }}">
                                            <input type="hidden"
                                                name="custom_fields_data[{{ $field->name . '_' . $field->id }}]"
                                                id="{{ $field->name . '_' . $field->id }}">

                                            @foreach ($field->values as $key => $value)
                                                <x-forms.checkbox fieldId="optionsRadios{{ $key . $field->id }}"
                                                    :fieldLabel="$value" fieldName="$field->name.'_'.$field->id.'[]'"
                                                    :fieldValue="$value"
                                                    onchange="checkboxChange('checkbox-{{ $field->id }}', '{{ $field->name . '_' . $field->id }}')"
                                                    :fieldRequired="($field->required === 'yes') ? true : false" />
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <x-form-actions>
                    <x-forms.button-primary id="save-employee-form" class="mr-3" icon="check">
                        @lang('app.save')
                    </x-forms.button-primary>
                    <x-forms.button-cancel :link="route('employees.index')" class="border-0">@lang('app.cancel')
                    </x-forms.button-cancel>

                </x-form-actions>
            </div>
        </x-form>

    </div>
</div>

<script src="{{ asset('vendor/jquery/tagify.min.js') }}"></script>
<script>
    $(document).ready(function() {

        if ($('.custom-date-picker').length > 0) {
            datepicker('.custom-date-picker', {
                position: 'bl',
                ...datepickerConfig
            });
        }

        datepicker('#joining_date', {
            position: 'bl',
            ...datepickerConfig
        });

        datepicker('#date_of_birth', {
            position: 'bl',
            maxDate: new Date(),
            ...datepickerConfig
        });
        datepicker('#date_end_contrat', {
            position: 'bl',
            minDate: new Date(),
            ...datepickerConfig
        });
        

        var input = document.querySelector('input[name=tags]'),
            // init Tagify script on the above inputs
            tagify = new Tagify(input);

        $('#save-employee-form').click(function() {
            const url = "{{ route('employees.store') }}";

            $.easyAjax({
                url: url,
                container: '#save-employee-data-form',
                type: "POST",
                disableButton: true,
                blockUI: true,
                buttonSelector: "#save-employee-form",
                file: true,
                data: $('#save-employee-data-form').serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        if ($(MODAL_XL).hasClass('show')) {
                            $(MODAL_XL).hide();
                            window.location.reload();
                        } else {
                            window.location.href = response.redirectUrl;
                        }
                    }
                }
            });
        });

        $('#random_password').click(function() {
            const randPassword = Math.random().toString(36).substr(2, 8);

            $('#password').val(randPassword);
        });

        $('#designation-setting-add').click(function() {
            const url = "{{ route('designations.create') }}";
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        })

        $('.department-setting').click(function() {
            const url = "{{ route('departments.create') }}";
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });

        init(RIGHT_MODAL);
    });

    function checkboxChange(parentClass, id) {
        var checkedData = '';
        $('.' + parentClass).find("input[type= 'checkbox']:checked").each(function() {
            checkedData = (checkedData !== '') ? checkedData + ', ' + $(this).val() : $(this).val();
        });
        $('#' + id).val(checkedData);
    }

    $('.cropper').on('dropify.fileReady', function(e) {
        var inputId = $(this).find('input').attr('id');
        var url = "{{ route('cropper', ':element') }}";
        url = url.replace(':element', inputId);
        $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
        $.ajaxModal(MODAL_LG, url);
    });
</script>
