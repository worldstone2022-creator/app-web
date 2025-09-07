{{-- resources/views/hr/job-offers/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="tw-min-h-screen tw-bg-gray-50 tw-py-8">
    <div class="tw-max-w-4xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
        {{-- En-tête --}}
         <div class="tw-mb-5">
            <a href="{{ route('hr.dashboard') }}" 
                   class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                    <i class="fas fa-arrow-left tw-mr-2"></i>
                    Tableau de bord récrutement 
                </a>
         </div>


        <div class="tw-mb-8">
            <div class="tw-flex tw-items-center tw-justify-between">
                <div>
                    <h1 class="tw-text-3xl tw-font-bold tw-text-gray-900">Créer une Offre d'Emploi</h1>
                    <p class="tw-mt-2 tw-text-gray-600">Remplissez les informations pour votre nouvelle offre</p>
                </div>
                <a href="{{ route('job-offers.index') }}" 
                   class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                    <i class="fas fa-arrow-left tw-mr-2"></i>
                    Retour
                </a>
            </div>
        </div>

        {{-- Formulaire --}}
        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
            <form method="POST" action="{{ route('job-offers.store') }}" class="tw-space-y-6">
                @csrf
                
                <div class="tw-px-6 tw-py-6">
                    {{-- Informations générales --}}
                    <div class="tw-mb-8">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-6 tw-border-b tw-border-orange-200 tw-pb-2">
                            Informations Générales
                        </h2>
                        
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-6">
                            {{-- Titre --}}
                            <div class="md:tw-col-span-2">
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Titre du poste *
                                </label>
                                <input type="text" name="title" value="{{ old('title') }}" required
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('title') tw-border-red-500 @enderror"
                                       placeholder="Ex: Développeur Full Stack Senior">
                                @error('title')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Département --}}
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Département *
                                </label>
                                <input type="text" name="department" value="{{ old('department') }}" required
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('department') tw-border-red-500 @enderror"
                                       placeholder="Ex: Développement">
                                @error('department')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Type --}}
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Type de contrat *
                                </label>
                                <select name="type" required 
                                        class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('type') tw-border-red-500 @enderror">
                                    <option value="">Sélectionner un type</option>
                                    <option value="CDI" {{ old('type') == 'CDI' ? 'selected' : '' }}>CDI</option>
                                    <option value="CDD" {{ old('type') == 'CDD' ? 'selected' : '' }}>CDD</option>
                                    <option value="Stage" {{ old('type') == 'Stage' ? 'selected' : '' }}>Stage</option>
                                    <option value="Freelance" {{ old('type') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                    <option value="Alternance" {{ old('type') == 'Alternance' ? 'selected' : '' }}>Alternance</option>
                                </select>
                                @error('type')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Lieu --}}
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Lieu de travail *
                                </label>
                                <input type="text" name="location" value="{{ old('location') }}" required
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('location') tw-border-red-500 @enderror"
                                       placeholder="Ex: Paris, Télétravail, Hybrid">
                                @error('location')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Salaire --}}
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Fourchette salariale
                                </label>
                                <input type="text" name="salary_range" value="{{ old('salary_range') }}"
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('salary_range') tw-border-red-500 @enderror"
                                       placeholder="Ex: 45k - 60k €/an">
                                @error('salary_range')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="tw-mb-8">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-6 tw-border-b tw-border-orange-200 tw-pb-2">
                            Description du Poste
                        </h2>
                        
                        <div class="tw-space-y-6">
                            {{-- Description --}}
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Description *
                                </label>
                                <textarea name="description" rows="6" required
                                          class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('description') tw-border-red-500 @enderror"
                                          placeholder="Décrivez le poste, les missions principales, l'environnement de travail...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Exigences --}}
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Exigences et Compétences
                                </label>
                                <textarea name="requirements" rows="4"
                                          class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('requirements') tw-border-red-500 @enderror"
                                          placeholder="Listez les compétences requises, l'expérience nécessaire...">{{ old('requirements') }}</textarea>
                                @error('requirements')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Avantages --}}
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Avantages
                                </label>
                                <textarea name="benefits" rows="3"
                                          class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('benefits') tw-border-red-500 @enderror"
                                          placeholder="Tickets restaurant, télétravail, formation, mutuelle...">{{ old('benefits') }}</textarea>
                                @error('benefits')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Paramètres --}}
                    <div class="tw-mb-8">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-6 tw-border-b tw-border-orange-200 tw-pb-2">
                            Paramètres de l'Offre
                        </h2>
                        
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-6">
                            {{-- Date limite --}}
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Date limite de candidature *
                                </label>
                                <input type="date" name="deadline" value="{{ old('deadline') }}" required
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('deadline') tw-border-red-500 @enderror">
                                @error('deadline')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Postes disponibles --}}
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Nombre de postes disponibles *
                                </label>
                                <input type="number" name="positions_available" value="{{ old('positions_available', 1) }}" 
                                       min="1" required
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('positions_available') tw-border-red-500 @enderror">
                                @error('positions_available')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Boutons d'action --}}
                <div class="tw-bg-gray-50 tw-px-6 tw-py-4 tw-border-t tw-border-gray-200">
                    <div class="tw-flex tw-items-center tw-justify-end tw-space-x-4">
                        <p class="tw-text-sm tw-text-gray-500 tw-mr-auto">
                            * Champs obligatoires
                        </p>
                        <a href="{{ route('job-offers.index') }}" 
                           class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-6 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-8 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 tw-shadow-sm hover:tw-shadow-md">
                            <i class="fas fa-save tw-mr-2"></i>
                            Créer l'Offre
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Note informative --}}
        <div class="tw-mt-6 tw-bg-orange-50 tw-border tw-border-orange-200 tw-rounded-lg tw-p-4">
            <div class="tw-flex">
                <i class="fas fa-info-circle tw-text-orange-400 tw-flex-shrink-0 tw-mt-0.5"></i>
                <div class="tw-ml-3">
                    <h3 class="tw-text-sm tw-font-medium tw-text-orange-800">Information</h3>
                    <p class="tw-mt-1 tw-text-sm tw-text-orange-700">
                        L'offre sera créée en mode brouillon. Vous pourrez la publier après révision depuis la liste des offres.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection