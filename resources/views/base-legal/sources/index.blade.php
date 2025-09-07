@extends('layouts.app')

@section('content')
    <div class="tw-p-4">
        <div class="tw-flex tw-items-center">
            <li>
                <div class="tw-flex tw-items-center">
                    <svg class="tw-h-5 tw-w-5 tw-flex-shrink-0 tw-text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="tw-ml-4 tw-text-sm tw-font-medium tw-text-gray-500">Sources</span>
                </div>
            </li>
        </div>

        <a href="{{ route('base-legal.sources.create') }}"
            class="tw-inline-flex tw-items-center tw-px-4  my-4 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-gray-600 hover:tw-bg-gray-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
            <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Nouvelle source
        </a>

        <div class="tw-space-y-6">
            <!-- Statistiques -->
            <div class="tw-grid tw-grid-cols-1 tw-gap-5 sm:tw-grid-cols-2 lg:tw-grid-cols-4">
                <!-- Total sources -->
                <div class="tw-bg-white tw-overflow-hidden tw-shadow tw-rounded-lg">
                    <div class="tw-p-5">
                        <div class="tw-flex tw-items-center">
                            <div class="tw-flex-shrink-0">
                                <svg class="tw-h-6 tw-w-6 tw-text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                            </div>
                            <div class="tw-ml-5 tw-w-0 tw-flex-1">
                                <dl>
                                    <dt class="tw-text-sm tw-font-medium tw-text-gray-500 tw-truncate">Total sources</dt>
                                    <dd class="tw-text-lg tw-font-medium tw-text-gray-900">{{ $sources->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sources avec documents -->
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
                                        {{ $sources->where('documents_count', '>', 0)->count() }}</dd>
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
                                        {{ $sources->sum('documents_count') }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Types de sources -->
                <div class="tw-bg-white tw-overflow-hidden tw-shadow tw-rounded-lg">
                    <div class="tw-p-5">
                        <div class="tw-flex tw-items-center">
                            <div class="tw-flex-shrink-0">
                                <svg class="tw-h-6 tw-w-6 tw-text-purple-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div class="tw-ml-5 tw-w-0 tw-flex-1">
                                <dl>
                                    <dt class="tw-text-sm tw-font-medium tw-text-gray-500 tw-truncate">Types différents</dt>
                                    <dd class="tw-text-lg tw-font-medium tw-text-gray-900">
                                        {{ $sources->pluck('type')->unique()->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Répartition par type -->
            @if ($sources->count() > 0)
                <div class="tw-bg-white tw-shadow tw-rounded-lg">
                    <div class="tw-px-4 tw-py-5 sm:tw-p-6">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900 tw-mb-4">Répartition par type de
                            source</h3>
                        <div class="tw-grid tw-grid-cols-1 tw-gap-4 sm:tw-grid-cols-2 lg:tw-grid-cols-3">
                            @foreach ($sources->groupBy('type') as $type => $sourcesOfType)
                                @php
                                    $typeColors = [
                                        'loi' => 'tw-bg-red-100 tw-text-red-800',
                                        'decret' => 'tw-bg-blue-100 tw-text-blue-800',
                                        'convention_collective' => 'tw-bg-green-100 tw-text-green-800',
                                        'jurisprudence' => 'tw-bg-purple-100 tw-text-purple-800',
                                        'arrete' => 'tw-bg-yellow-100 tw-text-yellow-800',
                                        'circulaire' => 'tw-bg-gray-100 tw-text-gray-800',
                                    ];
                                    $colorClass = $typeColors[$type] ?? 'tw-bg-gray-100 tw-text-gray-800';
                                @endphp
                                <div
                                    class="tw-relative tw-rounded-lg tw-border tw-border-gray-300 tw-bg-white tw-px-6 tw-py-4 hover:tw-bg-gray-50">
                                    <div class="tw-flex tw-items-center tw-justify-between">
                                        <div class="tw-flex-1 tw-min-w-0">
                                            <span
                                                class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium {{ $colorClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                                            </span>
                                            <p class="tw-mt-1 tw-text-sm tw-text-gray-600">
                                                {{ $sourcesOfType->count() }} source(s)
                                            </p>
                                        </div>
                                        <div class="tw-flex-shrink-0">
                                            <span class="tw-text-lg tw-font-semibold tw-text-gray-900">
                                                {{ $sourcesOfType->sum('documents_count') }}
                                            </span>
                                            <span class="tw-text-sm tw-text-gray-500 tw-block">document(s)</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Liste des sources -->

            <div class="tw-bg-white tw-shadow tw-overflow-hidden sm:tw-rounded-md">
                <div class="tw-px-4 tw-py-5 sm:tw-px-6 tw-border-b tw-border-gray-200">
                    <h3 class="tw-text-lg tw-leading-6 tw-font-medium tw-text-gray-900">
                        Liste des sources
                        <span class="tw-text-sm tw-font-normal tw-text-gray-500">
                            ({{ $sources->count() }} source(s) enregistrée(s))
                        </span>
                    </h3>
                    <p class="tw-mt-1 tw-max-w-2xl tw-text-sm tw-text-gray-500">
                        Gérez les sources de vos documents juridiques (lois, décrets, conventions...)
                    </p>
                </div>

                @if ($sources->count() > 0)
                    <ul role="list" class="tw-divide-y tw-divide-gray-200">
                        @foreach ($sources as $source)
                            @php
                                $typeIcons = [
                                    'loi' => 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z',
                                    'decret' =>
                                        'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                                    'convention_collective' =>
                                        'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                                    'jurisprudence' =>
                                        'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3',
                                    'arrete' =>
                                        'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z',
                                    'circulaire' =>
                                        'M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2',
                                ];
                                $typeColors = [
                                    'loi' => 'tw-bg-red-100 tw-text-red-800',
                                    'decret' => 'tw-bg-blue-100 tw-text-blue-800',
                                    'convention_collective' => 'tw-bg-green-100 tw-text-green-800',
                                    'jurisprudence' => 'tw-bg-purple-100 tw-text-purple-800',
                                    'arrete' => 'tw-bg-yellow-100 tw-text-yellow-800',
                                    'circulaire' => 'tw-bg-gray-100 tw-text-gray-800',
                                ];
                                $iconPath =
                                    $typeIcons[$source->type] ??
                                    'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
                                $colorClass = $typeColors[$source->type] ?? 'tw-bg-gray-100 tw-text-gray-800';
                            @endphp
                            <li class="tw-px-4 tw-py-4 sm:tw-px-6 hover:tw-bg-gray-50">
                                <div class="tw-flex tw-items-center tw-justify-between">
                                    <div class="tw-flex-1 tw-min-w-0">
                                        <div class="tw-flex tw-items-center tw-space-x-3">
                                            <!-- Icône du type de source -->
                                            <div class="tw-flex-shrink-0">
                                                <div
                                                    class="tw-h-10 tw-w-10 tw-rounded-full tw-bg-gray-100 tw-flex tw-items-center tw-justify-center">
                                                    <svg class="tw-h-6 tw-w-6 tw-text-gray-600" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="{{ $iconPath }}" />
                                                    </svg>
                                                </div>
                                            </div>

                                            <!-- Informations principales -->
                                            <div class="tw-flex-1 tw-min-w-0">
                                                <div class="tw-flex tw-items-center tw-space-x-2 tw-mb-1">
                                                    <span
                                                        class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium {{ $colorClass }}">
                                                        {{ $source->type_libelle }}
                                                    </span>
                                                </div>

                                                <h3 class="tw-text-lg tw-font-medium tw-text-gray-900 tw-truncate">
                                                    <a href="{{ route('base-legal.sources.show', $source) }}"
                                                        class="hover:tw-text-gray-600">
                                                        {{ $source->nom }}
                                                    </a>
                                                </h3>

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
                                                        ID: {{ $source->id }}
                                                    </div>
                                                    <div class="tw-flex tw-items-center">
                                                        <svg class="tw-h-4 tw-w-4 tw-mr-1" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                        Créé le {{ $source->created_at->format('d/m/Y') }}
                                                    </div>
                                                    @if ($source->updated_at != $source->created_at)
                                                        <div class="tw-flex tw-items-center">
                                                            <svg class="tw-h-4 tw-w-4 tw-mr-1" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                            </svg>
                                                            Modifié le {{ $source->updated_at->format('d/m/Y') }}
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
                                            @if ($source->documents_count > 0)
                                                <span
                                                    class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-green-100 tw-text-green-800">
                                                    {{ $source->documents_count }} document(s)
                                                </span>
                                            @else
                                                <span
                                                    class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-gray-100 tw-text-gray-800">
                                                    Aucun document
                                                </span>
                                            @endif

                                            <!-- Pourcentage si documents existants -->
                                            @if ($sources->sum('documents_count') > 0)
                                                <span class="tw-text-xs tw-text-gray-400 tw-mt-1">
                                                    {{ $sources->sum('documents_count') > 0 ? round(($source->documents_count / $sources->sum('documents_count')) * 100, 1) : 0 }}%
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Actions -->
                                        <div class="tw-flex tw-space-x-2">
                                            <!-- Voir -->
                                            <a href="{{ route('base-legal.sources.show', $source) }}"
                                                class="tw-inline-flex tw-items-center tw-p-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500 hover:tw-bg-gray-50"
                                                title="Voir les documents de cette source">
                                                <svg class="tw-h-4 tw-w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <!-- Consultation publique -->
                                            <a href="{{ route('baselegal_consultation', ['source_type' => $source->type]) }}"
                                                class="tw-inline-flex tw-items-center tw-p-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500 hover:tw-bg-gray-50"
                                                title="Voir dans la consultation publique">
                                                <svg class="tw-h-4 tw-w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>

                                            <!-- Modifier -->
                                            <a href="{{ route('base-legal.sources.edit', $source) }}"
                                                class="tw-inline-flex tw-items-center tw-p-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500 hover:tw-bg-gray-50"
                                                title="Modifier cette source">
                                                <svg class="tw-h-4 tw-w-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- Supprimer -->
                                            <form action="{{ route('base-legal.sources.destroy', $source) }}"
                                                method="POST" class="tw-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette source ?\n\nAttention: Cette action supprimera également tous les documents associés.')"
                                                    class="tw-inline-flex tw-items-center tw-p-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-red-400 hover:tw-text-red-500 hover:tw-bg-red-50"
                                                    title="Supprimer cette source">
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
                                {{ $sources->count() }} source(s) • {{ $sources->sum('documents_count') }} document(s)
                                total
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
                                d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                        <h3 class="tw-mt-2 tw-text-sm tw-font-medium tw-text-gray-900">Aucune source</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                            Commencez par créer une nouvelle source pour organiser vos documents juridiques.
                        </p>
                        <div class="tw-mt-6">
                            <a href="{{ route('base-legal.sources.create') }}"
                                class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-shadow-sm tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-gray-600 hover:tw-bg-gray-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                                <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Créer la première source
                            </a>
                        </div>

                        <!-- Suggestions de sources -->
                        <div class="tw-mt-8 tw-max-w-lg tw-mx-auto">
                            <h4 class="tw-text-sm tw-font-medium tw-text-gray-900 tw-mb-3">Suggestions de sources
                                juridiques :
                            </h4>
                            <div class="tw-space-y-2">
                                @php
                                    $suggestions = [
                                        [
                                            'type' => 'loi',
                                            'nom' => 'Code du travail',
                                            'color' => 'tw-bg-red-100 tw-text-red-800',
                                        ],
                                        [
                                            'type' => 'loi',
                                            'nom' => 'Code de la sécurité sociale',
                                            'color' => 'tw-bg-red-100 tw-text-red-800',
                                        ],
                                        [
                                            'type' => 'decret',
                                            'nom' => 'Décret sur le temps de travail',
                                            'color' => 'tw-bg-blue-100 tw-text-blue-800',
                                        ],
                                        [
                                            'type' => 'convention_collective',
                                            'nom' => 'Convention collective nationale du bâtiment',
                                            'color' => 'tw-bg-green-100 tw-text-green-800',
                                        ],
                                        [
                                            'type' => 'jurisprudence',
                                            'nom' => 'Cour de cassation',
                                            'color' => 'tw-bg-purple-100 tw-text-purple-800',
                                        ],
                                    ];
                                @endphp
                                @foreach ($suggestions as $suggestion)
                                    <div
                                        class="tw-flex tw-items-center tw-justify-between tw-p-2 tw-bg-gray-50 tw-rounded-md">
                                        <div class="tw-flex tw-items-center tw-space-x-2">
                                            <span
                                                class="tw-inline-flex tw-items-center tw-px-2 tw-py-0.5 tw-rounded tw-text-xs tw-font-medium {{ $suggestion['color'] }}">
                                                {{ ucfirst(str_replace('_', ' ', $suggestion['type'])) }}
                                            </span>
                                            <span class="tw-text-sm tw-text-gray-700">{{ $suggestion['nom'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                @endif
            </div>

            <!-- Actions rapides -->
            @if ($sources->count() > 0)
                <div class="tw-bg-white tw-shadow tw-rounded-lg">
                    <div class="tw-px-4 tw-py-5 sm:tw-p-6">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900 tw-mb-4">Actions rapides</h3>
                        <div class="tw-grid tw-grid-cols-1 tw-gap-3 sm:tw-grid-cols-2 lg:tw-grid-cols-4">
                            <a href="{{ route('base-legal.sources.create') }}"
                                class="tw-inline-flex tw-items-center tw-justify-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-gray-600 hover:tw-bg-gray-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                                <svg class="-tw-ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Nouvelle source
                            </a>

                            <a href="{{ route('base_documentaire_documents_create_form') }}"
                                class="tw-inline-flex tw-items-center tw-justify-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                                Nouveau document
                            </a>

                            <a href="{{ route('baselegal_consultation') }}"
                                class="tw-inline-flex tw-items-center tw-justify-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                                Consultation publique
                            </a>

                            <a href="{{ route('baselegal_index') }}"
                                class="tw-inline-flex tw-items-center tw-justify-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                                Retour au dashboard
                            </a>
                        </div>
                    </div>
                </div>
            @endif


            <!-- Légende des types de sources -->
            @if ($sources->count() > 0)
                <div class="tw-bg-white tw-shadow tw-rounded-lg">
                    <div class="tw-px-4 tw-py-5 sm:tw-p-6">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900 tw-mb-4">Types de sources
                            juridiques
                        </h3>
                        <div class="tw-grid tw-grid-cols-1 tw-gap-4 sm:tw-grid-cols-2 lg:tw-grid-cols-3">
                            @php
                                $typesInfo = [
                                    'loi' => [
                                        'libelle' => 'Loi',
                                        'description' => 'Textes votés par le Parlement',
                                        'exemples' => 'Code du travail, Code civil',
                                        'color' => 'tw-bg-red-100 tw-text-red-800',
                                    ],
                                    'decret' => [
                                        'libelle' => 'Décret',
                                        'description' => 'Textes pris par le pouvoir exécutif',
                                        'exemples' => 'Décrets d\'application, décrets en Conseil d\'État',
                                        'color' => 'tw-bg-blue-100 tw-text-blue-800',
                                    ],
                                    'convention_collective' => [
                                        'libelle' => 'Convention collective',
                                        'description' => 'Accords entre partenaires sociaux',
                                        'exemples' => 'CCN du bâtiment, CCN de la métallurgie',
                                        'color' => 'tw-bg-green-100 tw-text-green-800',
                                    ],
                                    'jurisprudence' => [
                                        'libelle' => 'Jurisprudence',
                                        'description' => 'Décisions de justice faisant référence',
                                        'exemples' => 'Arrêts de la Cour de cassation',
                                        'color' => 'tw-bg-purple-100 tw-text-purple-800',
                                    ],
                                    'arrete' => [
                                        'libelle' => 'Arrêté',
                                        'description' => 'Décisions administratives',
                                        'exemples' => 'Arrêtés ministériels, préfectoraux',
                                        'color' => 'tw-bg-yellow-100 tw-text-yellow-800',
                                    ],
                                    'circulaire' => [
                                        'libelle' => 'Circulaire',
                                        'description' => 'Instructions administratives',
                                        'exemples' => 'Circulaires DGT, circulaires ministérielles',
                                        'color' => 'tw-bg-gray-100 tw-text-gray-800',
                                    ],
                                ];
                            @endphp
                            @foreach ($typesInfo as $type => $info)
                                <div class="tw-border tw-border-gray-200 tw-rounded-lg tw-p-4">
                                    <div class="tw-flex tw-items-center tw-mb-2">
                                        <span
                                            class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium {{ $info['color'] }}">
                                            {{ $info['libelle'] }}
                                        </span>
                                        @if ($sources->where('type', $type)->count() > 0)
                                            <span class="tw-ml-2 tw-text-xs tw-text-gray-500">
                                                ({{ $sources->where('type', $type)->count() }} dans votre base)
                                            </span>
                                        @endif
                                    </div>
                                    <p class="tw-text-sm tw-text-gray-700 tw-mb-1">{{ $info['description'] }}</p>
                                    <p class="tw-text-xs tw-text-gray-500">
                                        <span class="tw-font-medium">Exemples :</span> {{ $info['exemples'] }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
