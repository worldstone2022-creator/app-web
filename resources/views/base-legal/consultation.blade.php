@extends('layouts.app')

@section('content')
<div class="tw-space-y-6 tw-p-4">
    <!-- Bannière d'accueil -->
    <div class="tw-bg-gradient-to-r tw-from-[#838383] tw-to-orange-600 tw-rounded-lg tw-shadow-xl">
        <div class="tw-p-4">
            <div class="tw-max-w-3xl">
                <h2 class=" tw-text-base tw-md:tw-text-xl tw-font-bold tw-text-white">
                    Consultez la base documentaire
                </h2>
                <p class="tw-text-sm tw-mt-2 tw-md:tw-text-base tw-text-gray-100">
                    Accédez à l'ensemble des textes législatifs, réglementaires et conventionnels applicables, 
                    classés par thématique et par source.
                </p>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="tw-bg-white tw-shadow tw-rounded-lg">
        <div class="tw-px-4 tw-py-5 sm:tw-p-6">
            <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900 tw-mb-4">Rechercher dans la base</h3>
            <form method="GET" action="{{ route('baselegal_consultation') }}" class="tw-space-y-4">
                <div class="tw-grid tw-grid-cols-1 tw-gap-4 sm:tw-grid-cols-2 lg:tw-grid-cols-4">
                    <!-- Recherche texte -->
                    <div class="lg:tw-col-span-2">
                        <label for="search" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Recherche</label>
                        <div class="tw-mt-1 tw-relative tw-rounded-md tw-shadow-sm">
                            <div class="tw-absolute tw-inset-y-0 tw-left-0 tw-pl-3 tw-flex tw-items-center tw-pointer-events-none">
                                <svg class="tw-h-5 tw-w-5 tw-text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                   placeholder="Titre, description..."
                                   class="focus:tw-ring-[#838383] focus:tw-border-[#838383] tw-block tw-w-full tw-pl-10 sm:tw-text-sm tw-border-gray-300 tw-rounded-md tw-border tw-p-3 tw-py-3">
                        </div>
                    </div>

                    <!-- Thématique -->
                    <div>
                        <label for="thematique" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Thématique</label>
                        <select name="thematique" id="thematique" 
                                class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                            <option value="">Toutes les thématiques</option>
                            @foreach($thematiques as $thematique)
                                <option value="{{ $thematique->slug }}" 
                                    {{ request('thematique') == $thematique->slug ? 'selected' : '' }}>
                                    {{ $thematique->nom }} ({{ $thematique->documents_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type de source -->
                    <div>
                        <label for="source_type" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Type de source</label>
                        <select name="source_type" id="source_type" 
                                class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                            <option value="">Tous les types</option>
                            @foreach($sourceTypes as $sourceType)
                                <option value="{{ $sourceType->type }}" {{ request('source_type') == $sourceType->type ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $sourceType->type)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="tw-flex tw-items-center tw-space-x-3">
                    <button type="submit" 
                            class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-[#838383] hover:tw-bg-[#838383] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-[#838383]">
                        <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Rechercher
                    </button>
                    <a href="{{ route('baselegal_consultation') }}" 
                       class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-[#838383]">
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Résultats de la recherche -->
    <div class="tw-bg-white tw-shadow tw-rounded-lg">
        <div class="tw-px-4 tw-py-5 sm:tw-px-6 tw-border-b tw-border-gray-200">
            <h3 class="tw-text-lg tw-leading-6 tw-font-medium tw-text-gray-900">
                Résultats de la recherche
                <span class="tw-text-sm tw-font-normal tw-text-gray-500">
                    ({{ $documents->total() }} document(s) trouvé(s))
                </span>
            </h3>
        </div>
        
        @if($documents->count() > 0)
            <ul role="list" class="tw-divide-y tw-divide-gray-200">
                @foreach($documents as $document)
                    <li class="tw-px-4 tw-py-4 sm:tw-px-6 hover:tw-bg-gray-50">
                        <div class="tw-flex tw-items-start tw-justify-between">
                            <div class="tw-flex-1 tw-min-w-0">
                                <!-- Titre et statut -->
                                <div class="tw-flex tw-items-center tw-mb-2">
                                    <h4 class="tw-text-lg tw-font-medium tw-text-[#838383] tw-truncate">
                                        <!-- { route('base-legal.documents.show', $document) }} -->
                                        <a href="" 
                                           class="hover:tw-text-gray-800">
                                            {{ $document->titre }}
                                        </a>
                                    </h4>
                                    @if($document->fichier_pdf)
                                        <svg class="tw-ml-2 tw-h-5 tw-w-5 tw-text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>

                                <!-- Description -->
                                @if($document->description)
                                    <p class="tw-text-sm tw-text-gray-600 tw-mb-2 tw-line-clamp-2">
                                        {{ $document->description }}
                                    </p>
                                @endif

                                <!-- Métadonnées -->
                                <div class="tw-flex tw-items-center tw-text-sm tw-text-gray-500 tw-space-x-4">
                                    <!-- Source -->
                                    <div class="tw-flex tw-items-center">
                                        <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-blue-100 tw-text-blue-800">
                                            {{ ucfirst(str_replace('_', ' ', $document->source->type)) }}
                                        </span>
                                        <span class="tw-ml-2">{{ $document->source->nom }}</span>
                                    </div>

                                    <!-- Date de publication -->
                                    @if($document->date_publication)
                                        <div class="tw-flex tw-items-center">
                                            <svg class="tw-h-4 tw-w-4 tw-mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $document->date_publication->format('d/m/Y') }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Thématiques -->
                                <div class="tw-mt-2 tw-flex tw-flex-wrap tw-gap-1">
                                    @foreach($document->thematiques as $thematique)
                                        <a href="{{ route('baselegal_consultation', ['thematique' => $thematique->slug]) }}" 
                                           class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-gray-100 tw-text-gray-800 hover:tw-bg-gray-200">
                                            {{ $thematique->nom }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="tw-flex-shrink-0 tw-ml-4 tw-flex tw-space-x-2">
                                @if($document->fichier_url)
                                    <a href="{{ $document->fichier_url }}" target="_blank"
                                       class="tw-inline-flex tw-items-center tw-p-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500 hover:tw-bg-gray-50"
                                       title="Consulter le document">
                                        <svg class="tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                @endif
                                <a href="{{ route('base_documentaire_documents_show', $document) }}"
                                   class="tw-inline-flex tw-items-center tw-p-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500 hover:tw-bg-gray-50"
                                   title="Voir les détails">
                                    <svg class="tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <!-- Pagination -->
            @if($documents->hasPages())
                <div class="tw-bg-white tw-px-4 tw-py-3 tw-flex tw-items-center tw-justify-between tw-border-t tw-border-gray-200 sm:tw-px-6">
                    <div class="tw-flex-1 tw-flex tw-justify-between sm:tw-hidden">
                        @if($documents->previousPageUrl())
                            <a href="{{ $documents->appends(request()->query())->previousPageUrl() }}" 
                               class="tw-relative tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50">
                                Précédent
                            </a>
                        @endif
                        @if($documents->nextPageUrl())
                            <a href="{{ $documents->appends(request()->query())->nextPageUrl() }}" 
                               class="tw-ml-3 tw-relative tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50">
                                Suivant
                            </a>
                        @endif
                    </div>
                    <div class="tw-hidden sm:tw-flex-1 sm:tw-flex sm:tw-items-center sm:tw-justify-between">
                        <div>
                            <p class="tw-text-sm tw-text-gray-700">
                                Affichage de 
                                <span class="tw-font-medium">{{ $documents->firstItem() }}</span>
                                à 
                                <span class="tw-font-medium">{{ $documents->lastItem() }}</span>
                                sur 
                                <span class="tw-font-medium">{{ $documents->total() }}</span>
                                résultats
                            </p>
                        </div>
                        <div>
                            {{ $documents->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @endif
        @else
            <!-- Aucun résultat -->
            <div class="tw-text-center tw-py-12">
                <svg class="tw-mx-auto tw-h-12 tw-w-12 tw-text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="tw-mt-2 tw-text-sm tw-font-medium tw-text-gray-900">Aucun document trouvé</h3>
                <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                    Aucun document ne correspond à vos critères de recherche.
                </p>
                <div class="tw-mt-6">
                    <a href="{{ route('baselegal_consultation') }}" 
                       class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-shadow-sm tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-[#838383] hover:tw-bg-[#838383]">
                        Voir tous les documents
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Thématiques populaires -->
    @if($thematiques->count() > 0)
        <div class="tw-bg-white tw-shadow tw-rounded-lg">
            <div class="tw-px-4 tw-py-5 sm:tw-px-6">
                <h3 class="tw-text-lg tw-leading-6 tw-font-medium tw-text-gray-900 tw-mb-4">
                    Explorer par thématique
                </h3>
                <div class="tw-grid tw-grid-cols-1 tw-gap-4 sm:tw-grid-cols-2 lg:tw-grid-cols-3">
                    @foreach($thematiques->sortByDesc('documents_count')->take(6) as $thematique)
                        <a href="{{ route('baselegal_consultation', ['thematique' => $thematique->slug]) }}" 
                           class="tw-relative tw-rounded-lg tw-border tw-border-gray-300 tw-bg-white tw-px-6 tw-py-5 hover:tw-bg-gray-50 tw-transition-colors">
                            <div class="tw-flex tw-items-center tw-justify-between">
                                <div class="tw-flex-1 tw-min-w-0">
                                    <h4 class="tw-text-sm tw-font-medium tw-text-gray-900 tw-truncate">
                                        {{ $thematique->nom }}
                                    </h4>
                                    @if($thematique->description)
                                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500 tw-truncate">
                                            {{ $thematique->description }}
                                        </p>
                                    @endif
                                </div>
                                <div class="tw-flex-shrink-0">
                                    <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-gray-100 tw-text-gray-800">
                                        {{ $thematique->documents_count }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection