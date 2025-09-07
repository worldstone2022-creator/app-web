@extends('layouts.app')

@section('content')
<div class="tw-container tw-mx-auto tw-px-4 tw-py-6">
    <div class="tw-max-w-2xl tw-mx-auto">
        <div class="tw-bg-white tw-shadow tw-sm:rounded-lg">
            <div class="tw-px-4 tw-py-5 tw-sm:p-6">
                <h3 class="tw-text-lg tw-leading-6 tw-font-medium tw-text-gray-900 tw-mb-6">
                    Programmer une visite médicale
                </h3>

                <form method="POST" action="{{ route('medical-visits.store') }}">
                    @csrf
                    
                    <div class="tw-grid tw-grid-cols-1 tw-gap-6">
                        <div>
                            <label for="user_id" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                Utilisateur
                            </label>
                            <select name="user_id" id="user_id" 
                                    class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                <option value="">Sélectionner un utilisateur</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} | {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="visit_type" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                Type de visite
                            </label>
                            <select name="visit_type" id="visit_type" 
                                    class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                <option value="">Sélectionner un type</option>
                                <option value="Embauche">Embauche</option>
                                <option value="Périodique">Périodique</option>
                                <option value="Reprise de services">Reprise de services</option>
                            </select>
                            @error('visit_type')
                                <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="visit_object" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                Objet de la visite
                            </label>
                            <textarea name="visit_object" id="visit_object" rows="3"
                                      class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">{{ old('visit_object') }}</textarea>
                            @error('visit_object')
                                <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="tw-grid tw-grid-cols-2 tw-gap-4">
                            <div>
                                <label for="doctor_name" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                    Médecin traitant
                                </label>
                                <input type="text" name="doctor_name" id="doctor_name" value="{{ old('doctor_name') }}"
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                @error('doctor_name')
                                    <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="scheduled_date" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                    Date programmée
                                </label>
                                <input type="date" name="scheduled_date" id="scheduled_date" value="{{ old('scheduled_date') }}"
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 ">
                                @error('scheduled_date')
                                    <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="notes" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                Notes
                            </label>
                            <textarea name="notes" id="notes" rows="2"
                                      class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="tw-flex tw-justify-end tw-space-x-3 tw-mt-6">
                        <a href="{{ route('medical-visits.index') }}" 
                           class="tw-bg-white tw-py-2 tw-px-4 tw-border tw-border-gray-300 tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 tw-hover:bg-gray-50">
                            Annuler
                        </a>
                        <button type="submit"
                                class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                            Programmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection