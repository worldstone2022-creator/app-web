@extends('layouts.app')

@section('content')

    <div class="p-4">
        <ul class="tw-flex tw-items-center tw-space-x-4  tw-py-2">
            <li>
                <div class="tw-flex tw-items-center">
                    <svg class="tw-h-5 tw-w-5 tw-flex-shrink-0 tw-text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <a href="{{ route('baselegal_documents_index') }}"
                        class="tw-ml-4 tw-text-sm tw-font-medium tw-text-gray-500 hover:tw-text-gray-700">Documents</a>
                </div>
            </li>
            <li>
                <div class="tw-flex tw-items-center">
                    <svg class="tw-h-5 tw-w-5 tw-flex-shrink-0 tw-text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span
                        class="tw-ml-4 tw-text-sm tw-font-medium tw-text-gray-500 tw-truncate">{{ Str::limit($document->titre, 50) }}</span>
                </div>
            </li>
        </ul>

        <div class="tw-space-y-6">
            <!-- Informations principales du document -->
            <div class="tw-bg-white tw-shadow tw-overflow-hidden sm:tw-rounded-lg">
                <div class="tw-px-4 tw-py-5 sm:tw-px-6">
                    <div class="tw-flex tw-items-center tw-justify-between">
                        <div class="tw-flex-1 tw-min-w-0">
                            <h1
                                class="tw-text-2xl tw-font-bold tw-leading-7 tw-text-gray-900 sm:tw-text-3xl sm:tw-truncate">
                                {{ $document->titre }}
                            </h1>
                            <div
                                class="tw-mt-1 tw-flex tw-flex-col sm:tw-flex-row sm:tw-flex-wrap sm:tw-mt-0 sm:tw-space-x-6">
                                <!-- Statut -->
                                <div class="tw-mt-2 tw-flex tw-items-center tw-text-sm tw-text-gray-500">
                                    <svg class="tw-flex-shrink-0 tw-mr-1.5 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @if ($document->actif)
                                        <span
                                            class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-green-100 tw-text-green-800">
                                            Actif
                                        </span>
                                    @else
                                        <span
                                            class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-red-100 tw-text-red-800">
                                            Inactif
                                        </span>
                                    @endif
                                </div>

                                <!-- Date de publication -->
                                @if ($document->date_publication)
                                    <div class="tw-mt-2 tw-flex tw-items-center tw-text-sm tw-text-gray-500">
                                        <svg class="tw-flex-shrink-0 tw-mr-1.5 tw-h-5 tw-w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Publié le {{ $document->date_publication->format('d/m/Y') }}
                                    </div>
                                @endif

                                <!-- Date de création -->
                                <div class="tw-mt-2 tw-flex tw-items-center tw-text-sm tw-text-gray-500">
                                    <svg class="tw-flex-shrink-0 tw-mr-1.5 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Créé le {{ $document->created_at->format('d/m/Y à H:i') }}
                                </div>
                            </div>
                        </div>
                        <div class="tw-flex tw-justify-end tw-space-x-3">
                            @if ($document->fichier_url)
                                <a href="{{ $document->fichier_url }}" target="_blank"
                                    class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-red-600 hover:tw-bg-red-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-red-500">
                                    <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Consulter le PDF
                                </a>
                            @endif
                            @if (in_array('admin', user_roles()))
                                <a href="{{ route('base_documentaire_documents_edit_form', $document) }}"
                                    class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                                    <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Modifier
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Détails du document -->
                <div class="tw-border-t tw-border-gray-200 tw-px-4 tw-py-5 sm:tw-p-0">
                    <dl class="sm:tw-divide-y sm:tw-divide-gray-200">
                        <!-- Description -->
                        @if ($document->description)
                            <div class="tw-py-4 sm:tw-py-5 sm:tw-grid sm:tw-grid-cols-3 sm:tw-gap-4 sm:tw-px-6">
                                <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Description</dt>
                                <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 sm:tw-mt-0 sm:tw-col-span-2">
                                    <div class="tw-prose tw-prose-sm tw-max-w-none">
                                        {{ $document->description }}
                                    </div>
                                </dd>
                            </div>
                        @endif

                        <!-- Source -->
                        <div class="tw-py-4 sm:tw-py-5 sm:tw-grid sm:tw-grid-cols-3 sm:tw-gap-4 sm:tw-px-6">
                            <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Source</dt>
                            <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 sm:tw-mt-0 sm:tw-col-span-2">
                                <div class="tw-flex tw-items-center">
                                    <span
                                        class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-blue-100 tw-text-blue-800">
                                        {{ $document->source->type_libelle }}
                                    </span>
                                    <span class="tw-ml-2 tw-text-sm tw-text-gray-900">{{ $document->source->nom }}</span>
                                </div>
                            </dd>
                        </div>

                        <!-- Thématiques -->
                        <div class="tw-py-4 sm:tw-py-5 sm:tw-grid sm:tw-grid-cols-3 sm:tw-gap-4 sm:tw-px-6">
                            <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Thématiques</dt>
                            <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 sm:tw-mt-0 sm:tw-col-span-2">
                                <div class="tw-flex tw-flex-wrap tw-gap-2">
                                    @foreach ($document->thematiques as $thematique)
                                        <!-- { route('base-legal.thematiques.show', $thematique) }} -->
                                        <a href=""
                                            class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-gray-100 tw-text-gray-800 hover:tw-bg-gray-200">
                                            {{ $thematique->nom }}
                                        </a>
                                    @endforeach
                                </div>
                            </dd>
                        </div>

                        <!-- Fichier / Lien -->
                        <div class="tw-py-4 sm:tw-py-5 sm:tw-grid sm:tw-grid-cols-3 sm:tw-gap-4 sm:tw-px-6">
                            <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Document</dt>
                            <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 sm:tw-mt-0 sm:tw-col-span-2">
                                @if ($document->fichier_pdf)
                                    <div class="tw-flex tw-items-center">
                                        <svg class="tw-h-5 tw-w-5 tw-text-red-600 tw-mr-2" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <a href="{{ $document->fichier_url }}" target="_blank"
                                            class="tw-text-gray-600 hover:tw-text-gray-500">
                                            Fichier PDF ({{ basename($document->fichier_pdf) }})
                                            <svg class="tw-inline tw-h-4 tw-w-4 tw-ml-1" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    </div>
                                @elseif($document->url_externe)
                                    <div class="tw-flex tw-items-center">
                                        <svg class="tw-h-5 tw-w-5 tw-text-blue-600 tw-mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                        </svg>
                                        <a href="{{ $document->url_externe }}" target="_blank"
                                            class="tw-text-gray-600 hover:tw-text-gray-500">
                                            Lien externe
                                            <svg class="tw-inline tw-h-4 tw-w-4 tw-ml-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    </div>
                                @else
                                    <span class="tw-text-gray-400">Aucun fichier ou lien disponible</span>
                                @endif
                            </dd>
                        </div>

                        <!-- Métadonnées -->
                        <div class="tw-py-4 sm:tw-py-5 sm:tw-grid sm:tw-grid-cols-3 sm:tw-gap-4 sm:tw-px-6">
                            <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Métadonnées</dt>
                            <dd class="tw-mt-1 tw-text-sm tw-text-gray-900 sm:tw-mt-0 sm:tw-col-span-2">
                                <div class="tw-grid tw-grid-cols-1 tw-gap-2 sm:tw-grid-cols-2">
                                    <div>
                                        <span class="tw-font-medium">Créé :</span>
                                        {{ $document->created_at->format('d/m/Y à H:i') }}
                                    </div>
                                    <div>
                                        <span class="tw-font-medium">Modifié :</span>
                                        {{ $document->updated_at->format('d/m/Y à H:i') }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Aperçu PDF intégré (si fichier PDF disponible) -->
            @if ($document->fichier_pdf)
                <div class="tw-bg-white tw-shadow tw-rounded-lg">
                    <div class="tw-px-4 tw-py-5 sm:tw-px-6 tw-border-b tw-border-gray-200">
                        <h3 class="tw-text-lg tw-leading-6 tw-font-medium tw-text-gray-900">
                            Aperçu du document
                        </h3>
                        <p class="tw-mt-1 tw-max-w-2xl tw-text-sm tw-text-gray-500">
                            Visualisation du document PDF
                        </p>
                    </div>
                    <div class="tw-px-4 tw-py-5 sm:tw-p-6">
                        <div class="tw-border tw-border-gray-300 tw-rounded-lg tw-overflow-hidden" style="height: 600px;">
                            <iframe src="{{ $document->fichier_url }}" class="tw-w-full tw-h-full"
                                title="Aperçu du document {{ $document->titre }}">
                                <p class="tw-text-center tw-py-8">
                                    Votre navigateur ne supporte pas l'affichage des PDF.
                                    <!-- { $document->fichier_url }} -->
                                    <a href="" target="_blank" class="tw-text-gray-600 hover:tw-text-gray-500">
                                        Cliquez ici pour télécharger le fichier.
                                    </a>
                                </p>
                            </iframe>
                        </div>
                        <div class="tw-mt-4 tw-text-center">
                            <!-- { $document->fichier_url }} -->
                            <a href="" target="_blank"
                                class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-red-600 hover:tw-bg-red-700">
                                <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                                Télécharger le PDF
                            </a>
                        </div>
                    </div>
                </div>
            @endif


            <!-- Documents liés (même thématique) -->
            @if ($document->thematiques->count() > 0)
                <div class="tw-bg-white tw-shadow tw-rounded-lg">
                    <div class="tw-px-4 tw-py-5 sm:tw-px-6 tw-border-b tw-border-gray-200">
                        <h3 class="tw-text-lg tw-leading-6 tw-font-medium tw-text-gray-900">
                            Documents similaires
                        </h3>
                        <p class="tw-mt-1 tw-max-w-2xl tw-text-sm tw-text-gray-500">
                            Autres documents dans les mêmes thématiques
                        </p>
                    </div>
                    <div class="tw-px-4 tw-py-5 sm:tw-p-6">
                        @php
                            $documentsLies = \App\Models\Document::actif()
                                ->whereHas('thematiques', function ($q) use ($document) {
                                    $q->whereIn('thematiques.id', $document->thematiques->pluck('id'));
                                })
                                ->where('id', '!=', $document->id)
                                ->with(['source', 'thematiques'])
                                ->take(5)
                                ->get();
                        @endphp

                        @if ($documentsLies->count() > 0)
                            <div class="tw-space-y-4">
                                @foreach ($documentsLies as $docLie)
                                    <div class="tw-border tw-border-gray-200 tw-rounded-lg tw-p-4 hover:tw-bg-gray-50">
                                        <div class="tw-flex tw-items-start tw-justify-between">
                                            <div class="tw-flex-1 tw-min-w-0">
                                                <h4 class="tw-text-sm tw-font-medium tw-text-gray-600">
                                                    <!-- { route('base-legal.documents.show', $docLie) }} -->
                                                    <a href="" class="hover:tw-text-gray-800">
                                                        {{ $docLie->titre }}
                                                    </a>
                                                </h4>
                                                <div class="tw-mt-1 tw-flex tw-items-center tw-text-sm tw-text-gray-500">
                                                    <span
                                                        class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-blue-100 tw-text-blue-800">
                                                        {{ $docLie->source->type_libelle }}
                                                    </span>
                                                    <span class="tw-ml-2">{{ $docLie->source->nom }}</span>
                                                    @if ($docLie->date_publication)
                                                        <span class="tw-mx-2">•</span>
                                                        <span>{{ $docLie->date_publication->format('d/m/Y') }}</span>
                                                    @endif
                                                </div>
                                                <div class="tw-mt-2 tw-flex tw-flex-wrap tw-gap-1">
                                                    @foreach ($docLie->thematiques->intersect($document->thematiques) as $thematique)
                                                        <span
                                                            class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-yellow-100 tw-text-yellow-800">
                                                            {{ $thematique->nom }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @if ($docLie->fichier_url)
                                                <div class="tw-flex-shrink-0 tw-ml-4">
                                                    <a href="{{ $docLie->fichier_url }}" target="_blank"
                                                        class="tw-inline-flex tw-items-center tw-p-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500">
                                                        <svg class="tw-h-4 tw-w-4" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="tw-text-sm tw-text-gray-500 tw-text-center tw-py-4">
                                Aucun document similaire trouvé.
                            </p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Actions en bas de page -->
            <div class="tw-bg-white tw-shadow tw-rounded-lg">
                <div class="tw-px-4 tw-py-5 sm:tw-p-6">
                    <div class="tw-flex tw-justify-between tw-items-center">
                        <div class="tw-flex tw-space-x-3">
                            <a href="{{ route('baselegal_documents_index') }}"
                                class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50">
                                <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Retour à la liste
                            </a>
                        </div>
                        @if (in_array('admin', user_roles()))
                            <div class="tw-flex tw-space-x-3">
                                <a href="{{ route('base_documentaire_documents_edit_form', $document) }}"
                                    class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-gray-600 hover:tw-bg-gray-700">
                                    <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Modifier
                                </a>
                                <!-- { route('base-legal.documents.destroy', $document) }} -->
                                <form action="{{ route('base_documentaire_documents_destroy', $document) }}"
                                    method="POST" class="tw-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')"
                                        class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-red-600 hover:tw-bg-red-700">
                                        <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
