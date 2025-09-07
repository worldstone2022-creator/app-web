@extends('layouts.app')

@section('content')

<!-- { route('base_documentaire_documents_store') }} -->
<form action="{{ route('base_documentaire_documents_store') }}" method="POST" enctype="multipart/form-data" class="tw-space-y-6 tw-p-5">
    @csrf
    
    <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
        <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
            <div class="md:tw-col-span-1">
                <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Informations générales</h3>
                <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                    Informations de base du document juridique.
                </p>
            </div>
            <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                <div class="tw-grid tw-grid-cols-6 tw-gap-6">
                    <!-- Titre -->
                    <div class="tw-col-span-6">
                        <label for="titre" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Titre *</label>
                        <input type="text" name="titre" id="titre" value="{{ old('titre') }}" required
                               class="tw-mt-1 focus:tw-ring-gray-500 focus:tw-border-gray-500 tw-block tw-w-full tw-shadow-sm sm:tw-text-sm tw-border-gray-300 tw-rounded-md tw-border p-2">
                        @error('titre')
                            <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="tw-col-span-6">
                        <label for="description" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="3"
                                  class="tw-mt-1 focus:tw-ring-gray-500 focus:tw-border-gray-500 tw-block tw-w-full tw-shadow-sm sm:tw-text-sm tw-border-gray-300 tw-rounded-md tw-border tw-px-3 tw-py-2">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Source -->
                    <div class="tw-col-span-6 sm:tw-col-span-3">
                        <label for="source_id" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Source *</label>
                        <select id="source_id" name="source_id" required
                                class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                            <option value="">Sélectionner une source</option>
                            @foreach($sources as $source)
                                <option value="{{ $source->id }}" {{ old('source_id') == $source->id ? 'selected' : '' }}>
                                    {{ $source->type_libelle }} - {{ $source->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('source_id')
                            <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date de publication -->
                    <div class="tw-col-span-6 sm:tw-col-span-3">
                        <label for="date_publication" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Date de publication</label>
                        <input type="date" name="date_publication" id="date_publication" value="{{ old('date_publication') }}"
                               class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                        @error('date_publication')
                            <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
        <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
            <div class="md:tw-col-span-1">
                <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Fichier et liens</h3>
                <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                    Ajoutez le document PDF ou un lien externe.
                </p>
            </div>
            <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                <div class="tw-grid tw-grid-cols-6 tw-gap-6">
                    <!-- Fichier PDF -->
                    <div class="tw-col-span-6">
                        <label for="fichier_pdf" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Fichier PDF</label>
                        <input type="file" name="fichier_pdf" id="fichier_pdf" accept=".pdf"
                               class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                        <p class="tw-mt-2 tw-text-sm tw-text-gray-500">Fichier PDF maximum 10MB</p>
                        @error('fichier_pdf')
                            <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- URL externe -->
                    <div class="tw-col-span-6">
                        <label for="url_externe" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Ou URL externe</label>
                        <input type="url" name="url_externe" id="url_externe" value="{{ old('url_externe') }}"
                               placeholder="https://..."
                               class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                        @error('url_externe')
                            <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
        <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
            <div class="md:tw-col-span-1">
                <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Classification</h3>
                <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                    Associez le document à une ou plusieurs thématiques.
                </p>
            </div>
            <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                <!-- Thématiques -->
                <fieldset>
                    <legend class="tw-text-sm tw-font-medium tw-text-gray-700">Thématiques *</legend>
                    <div class="tw-mt-4  tw-grid md:tw-grid-cols-2">
                        @foreach($thematiques as $thematique)
                            <div class="tw-flex tw-items-center">
                                <input id="thematique_{{ $thematique->id }}" name="thematiques[]" type="checkbox" 
                                       value="{{ $thematique->id }}"
                                       {{ in_array($thematique->id, old('thematiques', [])) ? 'checked' : '' }}
                                       class="focus:tw-ring-gray-500 tw-h-4 tw-w-4 tw-text-gray-600 tw-border-gray-300 tw-rounded">
                                <label for="thematique_{{ $thematique->id }}" class="tw-ml-3 tw-text-sm tw-font-medium tw-text-gray-700">
                                    {{ $thematique->nom }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('thematiques')
                        <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                    @enderror
                </fieldset>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="tw-flex tw-justify-end tw-space-x-3">
        <!-- { route('base_documentaire_documents_index') }} -->
        <a href="" 
           class="tw-bg-white tw-py-2 tw-px-4 tw-border tw-border-gray-300 tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
            Annuler
        </a>
        <button type="submit" 
                class="tw-inline-flex tw-justify-center tw-py-2 tw-px-4 tw-border tw-border-transparent tw-shadow-sm tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-gray-600 hover:tw-bg-gray-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
            Créer le document
        </button>
    </div>
</form>
@endsection