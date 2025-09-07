@extends('layouts.app')

@section('content')
<div class="tw-container tw-mx-auto tw-px-4 tw-py-6">
    <div class="tw-max-w-4xl tw-mx-auto">
        <div class="tw-bg-white tw-shadow tw-overflow-hidden tw-sm:rounded-lg">
            <div class="tw-px-4 tw-py-5 tw-sm:px-6 tw-flex tw-justify-between tw-items-center">
                <div>
                    <h3 class="tw-text-lg tw-leading-6 tw-font-medium tw-text-gray-900">
                        Visite médicale - {{ $medicalVisit->user->name }} | {{ $medicalVisit->user->email }}
                    </h3>
                    <p class="tw-mt-1 tw-max-w-2xl tw-text-sm tw-text-gray-500">
                        {{ $medicalVisit->visit_type }}
                    </p>
                </div>
                <div class="tw-flex tw-space-x-3">
                    <a href="{{ route('medical-visits.edit', $medicalVisit) }}" 
                       class="tw-bg-yellow-600 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-hover:bg-yellow-700">
                        Modifier
                    </a>
                </div>
            </div>
            <div class="tw-border-t tw-border-gray-200">
                <dl>
                    <div class="tw-bg-gray-50 tw-px-4 tw-py-5 tw-sm:grid tw-sm:grid-cols-3 tw-sm:gap-4 tw-sm:px-6">
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Utilisateur</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 tw-sm:mt-0 tw-sm:col-span-2">
                            {{ $medicalVisit->user->name }} {{ $medicalVisit->user->last_name }}
                        </dd>
                    </div>
                    <div class="tw-bg-white tw-px-4 tw-py-5 tw-sm:grid tw-sm:grid-cols-3 tw-sm:gap-4 tw-sm:px-6">
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Type de visite</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 tw-sm:mt-0 tw-sm:col-span-2">
                            <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-blue-100 tw-text-blue-800">
                                {{ $medicalVisit->visit_type }}
                            </span>
                        </dd>
                    </div>
                    <div class="tw-bg-gray-50 tw-px-4 tw-py-5 tw-sm:grid tw-sm:grid-cols-3 tw-sm:gap-4 tw-sm:px-6">
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Objet</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 tw-sm:mt-0 tw-sm:col-span-2">
                            {{ $medicalVisit->visit_object }}
                        </dd>
                    </div>
                    <div class="tw-bg-white tw-px-4 tw-py-5 tw-sm:grid tw-sm:grid-cols-3 tw-sm:gap-4 tw-sm:px-6">
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Médecin traitant</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 tw-sm:mt-0 tw-sm:col-span-2">
                            {{ $medicalVisit->doctor_name }}
                        </dd>
                    </div>
                    <div class="tw-bg-gray-50 tw-px-4 tw-py-5 tw-sm:grid tw-sm:grid-cols-3 tw-sm:gap-4 tw-sm:px-6">
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Date programmée</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 tw-sm:mt-0 tw-sm:col-span-2">
                             {{ $medicalVisit->scheduled_date->format('d/m/Y') }}
                           {{-- @if($medicalVisit->is_overdue)
                                <span class="tw-ml-2 tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-red-100 tw-text-red-800">
                                    En retard
                                </span>
                            @endif --}}
                        </dd>
                    </div>
                    @if($medicalVisit->visit_date)
                    <div class="tw-bg-white tw-px-4 tw-py-5 tw-sm:grid tw-sm:grid-cols-3 tw-sm:gap-4 tw-sm:px-6">
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Date effectuée</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 tw-sm:mt-0 tw-sm:col-span-2">
                            {{ $medicalVisit->visit_date->format('d/m/Y') }}
                        </dd>
                    </div>
                    @endif
                    <div class="tw-bg-gray-50 tw-px-4 tw-py-5 tw-sm:grid tw-sm:grid-cols-3 tw-sm:gap-4 tw-sm:px-6">
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Résultat</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 tw-sm:mt-0 tw-sm:col-span-2">
                            @if($medicalVisit->result === 'Apte')
                                <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-green-100 tw-text-green-800">
                                    Apte
                                </span>
                            @elseif($medicalVisit->result === 'Inapte')
                                <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-red-100 tw-text-red-800">
                                    Inapte
                                </span>
                            @else
                                <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-gray-100 tw-text-gray-800">
                                    Non effectué
                                </span>
                            @endif
                        </dd>
                    </div>
                    @if($medicalVisit->certificate_path)
                    <div class="tw-bg-white tw-px-4 tw-py-5 tw-sm:grid tw-sm:grid-cols-3 tw-sm:gap-4 tw-sm:px-6">
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Certificat médical</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 tw-sm:mt-0 tw-sm:col-span-2">
                            <a href="{{ route('medical-visits.download-certificate', $medicalVisit) }}" 
                               class="tw-text-blue-600 tw-hover:text-blue-900">
                                Télécharger le certificat
                            </a>
                        </dd>
                    </div>
                    @endif
                    @if($medicalVisit->notes)
                    <div class="tw-bg-gray-50 tw-px-4 tw-py-5 tw-sm:grid tw-sm:grid-cols-3 tw-sm:gap-4 tw-sm:px-6">
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Notes</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 tw-sm:mt-0 tw-sm:col-span-2">
                            {{ $medicalVisit->notes }}
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        @if(!$medicalVisit->certificate_path && in_array('admin', user_roles()))
        <div class="tw-mt-6 tw-bg-white tw-shadow tw-sm:rounded-lg">
            <div class="tw-px-4 tw-py-5 tw-sm:p-6">
                <h3 class="tw-text-lg tw-leading-6 tw-font-medium tw-text-gray-900 tw-mb-4">
                    Téléverser le certificat médical
                </h3>
                <form action="{{ route('medical-visits.update', $medicalVisit) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ $medicalVisit->user_id }}">
                    <input type="hidden" name="visit_type" value="{{ $medicalVisit->visit_type }}">
                    <input type="hidden" name="visit_object" value="{{ $medicalVisit->visit_object }}">
                    <input type="hidden" name="doctor_name" value="{{ $medicalVisit->doctor_name }}">
                    <input type="hidden" name="scheduled_date" value="{{ $medicalVisit->scheduled_date->format('Y-m-d') }}">
                    <input type="hidden" name="visit_date" value="{{ $medicalVisit->visit_date ? $medicalVisit->visit_date->format('Y-m-d') : now()->format('Y-m-d') }}">
                    <input type="hidden" name="result" value="{{ $medicalVisit->result }}">
                    
                    <div class="tw-grid tw-grid-cols-1 tw-gap-4">
                        <div>
                            <label for="certificate" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                Certificat médical (PDF, JPG, PNG - Max 2MB)
                            </label>
                            <input type="file" name="certificate" id="certificate" accept=".pdf,.jpg,.jpeg,.png"
                                   class="tw-mt-1 tw-block tw-w-full tw-text-sm tw-text-gray-500 
                                          file:tw-mr-4 file:tw-py-2 file:tw-px-4 
                                          file:tw-rounded-full file:tw-border-0 
                                          file:tw-text-sm file:tw-font-semibold 
                                          file:tw-bg-blue-50 file:tw-text-blue-700 
                                          hover:file:tw-bg-blue-100">
                        </div>
                        <div class="tw-flex tw-justify-end">
                            <button type="submit" 
                                    class="tw-bg-blue-600 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-hover:bg-blue-700">
                                Téléverser
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection