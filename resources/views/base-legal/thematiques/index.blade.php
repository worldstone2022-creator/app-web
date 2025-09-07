@extends('layouts.app')

@section('content')
    <div class="tw-p-4">
        <ul class="tw-mb-4 tw-flex tw-items-center tw-space-x-4">
            <li>
                <div class="tw-flex tw-items-center">
                    <svg class="tw-h-5 tw-w-5 tw-flex-shrink-0 tw-text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="tw-ml-4 tw-text-sm tw-font-medium tw-text-gray-500">Thématiques</span>
                </div>
            </li>
        </ul>

        <a href="{{ route('base-legal.thematiques.create') }}"
            class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-gray-600 hover:tw-bg-gray-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
            <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Nouvelle thématique
        </a>

        <div class="tw-space-y-6 mt-4">
            <!-- Statistiques -->
            <div class="tw-grid tw-grid-cols-1 tw-gap-5 sm:tw-grid-cols-2 lg:tw-grid-cols-3">
                <!-- Total thématiques -->
                <div class="tw-bg-white tw-overflow-hidden tw-shadow tw-rounded-lg">
                    <div class="tw-p-5">
                        <div class="tw-flex tw-items-center">
                            <div class="tw-flex-shrink-0">
                                <svg class="tw-h-6 tw-w-6 tw-text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <div class="tw-ml-5 tw-w-0 tw-flex-1">
                                <dl>
                                    <dt class="tw-text-sm tw-font-medium tw-text-gray-500 tw-truncate">Total thématiques
                                    </dt>
                                    <dd class="tw-text-lg tw-font-medium tw-text-gray-900">{{ $thematiques->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thématiques avec documents -->
                <div class="tw-bg-white tw-overflow-hidden tw-shadow tw-rounded-lg">
                    <div class="tw-p-5">
                        <div class="tw-flex tw-items-center">
                            <div class="tw-flex-shrink-0">
                                <svg class="tw-h-6 tw-w-6 tw-text-green-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="tw-ml-5 tw-w-0 tw-flex-1">
                                <dl>
                                    <dt class="tw-text-sm tw-font-medium tw-text-gray-500 tw-truncate">Avec documents</dt>
                                    <dd class="tw-text-lg tw-font-medium tw-text-gray-900">
                                        {{ $thematiques->where('documents_count', '>', 0)->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total documents -->
                <div class="tw-bg-white tw-overflow-hidden tw-shadow tw-rounded-lg">
                    <div class="tw-p-5">
                        <div class="tw-flex tw-items-center">
                            <div class="tw-flex-shrink-0">
                                <svg class="tw-h-6 tw-w-6 tw-text-blue-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <div class="tw-ml-5 tw-w-0 tw-flex-1">
                                <dl>
                                    <dt class="tw-text-sm tw-font-medium tw-text-gray-500 tw-truncate">Total documents</dt>
                                    <dd class="tw-text-lg tw-font-medium tw-text-gray-900">
                                        {{ $thematiques->sum('documents_count') }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des thématiques -->
            <div class="tw-bg-white tw-shadow tw-overflow-hidden sm:tw-rounded-md">
                <div class="tw-px-4 tw-py-5 sm:tw-px-6 tw-border-b tw-border-gray-200">
                    <h3 class="tw-text-lg tw-leading-6 tw-font-medium tw-text-gray-900">
                        Liste des thématiques
                        <span class="tw-text-sm tw-font-normal tw-text-gray-500">
                            ({{ $thematiques->count() }} thématique(s) enregistrée(s))
                        </span>
                    </h3>
                    <p class="tw-mt-1 tw-max-w-2xl tw-text-sm tw-text-gray-500">
                        Gérez les thématiques pour organiser vos documents juridiques
                    </p>
                </div>

                @if ($thematiques->count() > 0)
                    <ul role="list" class="tw-divide-y tw-divide-gray-200">
                        @foreach ($thematiques as $thematique)
                            <li class="tw-px-4 tw-py-4 sm:tw-px-6 hover:tw-bg-gray-50">
                                <div class="tw-flex tw-items-center tw-justify-between">
                                    <div class="tw-flex-1 tw-min-w-0">
                                        <div class="tw-flex tw-items-center tw-space-x-3">
                                            <!-- Icône thématique -->
                                            <div class="tw-flex-shrink-0">
                                                <svg class="tw-h-8 tw-w-8 tw-text-gray-600" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                            </div>

                                            <!-- Informations principales -->
                                            <div class="tw-flex-1 tw-min-w-0">
                                                <h3 class="tw-text-lg tw-font-medium tw-text-gray-900 tw-truncate">
                                                    <a href="{{ route('base-legal.thematiques.show', $thematique) }}"
                                                        class="hover:tw-text-gray-600">
                                                        {{ $thematique->nom }}
                                                    </a>
                                                </h3>

                                                @if ($thematique->description)
                                                    <p class="tw-mt-1 tw-text-sm tw-text-gray-500 tw-line-clamp-2">
                                                        {{ $thematique->description }}
                                                    </p>
                                                @endif

                                                <!-- Métadonnées -->
                                                <div
                                                    class="tw-mt-2 tw-flex tw-items-center tw-text-sm tw-text-gray-400 tw-space-x-4">
                                                    <div class="tw-flex tw-items-center">
                                                        <svg class="tw-h-4 tw-w-4 tw-mr-1" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                        </svg>
                                                        Slug: {{ $thematique->slug }}
                                                    </div>
                                                    <div class="tw-flex tw-items-center">
                                                        <svg class="tw-h-4 tw-w-4 tw-mr-1" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                        Créé le {{ $thematique->created_at->format('d/m/Y') }}
                                                    </div>
                                                    @if ($thematique->updated_at != $thematique->created_at)
                                                        <div class="tw-flex tw-items-center">
                                                            <svg class="tw-h-4 tw-w-4 tw-mr-1" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                            </svg>
                                                            Modifié le {{ $thematique->updated_at->format('d/m/Y') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Badges et actions -->
                                    <div class="tw-flex tw-items-center tw-space-x-3">
                                        <!-- Badge nombre de documents -->
                                        <div class="tw-flex tw-flex-col tw-items-center">
                                            @if ($thematique->documents_count > 0)
                                                <span
                                                    class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-green-100 tw-text-green-800">
                                                    {{ $thematique->documents_count }} document(s)
                                                </span>
                                            @else
                                                <span
                                                    class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-gray-100 tw-text-gray-800">
                                                    Aucun document
                                                </span>
                                            @endif

                                            <!-- Pourcentage si documents existants -->
                                            @if ($thematiques->sum('documents_count') > 0)
                                                <span class="tw-text-xs tw-text-gray-400 tw-mt-1">
                                                    {{ $thematiques->sum('documents_count') > 0 ? round(($thematique->documents_count / $thematiques->sum('documents_count')) * 100, 1) : 0 }}%
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Actions -->
                                        <div class="tw-flex tw-space-x-2">
                                            <!-- Voir -->
                                            <a href="{{ route('base-legal.thematiques.show', $thematique) }}"
                                                class="tw-inline-flex tw-items-center tw-p-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500 hover:tw-bg-gray-50"
                                                title="Voir les documents de cette thématique">
                                                <svg class="tw-h-4 tw-w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <!-- Consultation publique -->
                                            <a href="{{ route('baselegal_consultation', ['thematique' => $thematique->slug]) }}"
                                                class="tw-inline-flex tw-items-center tw-p-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500 hover:tw-bg-gray-50"
                                                title="Voir dans la consultation publique">
                                                <svg class="tw-h-4 tw-w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>

                                            <!-- Modifier -->
                                            <a href="{{ route('base-legal.thematiques.edit', $thematique) }}"
                                                class="tw-inline-flex tw-items-center tw-p-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500 hover:tw-bg-gray-50"
                                                title="Modifier cette thématique">
                                                <svg class="tw-h-4 tw-w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- Supprimer -->
                                            <form action="{{ route('base-legal.thematiques.destroy', $thematique) }}"
                                                method="POST" class="tw-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette thématique ?\n\nAttention: Cette action dissociera tous les documents de cette thématique.')"
                                                    class="tw-inline-flex tw-items-center tw-p-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-red-400 hover:tw-text-red-500 hover:tw-bg-red-50"
                                                    title="Supprimer cette thématique">
                                                    <svg class="tw-h-4 tw-w-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Actions en bas de liste -->
                    <div class="tw-bg-gray-50 tw-px-4 tw-py-3 sm:tw-px-6">
                        <div class="tw-flex tw-justify-between tw-items-center">
                            <div class="tw-text-sm tw-text-gray-500">
                                {{ $thematiques->count() }} thématique(s) • {{ $thematiques->sum('documents_count') }}
                                document(s) total
                            </div>
                            <div class="tw-flex tw-space-x-3">
                                <a href="{{ route('baselegal_consultation') }}"
                                    class="tw-text-sm tw-font-medium tw-text-gray-600 hover:tw-text-gray-500">
                                    Voir la consultation publique
                                    <span aria-hidden="true"> &rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- État vide -->
                    <div class="tw-text-center tw-py-12">
                        <svg class="tw-mx-auto tw-h-12 tw-w-12 tw-text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <h3 class="tw-mt-2 tw-text-sm tw-font-medium tw-text-gray-900">Aucune thématique</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                            Commencez par créer une nouvelle thématique pour organiser vos documents.
                        </p>
                        <div class="tw-mt-6">
                            <a href="{{ route('base-legal.thematiques.create') }}"
                                class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-shadow-sm tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-gray-600 hover:tw-bg-gray-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                                <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Créer la première thématique
                            </a>
                        </div>

                        <!-- Suggestions de thématiques -->
                        <div class="tw-mt-8 tw-max-w-lg tw-mx-auto">
                            <h4 class="tw-text-sm tw-font-medium tw-text-gray-900 tw-mb-3">Suggestions de thématiques
                                juridiques :</h4>
                            <div class="tw-flex tw-flex-wrap tw-justify-center tw-gap-2">
                                @php
                                    $suggestions = [
                                        'Contrats de travail',
                                        'Durée du travail',
                                        'Rémunération',
                                        'Congés et absences',
                                        'Formation professionnelle',
                                        'Hygiène et sécurité',
                                        'Relations sociales',
                                        'Licenciement',
                                    ];
                                @endphp
                                @foreach ($suggestions as $suggestion)
                                    <span
                                        class="tw-inline-flex tw-items-center tw-px-3 tw-py-1 tw-rounded-full tw-text-xs tw-font-medium tw-bg-gray-100 tw-text-gray-700">
                                        {{ $suggestion }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Actions rapides -->
            @if ($thematiques->count() > 0)
                <div class="tw-bg-white tw-shadow tw-rounded-lg">
                    <div class="tw-px-4 tw-py-5 sm:tw-p-6">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900 tw-mb-4">Actions rapides</h3>
                        <div class="tw-grid tw-grid-cols-1 tw-gap-3 sm:tw-grid-cols-2 lg:tw-grid-cols-4">
                            <a href="{{ route('base-legal.thematiques.create') }}"
                                class="tw-inline-flex tw-items-center tw-justify-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-gray-600 hover:tw-bg-gray-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                                <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Nouvelle thématique
                            </a>

                            {{-- <a href="{{ route('base-legal.documents.create') }}" 
                       class="tw-inline-flex tw-items-center tw-justify-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                        Nouveau document
                    </a>
                    
                    <a href="{{ route('base-legal.consultation') }}" 
                       class="tw-inline-flex tw-items-center tw-justify-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                        Consultation publique
                    </a>
                    
                    <a href="{{ route('base-legal.dashboard') }}" 
                       class="tw-inline-flex tw-items-center tw-justify-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                        Retour au dashboard
                    </a> --}}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
