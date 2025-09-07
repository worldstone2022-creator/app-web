<style>
    .card-img {
        width: 120px;
        height: 120px;
    }

    .card-img img {
        width: 120px;
        height: 120px;
        object-fit: cover;
    }

</style>

@php
$editEmployeePermission = user()->permission('edit_employees');
@endphp

<div class="d-lg-flex">
  <div class="project-left w-100 py-0 py-lg-5 py-md-0">
    <!-- ROW START -->
    <div class="row">
      <!--  USER CARDS START -->
      <div class="col-lg-12 col-md-12 mb-4 mb-xl-0 mb-lg-4 mb-md-0">
        <div class="row">
          <div class="col-xl-6 col-md-6 mb-4 mb-lg-0">
            <x-cards.user :image="$employee->image_url">
              <div class="row">
                <div class="col-10">
                  <h4 class="card-title f-15 f-w-500 text-darkest-grey mb-0">
                    {{ ucfirst($employee->salutation) . ' ' . ucwords($employee->name)}}
                    @isset($employee->country)
                      <x-flag :iso="$employee->country->iso" />
                    @endisset
                  </h4>
                </div>
                  @if ($editEmployeePermission == 'all' || ($editEmployeePermission == 'added' && $employee->employeeDetail->added_by == user()->id))
                    <div class="col-2 text-right">
                      <div class="dropdown">
                        <button class="btn f-14 px-0 py-0 text-dark-grey dropdown-toggle"
                          type="button" data-toggle="dropdown" aria-haspopup="true"
                          aria-expanded="false">
                          <i class="fa fa-ellipsis-h"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0"
                          aria-labelledby="dropdownMenuLink" tabindex="0">
                          <a class="dropdown-item openRightModal"href="{{ route('paie.show', $employee->id). '?tab=calcul' }}">Éditer bulletin de salaire</a>
                        </div>
                      </div>
                    </div>
                  @endif
              </div>
              <p class="f-13 font-weight-normal text-dark-grey mb-0">
                {{ !is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->designation) ? ucwords($employee->employeeDetail->designation->name) : '' }}
                &bull;
                {{ isset($employee->employeeDetail) && !is_null($employee->employeeDetail->department) && !is_null($employee->employeeDetail->department) ? ucwords($employee->employeeDetail->department->team_name) : '' }}
              </p>
              @if ($employee->status == 'active')
                <p class="card-text f-12 text-lightest">@lang('app.lastLogin')
                    @if (!is_null($employee->last_login))
                      {{ $employee->last_login->timezone(global_setting()->timezone)->format(global_setting()->date_format . ' ' . global_setting()->time_format) }}
                    @else
                        --
                    @endif
                </p>
              @else
                <p class="card-text f-12 text-lightest">
                  <x-status :value="__('app.inactive')" color="red" />
                </p>
              @endif
       
            </x-cards.user>
            <x-cards.data :title="__('modules.client.profileInfo')" class=" mt-4">
              <x-cards.data-row :label="__('modules.employees.employeeId')"
              :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->employee_id)) ? ucwords($employee->employeeDetail->employee_id) : '--'" />
              <x-cards.data-row :label="__('modules.employees.employeeName')"
              :value="ucwords($employee->name)" />
              <x-cards.data-row :label="__('modules.employees.lastname')"
              :value="ucwords($employee->lastname)" />
              <x-cards.data-row :label="__('modules.employees.dateOfBirth')"
                :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->date_of_birth)) ? $employee->employeeDetail->date_of_birth->format(global_setting()->date_format) : '--'" />
              <x-cards.data-row :label="__('modules.employees.birth_place')"
              :value="ucwords($employee->employeeDetail->birth_place)" />
              <div class="col-12 px-0 pb-3 d-block d-lg-flex d-md-flex">
                <p class="mb-0 text-lightest f-14 w-30 d-inline-block text-capitalize">
                  @lang('modules.employees.gender')</p>
                <p class="mb-0 text-dark-grey f-14 w-70">
                  <x-gender :gender='$employee->gender' />
                </p>
              </div>
              <x-cards.data-row :label="__('modules.employees.marital_status')" :value="$employee->employeeDetail->marital_status" />
              <x-cards.data-row :label="__('modules.employees.children_number')" :value="$employee->employeeDetail->children_number" />
              <x-cards.data-row :label="__('modules.employees.type_ID')" :value="$employee->employeeDetail->type_ID" />
              <x-cards.data-row :label="__('modules.employees.num_ID')" :value="$employee->employeeDetail->num_ID" />
              <x-cards.data-row :label="__('app.address')"
                :value="$employee->employeeDetail->address ?? '--'" />
              <x-cards.data-row :label="__('app.mobile')"
                  :value="(!is_null($employee->country_id) ? '+'.$employee->country->phonecode.'-' : '--'). $employee->mobile ?? '--'" />
              <x-cards.data-row :label="__('app.other_mobile')"
                  :value="(!is_null($employee->country_id) ? '+'.$employee->country->phonecode.'-' : '--'). $employee->other_mobile ?? '--'" />
              <x-cards.data-row :label="__('app.email')" :value="$employee->email" />
              <x-cards.data-row :label="__('modules.employees.num_cnps')" :value="$employee->employeeDetail->num_cnps" />
              <x-cards.data-row :label="__('modules.employees.bank_account_num')" :value="$employee->employeeDetail->bank_account_num" />

                @if (isset($fields))
                    @foreach ($fields as $field)
                        @if ($field->type == 'text' || $field->type == 'password' || $field->type == 'number')
                            <x-cards.data-row :label="$field->label"
                                :value="$employee->employeeDetail->custom_fields_data['field_'.$field->id] ?? '--'" />
                        @elseif($field->type == 'textarea')
                            <x-cards.data-row :label="$field->label" html="true"
                                :value="$employee->employeeDetail->custom_fields_data['field_'.$field->id] ?? '--'" />
                        @elseif($field->type == 'radio')
                            <x-cards.data-row :label="$field->label"
                                :value="(!is_null($employee->employeeDetail->custom_fields_data['field_' . $field->id]) ? $employee->employeeDetail->custom_fields_data['field_' . $field->id] : '--')" />
                        @elseif($field->type == 'checkbox')
                            <x-cards.data-row :label="$field->label"
                                :value="(!is_null($employee->employeeDetail->custom_fields_data['field_' . $field->id]) ? $employee->employeeDetail->custom_fields_data['field_' . $field->id] : '--')" />
                        @elseif($field->type == 'select')
                            <x-cards.data-row :label="$field->label"
                                :value="(!is_null($employee->employeeDetail->custom_fields_data['field_' . $field->id]) && $employee->employeeDetail->custom_fields_data['field_' . $field->id] != '' ? $field->values[$employee->employeeDetail->custom_fields_data['field_' . $field->id]] : '--')" />
                        @elseif($field->type == 'date')
                            <x-cards.data-row :label="$field->label"
                                :value="(!is_null($employee->employeeDetail->custom_fields_data['field_' . $field->id]) && $employee->employeeDetail->custom_fields_data['field_' . $field->id] != '' ? \Carbon\Carbon::parse($employee->employeeDetail->custom_fields_data['field_' . $field->id])->format(global_setting()->date_format) : '--')" />
                        @endif
                    @endforeach
                @endif
            </x-cards.data> 
          </div>
          <div class="col-xl-6 col-md-6 mb-4 mb-lg-0">
          
            <x-cards.data :title="__('modules.client.clientFichePoste')" class=" mt-0">
              <x-cards.data-row :label="__('app.designation')"
                :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->designation)) ? ucwords($employee->employeeDetail->designation->name) : '--'" />
              <x-cards.data-row :label="__('app.department')"
                :value="(isset($employee->employeeDetail) && !is_null($employee->employeeDetail->department) && !is_null($employee->employeeDetail->department)) ? ucwords($employee->employeeDetail->department->team_name) : '--'" />
              <x-cards.data-row :label="__('modules.employees.joiningDate')"
                :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->joining_date)) ? $employee->employeeDetail->joining_date->format(global_setting()->date_format) : '--'" />
              <x-cards.data-row :label="__('modules.employees.date_end_contrat')"
                :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->date_end_contrat)) ? $employee->employeeDetail->date_end_contrat->format(global_setting()->date_format) : '--'" />

              <x-cards.data-row label="Salaire catégoriel"
                :value="(!is_null($salaire_categoriel)) ? global_setting()->currency->currency_symbol. ' '.$salaire_categoriel->salaire_sc : '0'" />
              <x-cards.data-row label="Prime de Transport"
                :value="(!is_null($employee->employeeDetail)) ? global_setting()->currency->currency_symbol. ' '.$employee->employeeDetail->prime_transport : '0'" />
              <x-cards.data-row label="prime de représentation"
                :value="(!is_null($employee->employeeDetail)) ? global_setting()->currency->currency_symbol. ' '.$employee->employeeDetail->prime_representation : '0'" />
              
              <x-cards.data-row :label="__('modules.employees.type_contrat')" :value="$employee->employeeDetail->type_contrat" />
              <x-cards.data-row :label="__('modules.employees.nbre_heure_semaine')" :value="$employee->employeeDetail->nbre_heure_semaine" />

              <x-cards.data-row :label="__('app.skills')"
                    :value="$employee->skills() ? implode(', ', $employee->skills()) : '--'" />
              <x-cards.data-row label="Activités et tâches"
                    :value="$employee->skills() ? implode(', ', $employee->taches()) : '--'" />
              <x-cards.data-row label="Supérieur Hiérarchique" :value="!is_null($superieur) ? $superieur->name.' '.$superieur->lastname : '--'" />
              <x-cards.data-row label="Expérience professionnelle" :value="$employee->employeeDetail->experiences_professionnelle" />
              <x-cards.data-row label="Formation académique" :value="$employee->employeeDetail->formation_academique" />
                <x-cards.data-row label="Niveau d'étude" :value="!is_null($niveau) ? $niveau->name : '--'" />
              <x-cards.data-row label="Mission" :value="$employee->employeeDetail->mission" />  
            </x-cards.data>

            <div class="col-xl-12 col-lg-12 col-md-12 mt-5">
              <div class="row">
          
              </div>
            </div>
          </div>
          

        </div>
      </div>
      <!--  USER CARDS END -->

      <!--  WIDGETS START -->

      <!--  WIDGETS END -->

    </div>
    <!-- ROW END -->
  </div>


</div>
