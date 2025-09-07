@extends('layouts.app')

@section('content')
<div class="tw-space-y-6 tw-p-4">
    <!-- Filtres et recherche -->
    <div class="tw-bg-white tw-shadow tw-rounded-lg">
        <div class="tw-px-4 tw-py-5 sm:tw-p-6">
            <!-- { route('baselegal_documents_index') }} -->
            <form method="GET" action="{{ route('baselegal_documents_index') }}" class="tw-space-y-4">
                <div class="tw-grid tw-grid-cols-1 tw-gap-4 sm:tw-grid-cols-2 lg:tw-grid-cols-4">
                    <!-- Recherche -->
                    <div>
                        <label for="search" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Recherche</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Titre du document..."
                               class="tw-mt-1 tw-block tw-w-full tw-rounded-md tw-border-gray-300 tw-shadow-sm focus:tw-border-orange-500 focus:tw-ring-orange-500 sm:tw-text-sm">
                    </div>

                    <!-- Thématique -->
                    <div>
                        <label for="thematique" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Thématique</label>
                        <select name="thematique" id="thematique" 
                                class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                            <option value="">Toutes les thématiques</option>
                            @foreach($thematiques as $thematique)
                                <option value="{{ $thematique->slug }}" {{ request('thematique') == $thematique->slug ? 'selected' : '' }}>
                                    {{ $thematique->nom }}
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
                            @foreach(\App\Models\Source::TYPES as $key => $label)
                                <option value="{{ $key }}" {{ request('source_type') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Boutons -->
                    <div class="tw-flex tw-items-end tw-space-x-2">
                        <button type="submit" 
                                class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-orange-600 hover:tw-bg-orange-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-orange-500">
                            Filtrer
                        </button>
                        <!-- { route('base-documentaire.documents.index') }} -->
                        <a href="{{ route('baselegal_documents_index') }}" 
                           class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-gray-300 tw-text-sm tw-font-medium tw-rounded-md tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-orange-500">
                            Réinitialiser
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Actions -->
    <div class="tw-flex tw-justify-between tw-items-center">
        <h2 class="tw-text-lg tw-font-medium tw-text-gray-900">
            {{ $documents->total() }} document(s) trouvé(s)
        </h2>
        <a href="{{ route('base_documentaire_documents_create_form') }}" 
           class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-orange-600 hover:tw-bg-orange-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-orange-500">
            <svg class="tw--ml-1 tw-mr-2 tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Nouveau document
        </a>
    </div>

    <!-- Liste des documents -->
    <div class="tw-bg-white tw-shadow tw-overflow-hidden sm:tw-rounded-md">
        <ul role="list" class="tw-divide-y tw-divide-gray-200">
            @forelse($documents as $document)
                <li>
                    <div class="tw-px-4 tw-py-4 sm:tw-px-6">
                        <div class="tw-flex tw-items-center tw-justify-between">
                            <div class="tw-flex-1 tw-min-w-0">
                                <div class="tw-flex tw-items-center">
                                    <h3 class="tw-text-sm tw-font-medium tw-text-orange-600 tw-truncate">
                                        <a href="{{ route('base_documentaire_documents_show', $document) }}">
                                            {{ $document->titre }}
                                        </a>
                                    </h3>
                                    @if($document->fichier_pdf)
                                        <svg class="tw-ml-2 tw-h-4 tw-w-4 tw-text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="tw-mt-2 tw-flex tw-items-center tw-text-sm tw-text-gray-500">
                                    <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-orange-100 tw-text-orange-800">
                                        {{ $document->source->type_libelle }}
                                    </span>
                                    <span class="tw-mx-2">•</span>
                                    <span>{{ $document->source->nom }}</span>
                                    @if($document->date_publication)
                                        <span class="tw-mx-2">•</span>
                                        <span>{{ $document->date_publication->format('d/m/Y') }}</span>
                                    @endif
                                </div>
                                <div class="tw-mt-2 tw-flex tw-flex-wrap tw-gap-1">
                                    @foreach($document->thematiques as $thematique)
                                        <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-gray-100 tw-text-gray-800">
                                            {{ $thematique->nom }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tw-flex-shrink-0 tw-flex tw-space-x-2">
                                @if($document->fichier_url)
                                    <a href="{{ $document->fichier_url }}" target="_blank"
                                       class="tw-inline-flex tw-items-center tw-p-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500">
                                        <svg class="tw-h-4 tw-w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>
                                @endif
                                <!-- { route('base-documentaire.documents.edit', $document) }} -->
                                <a href=""
                                   class="tw-inline-flex tw-items-center tw-p-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500">
                                    <svg class="tw-h-4 tw-w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <!-- { route('base-documentaire.documents.destroy', $document) }} -->
                                <form action="" method="POST" class="tw-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')"
                                            class="tw-inline-flex tw-items-center tw-p-2 tw-border tw-border-gray-300 tw-rounded-md tw-text-red-400 hover:tw-text-red-500">
                                        <svg class="tw-h-4 tw-w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="tw-px-4 tw-py-4 sm:tw-px-6 tw-text-center tw-text-gray-500">
                    Aucun document trouvé avec ces critères
                </li>
            @endforelse
        </ul>
    </div>

    <!-- Pagination -->
    @if($documents->hasPages())
        <div class="tw-bg-white tw-px-4 tw-py-3 tw-flex tw-items-center tw-justify-between tw-border-t tw-border-gray-200 sm:tw-px-6 tw-rounded-lg tw-shadow">
            {{ $documents->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection