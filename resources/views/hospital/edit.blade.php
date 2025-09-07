@extends('layouts.app')

@section('content')
<div class="tw-container tw-mx-auto tw-px-4 tw-py-6">
    <div class="tw-max-w-2xl tw-mx-auto">
        <div class="tw-bg-white tw-shadow tw-sm:rounded-lg">
            <div class="tw-px-4 tw-py-5 tw-sm:p-6">
                <h3 class="tw-text-lg tw-leading-6 tw-font-medium tw-text-gray-900 tw-mb-6">
                    Modifier la visite médicale
                </h3>

                <form method="POST" action="{{ route('medical-visits.update', $medicalVisit) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="tw-grid tw-grid-cols-1 tw-gap-6">
                        <div>
                            <label for="user_id" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                Utilisateur
                            </label>
                            <select name="user_id" id="user_id" 
                                    class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $medicalVisit->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} 
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="visit_type" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                Type de visite
                            </label>
                            <select name="visit_type" id="visit_type" 
                                    class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                <option value="Embauche" {{ $medicalVisit->visit_type == 'Embauche' ? 'selected' : '' }}>Embauche</option>
                                <option value="Périodique" {{ $medicalVisit->visit_type == 'Périodique' ? 'selected' : '' }}>Périodique</option>
                                <option value="Reprise de services" {{ $medicalVisit->visit_type == 'Reprise de services' ? 'selected' : '' }}>Reprise de services</option>
                            </select>
                        </div>

                        <div>
                            <label for="visit_object" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                Objet de la visite
                            </label>
                            <textarea name="visit_object" id="visit_object" rows="3"
                                      class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">{{ $medicalVisit->visit_object }}</textarea>
                        </div>

                        <div class="tw-grid tw-grid-cols-2 tw-gap-4">
                            <div>
                                <label for="doctor_name" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                    Médecin traitant
                                </label>
                                <input type="text" name="doctor_name" id="doctor_name" value="{{ $medicalVisit->doctor_name }}"
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                            </div>

                            <div>
                                <label for="scheduled_date" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                    Date programmée
                                </label>
                                <input type="date" name="scheduled_date" id="scheduled_date" value="{{ $medicalVisit->scheduled_date->format('Y-m-d') }}"
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                            </div>
                        </div>

                        <div class="tw-grid tw-grid-cols-2 tw-gap-4">
                            <div>
                                <label for="visit_date" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                    Date effectuée
                                </label>
                                <input type="date" name="visit_date" id="visit_date" value="{{ $medicalVisit->visit_date ? $medicalVisit->visit_date->format('Y-m-d') : '' }}"
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                            </div>

                            <div>
                                <label for="result" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                    Résultat
                                </label>
                                <select name="result" id="result" 
                                        class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                    <option value="Non effectué" {{ $medicalVisit->result == 'Non effectué' ? 'selected' : '' }}>Non effectué</option>
                                    <option value="Apte" {{ $medicalVisit->result == 'Apte' ? 'selected' : '' }}>Apte</option>
                                    <option value="Inapte" {{ $medicalVisit->result == 'Inapte' ? 'selected' : '' }}>Inapte</option>
                                </select>
                            </div>
                        </div>

                        @if(in_array('admin', user_roles()))
                        <div>
                            <label for="certificate" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                Certificat médical
                                @if($medicalVisit->certificate_path)
                                    <span class="tw-text-green-600">(Déjà téléversé)</span>
                                @endif
                            </label>
                            <input type="file" name="certificate" id="certificate" accept=".pdf,.jpg,.jpeg,.png"
                                   class="tw-mt-1 tw-block tw-w-full tw-text-sm tw-text-gray-500 
                                          file:tw-mr-4 file:tw-py-2 file:tw-px-4 
                                          file:tw-rounded-full file:tw-border-0 
                                          file:tw-text-sm file:tw-font-semibold 
                                          file:tw-bg-blue-50 file:tw-text-blue-700 
                                          hover:file:tw-bg-blue-100">
                            <p class="tw-mt-1 tw-text-xs tw-text-gray-500">PDF, JPG, PNG - Max 2MB</p>
                        </div>
                        @endif

                        <div>
                            <label for="notes" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                Notes
                            </label>
                            <textarea name="notes" id="notes" rows="2"
                                      class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">{{ $medicalVisit->notes }}</textarea>
                        </div>
                    </div>

                    <div class="tw-flex tw-justify-end tw-space-x-3 tw-mt-6">
                        <a href="{{ route('medical-visits.show', $medicalVisit) }}" 
                           class="tw-bg-white tw-py-2 tw-px-4 tw-border tw-border-gray-300 tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 tw-hover:bg-gray-50">
                            Annuler
                        </a>
                        <button type="submit"
                                class="tw-bg-blue-600 tw-py-2 tw-px-4 tw-border tw-border-transparent tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-white tw-hover:bg-blue-700">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection