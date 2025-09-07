@extends('layouts.app')

@section('content')
    <div class="tw-p-4">
        <ul class="tw-flex tw-items-center tw-space-x-4 tw-pb-4">
            <li>
                <div class="tw-flex tw-items-center">
                    <svg class="tw-h-5 tw-w-5 tw-flex-shrink-0 tw-text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <a href="{{ route('base-legal.sources.index') }}"
                        class="tw-ml-4 tw-text-sm tw-font-medium tw-text-gray-500 hover:tw-text-gray-700">Sources</a>
                </div>
            </li>
            <li>
                <div class="tw-flex tw-items-center">
                    <svg class="tw-h-5 tw-w-5 tw-flex-shrink-0 tw-text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <a href="{{ route('base-legal.sources.show', $source) }}"
                        class="tw-ml-4 tw-text-sm tw-font-medium tw-text-gray-500 hover:tw-text-gray-700">{{ Str::limit($source->nom, 30) }}</a>
                </div>
            </li>
            <li>
                <div class="tw-flex tw-items-center">
                    <svg class="tw-h-5 tw-w-5 tw-flex-shrink-0 tw-text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="tw-ml-4 tw-text-sm tw-font-medium tw-text-gray-500">Modifier</span>
                </div>
            </li>
        </ul>
         <form action="{{ route('base-legal.sources.update', $source) }}" method="POST" class="tw-space-y-6">
    @csrf
    @method('PUT')
    
    <!-- Informations actuelles -->
    <div class="tw-bg-blue-50 tw-border tw-border-blue-200 tw-rounded-lg tw-p-4">
        <div class="tw-flex">
            <div class="tw-flex-shrink-0">
                <svg class="tw-h-5 tw-w-5 tw-text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="tw-ml-3">
                <h3 class="tw-text-sm tw-font-medium tw-text-blue-800">
                    Informations actuelles de la source
                </h3>
                <div class="tw-mt-2 tw-text-sm tw-text-blue-700">
                    <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 tw-gap-4">
                        <div>
                            <ul class="tw-list-disc tw-list-inside tw-space-y-1">
                                <li><strong>Type actuel :</strong> {{ $source->type_libelle }}</li>
                                <li><strong>Nom actuel :</strong> {{ $source->nom }}</li>
                                <li><strong>Documents associés :</strong> {{ $source->documents->count() }} document(s)</li>
                            </ul>
                        </div>
                        <div>
                            <ul class="tw-list-disc tw-list-inside tw-space-y-1">
                                <li><strong>Créé le :</strong> {{ $source->created_at->format('d/m/Y à H:i') }}</li>
                                <li><strong>Modifié le :</strong> {{ $source->updated_at->format('d/m/Y à H:i') }}</li>
                                <li><strong>ID :</strong> #{{ $source->id }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Formulaire de modification -->
    <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
        <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
            <div class="md:tw-col-span-1">
                <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Modifier la source</h3>
                <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                    Modifiez les informations de cette source juridique. Les modifications affecteront tous les documents associés.
                </p>
                
                <!-- Avertissement si documents associés -->
                @if($source->documents->count() > 0)
                    <div class="tw-mt-4 tw-p-3 tw-bg-yellow-50 tw-border tw-border-yellow-200 tw-rounded-md">
                        <div class="tw-flex">
                            <div class="tw-flex-shrink-0">
                                <svg class="tw-h-5 tw-w-5 tw-text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="tw-ml-3">
                                <h3 class="tw-text-sm tw-font-medium tw-text-yellow-800">
                                    Impact sur les documents
                                </h3>
                                <div class="tw-mt-2 tw-text-sm tw-text-yellow-700">
                                    <p>Cette source est associée à {{ $source->documents->count() }} document(s). Les modifications seront visibles sur tous ces documents.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                <div class="tw-grid tw-grid-cols-6 tw-gap-6">
                    <!-- Type de source -->
                    <div class="tw-col-span-6">
                        <label for="type" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                            Type de source *
                        </label>
                        <select id="type" name="type" required onchange="updateTypeInfo()"
                                class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                            @foreach($types as $key => $label)
                                <option value="{{ $key }}" {{ old('type', $source->type) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <!-- Information sur le type sélectionné -->
                        <div id="type-info" class="tw-mt-3">
                            <div class="tw-bg-gray-50 tw-border tw-border-gray-200 tw-rounded-md tw-p-3">
                                <div class="tw-flex tw-items-start">
                                    <div class="tw-flex-shrink-0">
                                        <svg id="type-icon" class="tw-h-5 tw-w-5 tw-text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="tw-ml-3 tw-flex-1">
                                        <h4 id="type-title" class="tw-text-sm tw-font-medium tw-text-gray-900"></h4>
                                        <p id="type-description" class="tw-mt-1 tw-text-sm tw-text-gray-600"></p>
                                        <p id="type-examples" class="tw-mt-2 tw-text-xs tw-text-gray-500"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Changement de type -->
                        @if($source->documents->count() > 0)
                            <div class="tw-mt-2 tw-text-sm tw-text-orange-600">
                                <svg class="tw-inline tw-h-4 tw-w-4 tw-mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Attention : Changer le type affectera la classification de {{ $source->documents->count() }} document(s)
                            </div>
                        @endif
                    </div>

                    <!-- Nom de la source -->
                    <div class="tw-col-span-6">
                        <label for="nom" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                            Nom de la source *
                        </label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $source->nom) }}" required
                               class="tw-mt-1 focus:tw-ring-gray-500 focus:tw-border-gray-500 tw-block tw-w-full tw-shadow-sm sm:tw-text-sm tw-border-gray-300 tw-rounded-md tw-border tw-px-3 tw-py-2 ">
                        @error('nom')
                            <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <!-- Suggestions pour améliorer le nom -->
                        <div id="suggestions" class="tw-mt-2 tw-hidden">
                            <p class="tw-text-sm tw-text-gray-600 tw-mb-2">Suggestions pour améliorer le nom :</p>
                            <div id="suggestions-list" class="tw-flex tw-flex-wrap tw-gap-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents associés (lecture seule) -->
    @if($source->documents->count() > 0)
        <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
            <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
                <div class="md:tw-col-span-1">
                    <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Documents associés</h3>
                    <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                        Liste des documents actuellement associés à cette source.
                    </p>
                </div>
                <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                    <div class="tw-border tw-border-gray-200 tw-rounded-md tw-divide-y tw-divide-gray-200">
                        @foreach($source->documents->take(5) as $document)
                            <div class="tw-p-3">
                                <div class="tw-flex tw-items-center tw-justify-between">
                                    <div class="tw-flex-1 tw-min-w-0">
                                        <p class="tw-text-sm tw-font-medium tw-text-gray-900 tw-truncate">
                                            {{ $document->titre }}
                                        </p>
                                        <div class="tw-mt-1 tw-flex tw-flex-wrap tw-gap-1">
                                            @foreach($document->thematiques->take(3) as $thematique)
                                                <span class="tw-inline-flex tw-items-center tw-px-2 tw-py-0.5 tw-rounded tw-text-xs tw-font-medium tw-bg-gray-100 tw-text-gray-800">
                                                    {{ $thematique->nom }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tw-flex-shrink-0 tw-flex tw-space-x-2">
                                        @if(!$document->actif)
                                            <span class="tw-inline-flex tw-items-center tw-px-2 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-red-100 tw-text-red-800">
                                                Inactif
                                            </span>
                                        @endif
                                        <a href="{{ route('base_documentaire_documents_show', $document) }}" 
                                           class="tw-text-gray-600 hover:tw-text-gray-500 tw-text-sm">
                                            Voir
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @if($source->documents->count() > 5)
                            <div class="tw-p-3 tw-bg-gray-50">
                                <p class="tw-text-sm tw-text-gray-500 tw-text-center">
                                    ... et {{ $source->documents->count() - 5 }} autre(s) document(s)
                                </p>
                                <div class="tw-text-center tw-mt-2">
                                    <a href="{{ route('base-legal.sources.show', $source) }}" 
                                       class="tw-text-sm tw-font-medium tw-text-gray-600 hover:tw-text-gray-500">
                                        Voir tous les documents
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Autres sources du même type -->
    <div id="other-sources" class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
        <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
            <div class="md:tw-col-span-1">
                <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Autres sources similaires</h3>
                <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                    Autres sources du même type dans votre base.
                </p>
            </div>
            <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                <div id="other-sources-list" class="tw-space-y-2">
                    <!-- Liste générée dynamiquement -->
                </div>
            </div>
        </div>
    </div>

    <!-- Aperçu des modifications -->
    <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
        <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
            <div class="md:tw-col-span-1">
                <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Aperçu des modifications</h3>
                <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                    Voici comment apparaîtra votre source après modification.
                </p>
            </div>
            <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                <div class="tw-border tw-border-gray-200 tw-rounded-lg tw-p-4 tw-bg-gray-50">
                    <div class="tw-flex tw-items-center tw-space-x-3">
                        <div class="tw-h-10 tw-w-10 tw-rounded-full tw-bg-gray-100 tw-flex tw-items-center tw-justify-center">
                            <svg id="preview-icon" class="tw-h-6 tw-w-6 tw-text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="tw-flex-1">
                            <div class="tw-flex tw-items-center tw-space-x-2 tw-mb-1">
                                <span id="preview-badge" class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-gray-100 tw-text-gray-800">
                                    {{ $source->type_libelle }}
                                </span>
                            </div>
                            <h4 id="preview-nom" class="tw-text-lg tw-font-medium tw-text-gray-900">{{ $source->nom }}</h4>
                            <p class="tw-text-xs tw-text-gray-400 tw-mt-1">{{ $source->documents->count() }} document(s) associé(s)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Métadonnées (lecture seule) -->
    <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
        <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
            <div class="md:tw-col-span-1">
                <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Métadonnées</h3>
                <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                    Informations sur cette source (lecture seule).
                </p>
            </div>
            <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                <dl class="tw-grid tw-grid-cols-1 tw-gap-x-4 tw-gap-y-4 sm:tw-grid-cols-2">
                    <div>
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">ID de la source</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">#{{ $source->id }}</dd>
                    </div>
                    <div>
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Type actuel</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">{{ $source->type_libelle }}</dd>
                    </div>
                    <div>
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Créé le</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">{{ $source->created_at->format('d/m/Y à H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Modifié le</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">{{ $source->updated_at->format('d/m/Y à H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Nombre de documents</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">
                            <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-green-100 tw-text-green-800">
                                {{ $source->documents->count() }} document(s)
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">URL de consultation</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">
                            <a href="{{ route('baselegal_consultation', ['source_type' => $source->type]) }}" 
                               target="_blank"
                               class="tw-text-gray-600 hover:tw-text-gray-500 tw-break-all">
                                /legal?source_type={{ $source->type }}
                                <svg class="tw-inline tw-h-3 tw-w-3 tw-ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="tw-flex tw-justify-between tw-items-center tw-space-x-3">
        <div class="tw-flex tw-space-x-3">
            <a href="{{ route('base-legal.sources.show', $source) }}" 
               class="tw-bg-white tw-py-2 tw-px-4 tw-border tw-border-gray-300 tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                <svg class="tw-inline tw-h-4 tw-w-4 tw-mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la source
            </a>
            <a href="{{ route('base-legal.sources.index') }}" 
               class="tw-bg-white tw-py-2 tw-px-4 tw-border tw-border-gray-300 tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                Liste des sources
            </a>
        </div>
        <div class="tw-flex tw-space-x-3">
            <button type="button" onclick="window.history.back()" 
                    class="tw-bg-white tw-py-2 tw-px-4 tw-border tw-border-gray-300 tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                Annuler
            </button>
            <button type="submit" 
                    class="tw-inline-flex tw-justify-center tw-py-2 tw-px-4 tw-border tw-border-transparent tw-shadow-sm tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-gray-600 hover:tw-bg-gray-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                <svg class="tw-h-4 tw-w-4 tw-mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Enregistrer les modifications
            </button>
        </div>
    </div>
</form>
    </div>

    @push('scripts')
<script>
    // Données des types de sources (même structure que create)
    const typesData = {
        'loi': {
            title: 'Loi',
            description: 'Textes votés par le Parlement français (Assemblée nationale et Sénat). Ils ont une portée générale et s\'imposent à tous.',
            examples: 'Exemples : Code du travail, Code civil, Code pénal, Loi sur les 35 heures',
            suggestions: ['Code du travail', 'Code de la sécurité sociale', 'Code civil', 'Code pénal', 'Code de commerce'],
            icon: 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z',
            color: 'tw-bg-red-100 tw-text-red-800'
        },
        'decret': {
            title: 'Décret',
            description: 'Textes pris par le Président de la République ou le Premier ministre pour appliquer les lois. Ils précisent les modalités d\'application.',
            examples: 'Exemples : Décrets d\'application du Code du travail, Décrets en Conseil d\'État',
            suggestions: ['Décret sur le temps de travail', 'Décret relatif aux congés payés', 'Décret sur la formation professionnelle', 'Décret CHSCT'],
            icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
            color: 'tw-bg-blue-100 tw-text-blue-800'
        },
        'convention_collective': {
            title: 'Convention collective',
            description: 'Accords négociés entre les représentants des employeurs et des salariés d\'une branche professionnelle. Elles complètent le Code du travail.',
            examples: 'Exemples : CCN du bâtiment, CCN de la métallurgie, CCN du commerce',
            suggestions: ['Convention collective nationale du bâtiment', 'Convention collective métallurgie', 'Convention collective commerce', 'Convention collective HCR', 'Convention collective transport'],
            icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
            color: 'tw-bg-green-100 tw-text-green-800'
        },
        'jurisprudence': {
            title: 'Jurisprudence',
            description: 'Décisions rendues par les tribunaux et cours de justice qui font autorité et servent de référence pour l\'interprétation du droit.',
            examples: 'Exemples : Arrêts de la Cour de cassation, du Conseil d\'État, des cours d\'appel',
            suggestions: ['Cour de cassation sociale', 'Cour de cassation criminelle', 'Conseil d\'État', 'Cour d\'appel de Paris', 'Tribunal des conflits'],
            icon: 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3',
            color: 'tw-bg-purple-100 tw-text-purple-800'
        },
        'arrete': {
            title: 'Arrêté',
            description: 'Décisions prises par les ministres, préfets ou maires dans leur domaine de compétence. Ils ont une portée plus limitée que les décrets.',
            examples: 'Exemples : Arrêtés ministériels, préfectoraux, municipaux',
            suggestions: ['Arrêté ministériel', 'Arrêté préfectoral', 'Arrêté municipal', 'Arrêté DGT', 'Arrêté DIRECCTE'],
            icon: 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z',
            color: 'tw-bg-yellow-100 tw-text-yellow-800'
        },
        'circulaire': {
            title: 'Circulaire',
            description: 'Instructions données par l\'administration pour préciser l\'application des textes. Elles n\'ont pas de valeur juridique contraignante.',
            examples: 'Exemples : Circulaires DGT, circulaires ministérielles, notes de service',
            suggestions: ['Circulaire DGT', 'Circulaire ministérielle', 'Note de service', 'Instruction DGEFP', 'Circulaire URSSAF'],
            icon: 'M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2',
            color: 'tw-bg-gray-100 tw-text-gray-800'
        }
    };

    // Sources existantes par type (version simplifiée)
    const allSources = {
        'loi': [],
        'decret': [],
        'convention_collective': [],
        'jurisprudence': [],
        'arrete': [],
        'circulaire': []
    };

    // Charger les autres sources via AJAX si nécessaire
    function loadOtherSources(type) {
        // En production, vous pouvez faire un appel AJAX ici
        // fetch(`/base-legal/api/sources-by-type/${type}`)
        //     .then(response => response.json())
        //     .then(data => allSources[type] = data);
    }

    // Mettre à jour les informations du type
    function updateTypeInfo() {
        const typeSelect = document.getElementById('type');
        const selectedType = typeSelect.value;
        
        if (selectedType && typesData[selectedType]) {
            const data = typesData[selectedType];
            
            // Mettre à jour les informations du type
            document.getElementById('type-title').textContent = data.title;
            document.getElementById('type-description').textContent = data.description;
            document.getElementById('type-examples').textContent = data.examples;
            document.getElementById('type-icon').innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${data.icon}" />`;

            // Mettre à jour l'aperçu
            updatePreview();

            // Afficher les suggestions pour améliorer le nom
            showSuggestions(data);

            // Afficher les autres sources du même type
            showOtherSources(selectedType);
        }
    }

    // Afficher les suggestions pour améliorer le nom
    function showSuggestions(data) {
        const currentName = document.getElementById('nom').value.toLowerCase();
        const suggestions = data.suggestions.filter(suggestion => 
            suggestion.toLowerCase() !== currentName && 
            !suggestion.toLowerCase().includes(currentName) &&
            !currentName.includes(suggestion.toLowerCase())
        );

        if (suggestions.length > 0) {
            const suggestionsList = document.getElementById('suggestions-list');
            suggestionsList.innerHTML = '';
            suggestions.slice(0, 3).forEach(suggestion => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'tw-inline-flex tw-items-center tw-px-3 tw-py-1 tw-rounded-full tw-text-xs tw-font-medium ' + data.color + ' hover:tw-opacity-80 tw-cursor-pointer tw-transition-opacity';
                button.textContent = suggestion;
                button.onclick = () => fillSuggestion(suggestion);
                suggestionsList.appendChild(button);
            });
            document.getElementById('suggestions').classList.remove('tw-hidden');
        } else {
            document.getElementById('suggestions').classList.add('tw-hidden');
        }
    }

    // Afficher les autres sources du même type
    function showOtherSources(selectedType) {
        const otherSourcesList = document.getElementById('other-sources-list');
        const sources = allSources[selectedType] || [];

        if (sources.length > 0) {
            otherSourcesList.innerHTML = '';
            sources.slice(0, 5).forEach(source => {
                const div = document.createElement('div');
                div.className = 'tw-flex tw-items-center tw-justify-between tw-p-2 tw-bg-gray-50 tw-border tw-border-gray-200 tw-rounded-md';
                div.innerHTML = `
                    <span class="tw-text-sm tw-text-gray-700">${source.nom}</span>
                    <span class="tw-text-xs tw-text-gray-500">${source.documents_count || 0} document(s)</span>
                `;
                otherSourcesList.appendChild(div);
            });

            if (sources.length > 5) {
                const moreDiv = document.createElement('div');
                moreDiv.className = 'tw-text-center tw-text-sm tw-text-gray-500';
                moreDiv.textContent = `... et ${sources.length - 5} autre(s) source(s)`;
                otherSourcesList.appendChild(moreDiv);
            }
        } else {
            otherSourcesList.innerHTML = '<p class="tw-text-sm tw-text-gray-500 tw-italic">Aucune autre source de ce type</p>';
        }
    }

    // Remplir le champ nom avec une suggestion
    function fillSuggestion(suggestion) {
        document.getElementById('nom').value = suggestion;
        updatePreview();
        updateTypeInfo(); // Pour mettre à jour les suggestions
    }

    // Mettre à jour l'aperçu
    function updatePreview() {
        const type = document.getElementById('type').value;
        const nom = document.getElementById('nom').value;

        if (type && typesData[type]) {
            const data = typesData[type];
            document.getElementById('preview-badge').textContent = data.title;
            document.getElementById('preview-badge').className = 'tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium ' + data.color;
            document.getElementById('preview-nom').textContent = nom || 'Nom de la source';
            document.getElementById('preview-icon').innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${data.icon}" />`;
        }
    }

    // Event listeners
    document.getElementById('nom').addEventListener('input', function() {
        updatePreview();
        updateTypeInfo(); // Pour mettre à jour les suggestions
    });

    // Validation côté client
    document.querySelector('form').addEventListener('submit', function(e) {
        const type = document.getElementById('type').value;
        const nom = document.getElementById('nom').value.trim();
        
        if (!type) {
            e.preventDefault();
            alert('Veuillez sélectionner un type de source.');
            return false;
        }
        
        if (nom.length < 3) {
            e.preventDefault();
            alert('Le nom de la source doit contenir au moins 3 caractères.');
            return false;
        }

        // Vérifier les doublons avec d'autres sources
        if (allSources[type]) {
            const exists = allSources[type].some(source => 
                source.nom.toLowerCase() === nom.toLowerCase()
            );
            if (exists) {
                const confirm = window.confirm('Une autre source avec ce nom existe déjà pour ce type. Voulez-vous continuer ?');
                if (!confirm) {
                    e.preventDefault();
                    return false;
                }
            }
        }

        // Confirmation si changement de type avec documents associés
        const originalType = '{{ $source->type }}';
        const documentsCount = {{ $source->documents->count() }};
        if (type !== originalType && documentsCount > 0) {
            const confirm = window.confirm(`Attention: Changer le type de source affectera la classification de ${documentsCount} document(s). Voulez-vous continuer ?`);
            if (!confirm) {
                e.preventDefault();
                return false;
            }
        }
    });

    // Initialiser au chargement
    document.addEventListener('DOMContentLoaded', function() {
        updateTypeInfo();
    });
</script>
@endpush
@endsection
