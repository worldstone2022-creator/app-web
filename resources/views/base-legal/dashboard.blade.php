@extends('layouts.app')

@section('content')
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4 tw-pt-4 sm:tw-px-6 lg:tw-px-8">
        <!-- Statistiques principales -->
        <div class="tw-grid tw-grid-cols-1 tw-gap-4 sm:tw-grid-cols-2 lg:tw-grid-cols-4">
            <div class=" tw-rounded-lg tw-bg-white tw-p-4 tw-shadow">
                <dt class="tw-truncate tw-text-sm tw-font-medium tw-text-gray-500">Documents</dt>
                <dd class="tw-mt-1 tw-text-xl tw-font-semibold tw-tracking-tight tw-text-gray-900">
                    {{ $stats['totalDocuments'] }}</dd>
            </div>

            <div class=" tw-rounded-lg tw-bg-white tw-p-4 tw-shadow">
                <dt class="tw-truncate tw-text-sm tw-font-medium tw-text-gray-500">Thématiques totales</dt>
                <dd class="tw-mt-1 tw-text-xl tw-font-semibold tw-tracking-tight tw-text-gray-900">
                    {{ $stats['totalThematiques'] }}</dd>
            </div>

            <div class=" tw-rounded-lg tw-bg-white tw-p-4 tw-shadow">
                <dt class="tw-truncate tw-text-sm tw-font-medium tw-text-gray-500">Sources totales</dt>
                <dd class="tw-mt-1 tw-text-xl tw-font-semibold tw-tracking-tight tw-text-gray-900">
                    {{ $stats['totalSources'] }}</dd>
            </div>
            @if (in_array('admin', user_roles()))
                <div class=" tw-rounded-lg tw-bg-white tw-p-4 tw-shadow">
                    <dt class="tw-truncate tw-text-sm tw-font-medium tw-text-gray-500">Documents inactifs</dt>
                    <dd class="tw-mt-1 tw-text-xl tw-font-semibold tw-tracking-tight tw-text-red-600">
                        {{ $stats['documentsInactifs'] }}</dd>
                </div>
            @endif
        </div>


        <div class="tw-grid tw-grid-cols-1 tw-gap-4 tw-lg:tw-grid-cols-2 tw-pt-4">
            <!-- Actions rapides -->
            <div class="tw-bg-white tw-overflow-hidden tw-shadow tw-rounded-lg">
                <div class="tw-px-4 tw-py-5 tw-sm:tw-px-6">
                    <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900 tw-mb-4">Actions rapides</h3>
                    <div class="tw-grid tw-grid-cols-1 tw-gap-3 sm:tw-grid-cols-2">
                         @if (in_array('admin', user_roles()))
                        <a href="{{ route('base_documentaire_documents_create_form') }}"
                            class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-flex tw-items-center tw-justify-center tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200
">
                            Nouveau document
                        </a>

                        <a href="{{ route('base-legal.thematiques.index') }}"
                            class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-flex tw-items-center tw-justify-center tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                            Nouvelle thématique
                        </a>

                        <a href="{{ route('base-legal.sources.index') }}"
                            class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-flex tw-items-center tw-justify-center tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                            Nouvelle source
                        </a>
                        @endif
                        <a href="{{ route('baselegal_consultation') }}"
                            class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-flex tw-items-center tw-justify-center tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                            Voir la consultation
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistiques par type de source -->
            <div class="tw-bg-white tw-overflow-hidden tw-shadow tw-rounded-lg ">
                <div class="tw-px-4 tw-py-5 tw-sm:tw-px-6">
                    <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900 tw-mb-4">Répartition par type de
                        source</h3>
                    <div class="tw-space-y-3">
                        @foreach ($sourceStats as $type => $data)
                            <div class="tw-flex tw-justify-between tw-items-center">
                                <span class="tw-text-sm tw-font-medium tw-text-gray-600 tw-capitalize">
                                    {{ str_replace('_', ' ', $type) }}
                                </span>
                                <div class="tw-flex tw-items-center tw-space-x-2">
                                    <span class="tw-text-sm tw-text-gray-500">{{ $data['count'] }} source(s)</span>
                                    <span
                                        class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-gray-100 tw-text-gray-800">
                                        {{ $data['documents'] }} doc(s)
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents récents et Top thématiques -->
        <!-- Documents récents et Top thématiques -->
        <div class="tw-grid tw-grid-cols-1 tw-gap-6 lg:tw-grid-cols-2 tw-py-4">
            <!-- Documents récents -->
            <div class="tw-bg-white tw-shadow tw-overflow-hidden sm:tw-rounded-md">
                <div class="tw-px-4 tw-py-5 sm:tw-px-6">
                    <h3 class="tw-text-lg tw-leading-6 tw-font-medium tw-text-gray-900">Documents récents</h3>
                    <p class="tw-mt-1 tw-max-w-2xl tw-text-sm tw-text-gray-500">Les 5 derniers documents ajoutés</p>
                </div>
                <ul role="list" class="tw-divide-y tw-divide-gray-200">
                    @forelse($recentDocuments as $document)
                        <li>
                            <a href="{{ route('base_documentaire_documents_show', $document) }}"
                                class="tw-block hover:tw-bg-gray-50">
                                <div class="tw-px-4 tw-py-4 sm:tw-px-6">
                                    <div class="tw-flex tw-items-center tw-justify-between">
                                        <div class="tw-flex-1 tw-min-w-0">
                                            <p class="tw-text-sm tw-font-medium tw-text-[#838383] tw-truncate">
                                                {{ $document->titre }}
                                            </p>
                                            <p class="tw-text-sm tw-text-gray-500">{{ $document->source->type_libelle }} -
                                                {{ $document->source->nom }}</p>
                                        </div>
                                        <div class="tw-flex-shrink-0">
                                            <span
                                                class="tw-text-xs tw-text-gray-400">{{ $document->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="tw-px-4 tw-py-4 sm:tw-px-6 tw-text-center tw-text-gray-500">
                            Aucun document pour le moment
                        </li>
                    @endforelse
                </ul>
            </div>

            <!-- Top thématiques -->
            <div class="tw-bg-white tw-shadow tw-overflow-hidden sm:tw-rounded-md">
                <div class="tw-px-4 tw-py-5 sm:tw-px-6">
                    <h3 class="tw-text-lg tw-leading-6 tw-font-medium tw-text-gray-900">Thématiques les plus utilisées</h3>
                    <p class="tw-mt-1 tw-max-w-2xl tw-text-sm tw-text-gray-500">Top 5 des thématiques</p>
                </div>
                <ul role="list" class="tw-divide-y tw-divide-gray-200">
                    @forelse($topThematiques as $thematique)
                        <li>
                            <a href="{{ route('base-legal.thematiques.show', $thematique) }}"
                                class="tw-block hover:tw-bg-gray-50">
                                <div class="tw-px-4 tw-py-4 sm:tw-px-6">
                                    <div class="tw-flex tw-items-center tw-justify-between">
                                        <div class="tw-flex-1 tw-min-w-0">
                                            <p class="tw-text-sm tw-font-medium tw-text-gray-900">{{ $thematique->nom }}
                                            </p>
                                            @if ($thematique->description)
                                                <p class="tw-text-sm tw-text-gray-500 tw-truncate">
                                                    {{ $thematique->description }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="tw-flex-shrink-0">
                                            <span
                                                class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-green-100 tw-text-green-800">
                                                {{ $thematique->documents_count }} doc(s)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="tw-px-4 tw-py-4 sm:tw-px-6 tw-text-center tw-text-gray-500">
                            Aucune thématique pour le moment
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
