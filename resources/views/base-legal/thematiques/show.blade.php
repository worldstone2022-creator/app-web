@extends('layouts.app')

@section('content')
  <div class="tw-p-4">
      <ul class="tw-flex tw-items-center tw-space-x-4 tw-text-sm tw-font-medium ">
        <li>
            <div class="tw-flex tw-items-center">
                <svg class="tw-h-5 tw-w-5 tw-flex-shrink-0 tw-text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
                <a href="{{ route('base-legal.thematiques.index') }}"
                    class="tw-ml-4 tw-text-sm tw-font-medium tw-text-gray-500 hover:tw-text-gray-700">Thématiques</a>
            </div>
        </li>
        <li>
            <div class="tw-flex tw-items-center">
                <svg class="tw-h-5 tw-w-5 tw-flex-shrink-0 tw-text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
                <span class="tw-ml-4 tw-text-sm tw-font-medium tw-text-gray-500 tw-truncate">{{ $thematique->nom }}</span>
            </div>
        </li>
    </ul>

     <div class="tw-flex tw-space-x-3 tw-pt-4">
    <a href="{{ route('base-legal.thematiques.edit', $thematique) }}" 
       class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
        <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
        Modifier
    </a>
    <a href="{{ route('base_documentaire_documents_create_form') }}?thematique={{ $thematique->id }}" 
       class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-gray-600 hover:tw-bg-gray-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
        <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Nouveau document
    </a>
  </div>
   <div class="tw-space-y-6 tw-py-4">
    <!-- Informations de la thématique -->
    <div class="tw-bg-white tw-shadow tw-overflow-hidden sm:tw-rounded-lg">
        <div class="tw-px-4 tw-py-5 sm:tw-px-6">
            <div class="tw-flex tw-items-center">
                <svg class="tw-h-8 tw-w-8 tw-text-gray-600 tw-mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <div>
                    <h1 class="tw-text-2xl tw-font-bold tw-text-gray-900">{{ $thematique->nom }}</h1>
                    @if($thematique->description)
                        <p class="tw-mt-1 tw-max-w-2xl tw-text-sm tw-text-gray-500">{{ $thematique->description }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="tw-border-t tw-border-gray-200 tw-px-4 tw-py-5 sm:tw-p-0">
            <dl class="sm:tw-divide-y sm:tw-divide-gray-200">
                <div class="tw-py-4 sm:tw-py-5 sm:tw-grid sm:tw-grid-cols-3 sm:tw-gap-4 sm:tw-px-6">
                    <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Nom de la thématique</dt>
                    <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 sm:tw-mt-0 sm:tw-col-span-2">{{ $thematique->nom }}</dd>
                </div>

                <div class="tw-py-4 sm:tw-py-5 sm:tw-grid sm:tw-grid-cols-3 sm:tw-gap-4 sm:tw-px-6">
                    <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Slug</dt>
                    <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 sm:tw-mt-0 sm:tw-col-span-2">
                        <code class="tw-bg-gray-100 tw-px-2 tw-py-1 tw-rounded tw-text-xs">{{ $thematique->slug }}</code>
                    </dd>
                </div>

                @if($thematique->description)
                    <div class="tw-py-4 sm:tw-py-5 sm:tw-grid sm:tw-grid-cols-3 sm:tw-gap-4 sm:tw-px-6">
                        <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Description</dt>
                        <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 sm:tw-mt-0 sm:tw-col-span-2">
                            <div class="tw-prose tw-prose-sm tw-max-w-none">{{ $thematique->description }}</div>
                        </dd>
                    </div>
                @endif

                <div class="tw-py-4 sm:tw-py-5 sm:tw-grid sm:tw-grid-cols-3 sm:tw-gap-4 sm:tw-px-6">
                    <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Nombre de documents</dt>
                    <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 sm:tw-mt-0 sm:tw-col-span-2">
                        <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-green-100 tw-text-green-800">
                            {{ isset($documents) ? $documents->total() : $thematique->documents->count() }} document(s)
                        </span>
                    </dd>
                </div>

                <div class="tw-py-4 sm:tw-py-5 sm:tw-grid sm:tw-grid-cols-3 sm:tw-gap-4 sm:tw-px-6">
                    <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Dates</dt>
                    <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 sm:tw-mt-0 sm:tw-col-span-2">
                        <div class="tw-space-y-1">
                            <div>Créé le : {{ $thematique->created_at->format('d/m/Y à H:i') }}</div>
                            <div>Modifié le : {{ $thematique->updated_at->format('d/m/Y à H:i') }}</div>
                        </div>
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Filtres pour les documents -->
    @if(isset($documents) && $documents->total() > 0)
        <div class="tw-bg-white tw-shadow tw-rounded-lg">
            <div class="tw-px-4 tw-py-5 sm:tw-p-6">
                <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900 tw-mb-4">Filtrer les documents</h3>
                <form method="GET" action="{{ route('base-legal.thematiques.show', $thematique) }}" class="tw-space-y-4">
                    <div class="tw-grid tw-grid-cols-1 tw-gap-4 sm:tw-grid-cols-3">
                        <!-- Recherche -->
                        <div>
                            <label for="search" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Recherche</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                   placeholder="Titre du document..."
                                   class="tw-mt-1 tw-block tw-w-full tw-rounded-md tw-border-gray-300 tw-shadow-sm focus:tw-border-gray-500 focus:tw-ring-gray-500 sm:tw-text-sm">
                        </div>

                        <!-- Type de source -->
                        <div>
                            <label for="source_type" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Type de source</label>
                            <select name="source_type" id="source_type" 
                                    class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                <option value="">Tous les types</option>
                                @if(isset($sourceTypes))
                                    @foreach($sourceTypes as $sourceType)
                                        <option value="{{ $sourceType }}" {{ request('source_type') == $sourceType ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $sourceType)) }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Boutons -->
                        <div class="tw-flex tw-items-end tw-space-x-2">
                            <button type="submit" 
                                    class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-gray-600 hover:tw-bg-gray-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                                Filtrer
                            </button>
                            <a href="{{ route('base-legal.thematiques.show', $thematique) }}" 
                               class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                                Réinitialiser
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Liste des documents -->
    <div class="tw-bg-white tw-shadow tw-rounded-lg">
        <div class="tw-px-4 tw-py-5 sm:tw-px-6 tw-border-b tw-border-gray-200">
            <h3 class="tw-text-lg tw-leading-6 tw-font-medium tw-text-gray-900">
                Documents de cette thématique
                @if(isset($documents))
                    <span class="tw-text-sm tw-font-normal tw-text-gray-500">
                        ({{ $documents->total() }} document(s))
                    </span>
                @endif
            </h3>
        </div>
        
        @if(isset($documents) && $documents->count() > 0)
            <ul role="list" class="tw-divide-y tw-divide-gray-200">
                @foreach($documents as $document)
                    <li class="tw-px-4 tw-py-4 sm:tw-px-6 hover:tw-bg-gray-50">
                        <div class="tw-flex tw-items-start tw-justify-between">
                            <div class="tw-flex-1 tw-min-w-0">
                                <!-- Titre et statut -->
                                <div class="tw-flex tw-items-center tw-mb-2">
                                    <h4 class="tw-text-lg tw-font-medium tw-text-gray-600 tw-truncate">
                                        <a href="{{ route('base_documentaire_documents_show', $document) }}" 
                                           class="hover:tw-text-gray-800">
                                            {{ $document->titre }}
                                        </a>
                                    </h4>
                                    @if($document->fichier_pdf)
                                        <svg class="tw-ml-2 tw-h-5 tw-w-5 tw-text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                    @if(!$document->actif)
                                        <span class="tw-ml-2 tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-red-100 tw-text-red-800">
                                            Inactif
                                        </span>
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

                                    <!-- Date de création -->
                                    <div class="tw-flex tw-items-center">
                                        <svg class="tw-h-4 tw-w-4 tw-mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        {{ $document->created_at->format('d/m/Y') }}
                                    </div>
                                </div>

                                <!-- Autres thématiques -->
                                @if($document->thematiques->count() > 1)
                                    <div class="tw-mt-2 tw-flex tw-flex-wrap tw-gap-1">
                                        <span class="tw-text-xs tw-text-gray-500 tw-mr-2">Autres thématiques :</span>
                                        @foreach($document->thematiques->where('id', '!=', $thematique->id) as $otherThematique)
                                            <a href="{{ route('base-legal.thematiques.show', $otherThematique) }}" 
                                               class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-gray-100 tw-text-gray-800 hover:tw-bg-gray-200">
                                                {{ $otherThematique->nom }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
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
                                <a href="{{ route('base_documentaire_documents_edit_form', $document) }}"
                                   class="tw-inline-flex tw-items-center tw-p-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500 hover:tw-bg-gray-50"
                                   title="Modifier">
                                    <svg class="tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
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
            <!-- Aucun document -->
            <div class="tw-text-center tw-py-12">
                <svg class="tw-mx-auto tw-h-12 tw-w-12 tw-text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="tw-mt-2 tw-text-sm tw-font-medium tw-text-gray-900">Aucun document</h3>
                <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                    Aucun document n'est associé à cette thématique pour le moment.
                </p>
                <div class="tw-mt-6">
                    <a href="{{ route('base_documentaire_documents_create_form') }}?thematique={{ $thematique->id }}" 
                       class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-shadow-sm tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-gray-600 hover:tw-bg-gray-700">
                        <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Créer le premier document
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Actions en bas de page -->
    <div class="tw-bg-white tw-shadow tw-rounded-lg">
        <div class="tw-px-4 tw-py-5 sm:tw-p-6">
            <div class="tw-flex tw-justify-between tw-items-center">
                <div class="tw-flex tw-space-x-3">
                    <a href="{{ route('base-legal.thematiques.index') }}" 
                       class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50">
                        <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour aux thématiques
                    </a>
                    <a href="{{ route('baselegal_consultation', ['thematique' => $thematique->slug]) }}" 
                       class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50">
                        Voir dans la consultation
                    </a>
                </div>
                <div class="tw-flex tw-space-x-3">
                    <a href="{{ route('base-legal.thematiques.edit', $thematique) }}" 
                       class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-gray-600 hover:tw-bg-gray-700">
                        <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier la thématique
                    </a>
                    <form action="{{ route('base-legal.thematiques.destroy', $thematique) }}" method="POST" class="tw-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette thématique ? Tous les documents associés seront dissociés.')"
                                class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-red-600 hover:tw-bg-red-700">
                            <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
   </div>
   
  </div>
@endsection
