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
                    <a href="{{ route('baselegal_documents_index')}}"
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
                    <a href="{{ route('base_documentaire_documents_show', $document) }}"
                        class="tw-ml-4 tw-text-sm tw-font-medium tw-text-gray-500 hover:tw-text-gray-700">{{ Str::limit($document->titre, 30) }}</a>
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
        <form action="{{ route('base_documentaire_documents_edit', $document) }}" method="POST" enctype="multipart/form-data" class="tw-space-y-6">
            @csrf
            @method('PUT')

            <!-- Informations générales -->
            <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
                <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
                    <div class="md:tw-col-span-1">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Informations générales</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                            Modifiez les informations de base du document juridique.
                        </p>
                    </div>
                    <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                        <div class="tw-grid tw-grid-cols-6 tw-gap-6">
                            <!-- Titre -->
                            <div class="tw-col-span-6">
                                <label for="titre" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Titre
                                    *</label>
                                <input type="text" name="titre" id="titre"
                                    value="{{ old('titre', $document->titre) }}" required
                                    class="tw-mt-1 focus:tw-ring-orange-500 focus:tw-border-orange-500 tw-block tw-w-full tw-shadow-sm sm:tw-text-sm tw-border-gray-300 tw-rounded-md">
                                @error('titre')
                                    <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="tw-col-span-6">
                                <label for="description"
                                    class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Description</label>
                                <textarea id="description" name="description" rows="4"
                                    class="tw-mt-1 focus:tw-ring-orange-500 focus:tw-border-orange-500 tw-block tw-w-full tw-shadow-sm sm:tw-text-sm tw-border-gray-300 tw-rounded-md"
                                    placeholder="Description détaillée du document...">{{ old('description', $document->description) }}</textarea>
                                @error('description')
                                    <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Source -->
                            <div class="tw-col-span-6 sm:tw-col-span-3">
                                <label for="source_id" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Source
                                    *</label>
                                <select id="source_id" name="source_id" required
                                    class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                    <option value="">Sélectionner une source</option>
                                    @foreach ($sources as $source)
                                        <option value="{{ $source->id }}"
                                            {{ old('source_id', $document->source_id) == $source->id ? 'selected' : '' }}>
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
                                <label for="date_publication"
                                    class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Date de publication</label>
                                <input type="date" name="date_publication" id="date_publication"
                                    value="{{ old('date_publication', $document->date_publication ? $document->date_publication->format('Y-m-d') : '') }}"
                                    class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                @error('date_publication')
                                    <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Statut actif -->
                            <div class="tw-col-span-6">
                                <div class="tw-flex tw-items-center">
                                    <input id="actif" name="actif" type="checkbox"
                                        {{ old('actif', $document->actif) ? 'checked' : '' }}
                                        class="focus:tw-ring-orange-500 tw-h-4 tw-w-4 tw-text-orange-600 tw-border-gray-300 tw-rounded">
                                    <label for="actif" class="tw-ml-2 tw-block tw-text-sm tw-text-gray-900">
                                        Document actif (visible dans la consultation publique)
                                    </label>
                                </div>
                                @error('actif')
                                    <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fichiers et liens -->
            <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
                <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
                    <div class="md:tw-col-span-1">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Fichier et liens</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                            Modifiez le document PDF ou le lien externe.
                        </p>
                    </div>
                    <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                        <div class="tw-grid tw-grid-cols-6 tw-gap-6">
                            <!-- Fichier actuel -->
                            @if ($document->fichier_pdf)
                                <div class="tw-col-span-6">
                                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Fichier
                                        actuel</label>
                                    <div class="tw-mt-1 tw-flex tw-items-center tw-space-x-3">
                                        <div class="tw-flex tw-items-center">
                                            <svg class="tw-h-5 tw-w-5 tw-text-red-600" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span
                                                class="tw-ml-2 tw-text-sm tw-text-gray-900">{{ basename($document->fichier_pdf) }}</span>
                                        </div>
                                        <a href="{{ $document->fichier_url }}" target="_blank"
                                            class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-1.5 tw-border tw-border-gray-300 tw-shadow-sm tw-text-xs tw-font-medium tw-rounded tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50">
                                            <svg class="tw-h-4 tw-w-4 tw-mr-1" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Voir
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <!-- Nouveau fichier PDF -->
                            <div class="tw-col-span-6">
                                <label for="fichier_pdf" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                    {{ $document->fichier_pdf ? 'Remplacer le fichier PDF' : 'Fichier PDF' }}
                                </label>
                                <div
                                    class="tw-mt-1 tw-flex tw-justify-center tw-px-6 tw-pt-5 tw-pb-6 tw-border-2 tw-border-gray-300 tw-border-dashed tw-rounded-md">
                                    <div class="tw-space-y-1 tw-text-center">
                                        <svg class="tw-mx-auto tw-h-12 tw-w-12 tw-text-gray-400" stroke="currentColor"
                                            fill="none" viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="tw-flex tw-text-sm tw-text-gray-600">
                                            <label for="fichier_pdf"
                                                class="tw-relative tw-cursor-pointer tw-bg-white tw-rounded-md tw-font-medium tw-text-orange-600 hover:tw-text-orange-500 focus-within:tw-outline-none focus-within:tw-ring-2 focus-within:tw-ring-offset-2 focus-within:tw-ring-orange-500">
                                                <span>Télécharger un fichier</span>
                                                <input id="fichier_pdf" name="fichier_pdf" type="file" accept=".pdf"
                                                    class="tw-sr-only">
                                            </label>
                                            <p class="tw-pl-1">ou glisser-déposer</p>
                                        </div>
                                        <p class="tw-text-xs tw-text-gray-500">PDF jusqu'à 10MB</p>
                                    </div>
                                </div>
                                @error('fichier_pdf')
                                    <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                                @if ($document->fichier_pdf)
                                    <p class="tw-mt-2 tw-text-sm tw-text-gray-500">
                                        <strong>Note :</strong> Si vous téléchargez un nouveau fichier, il remplacera
                                        l'ancien fichier.
                                    </p>
                                @endif
                            </div>

                            <!-- URL externe -->
                            <div class="tw-col-span-6">
                                <label for="url_externe" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Ou
                                    URL externe</label>
                                <div class="tw-mt-1 tw-flex tw-rounded-md tw-shadow-sm">
                                    <span
                                        class="tw-inline-flex tw-items-center tw-px-3 tw-rounded-l-md tw-border tw-border-r-0 tw-border-gray-300 tw-bg-gray-50 tw-text-gray-500 tw-text-sm">
                                        <svg class="tw-h-4 tw-w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                        </svg>
                                    </span>
                                    <input type="url" name="url_externe" id="url_externe"
                                        value="{{ old('url_externe', $document->url_externe) }}"
                                        placeholder="https://exemple.com/document.pdf"
                                        class="tw-flex-1 tw-min-w-0 tw-block tw-w-full tw-px-3 tw-py-2 tw-rounded-none tw-rounded-r-md focus:tw-ring-orange-500 focus:tw-border-orange-500 sm:tw-text-sm tw-border-gray-300">
                                </div>
                                @error('url_externe')
                                    <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="tw-mt-2 tw-text-sm tw-text-gray-500">
                                    Alternative au fichier PDF. Laissez vide si vous utilisez un fichier.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Classification -->
            <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
                <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
                    <div class="md:tw-col-span-1">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Classification</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                            Modifiez les thématiques associées au document.
                        </p>
                    </div>
                    <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                        <!-- Thématiques -->
                        <fieldset>
                            <legend class="tw-text-sm tw-font-medium tw-text-gray-700">Thématiques *</legend>
                            <div class="tw-mt-4 tw-space-y-2">
                                @php
                                    $selectedThematiques = old(
                                        'thematiques',
                                        $document->thematiques->pluck('id')->toArray(),
                                    );
                                @endphp
                                @foreach ($thematiques as $thematique)
                                    <div class="tw-flex tw-items-center">
                                        <input id="thematique_{{ $thematique->id }}" name="thematiques[]"
                                            type="checkbox" value="{{ $thematique->id }}"
                                            {{ in_array($thematique->id, $selectedThematiques) ? 'checked' : '' }}
                                            class="focus:tw-ring-orange-500 tw-h-4 tw-w-4 tw-text-orange-600 tw-border-gray-300 tw-rounded">
                                        <label for="thematique_{{ $thematique->id }}"
                                            class="tw-ml-3 tw-text-sm tw-font-medium tw-text-gray-700">
                                            {{ $thematique->nom }}
                                            @if ($thematique->description)
                                                <span class="tw-text-gray-500">- {{ $thematique->description }}</span>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('thematiques')
                                <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                            @enderror
                            @if ($thematiques->count() === 0)
                                <p class="tw-mt-2 tw-text-sm tw-text-gray-500">
                                    Aucune thématique disponible.
                                    <!-- { route('base-legal.thematiques.create') }} -->
                                    <a href="" class="tw-text-orange-600 hover:tw-text-orange-500">
                                        Créer une thématique
                                    </a>
                                </p>
                            @endif
                        </fieldset>
                    </div>
                </div>
            </div>

            <!-- Métadonnées (lecture seule) -->
            <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
                <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
                    <div class="md:tw-col-span-1">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Métadonnées</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                            Informations sur le document (lecture seule).
                        </p>
                    </div>
                    <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                        <dl class="tw-grid tw-grid-cols-1 tw-gap-x-4 tw-gap-y-4 sm:tw-grid-cols-2">
                            <div>
                                <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Créé le</dt>
                                <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">
                                    {{ $document->created_at->format('d/m/Y à H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Modifié le</dt>
                                <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">
                                    {{ $document->updated_at->format('d/m/Y à H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="tw-text-sm tw-font-medium tw-text-gray-500">ID du document</dt>
                                <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">#{{ $document->id }}</dd>
                            </div>
                            <div>
                                <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Statut actuel</dt>
                                <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">
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
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="tw-flex tw-justify-between tw-items-center tw-space-x-3">
                <div class="tw-flex tw-space-x-3">
                    <a href="{{ route('base_documentaire_documents_show', $document) }}"
                        class="tw-bg-white tw-py-2 tw-px-4 tw-border tw-border-gray-300 tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-orange-500">
                        <svg class="tw-inline tw-h-4 tw-w-4 tw-mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour au document
                    </a>
                    <a href="{{ route('baselegal_consultation') }}"
                        class="tw-bg-white tw-py-2 tw-px-4 tw-border tw-border-gray-300 tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-orange-500">
                        Liste des documents
                    </a>
                </div>
                <div class="tw-flex tw-space-x-3">
                    <button type="button" onclick="window.history.back()"
                        class="tw-bg-white tw-py-2 tw-px-4 tw-border tw-border-gray-300 tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-orange-500">
                        Annuler
                    </button>
                    <button type="submit"
                        class="tw-inline-flex tw-justify-center tw-py-2 tw-px-4 tw-border tw-border-transparent tw-shadow-sm tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-orange-600 hover:tw-bg-orange-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-orange-500">
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
            // Affichage du nom du fichier sélectionné
            document.getElementById('fichier_pdf').addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name;
                if (fileName) {
                    const fileInfo = document.createElement('p');
                    fileInfo.className = 'tw-mt-2 tw-text-sm tw-text-green-600';
                    fileInfo.textContent = `Fichier sélectionné : ${fileName}`;

                    // Supprimer l'ancien message s'il existe
                    const oldInfo = e.target.closest('.tw-border-dashed').querySelector('.tw-text-green-600');
                    if (oldInfo) oldInfo.remove();

                    e.target.closest('.tw-border-dashed').appendChild(fileInfo);
                }
            });

            // Validation côté client
            document.querySelector('form').addEventListener('submit', function(e) {
                const thematiques = document.querySelectorAll('input[name="thematiques[]"]:checked');
                if (thematiques.length === 0) {
                    e.preventDefault();
                    alert('Veuillez sélectionner au moins une thématique.');
                    return false;
                }
            });
        </script>
    @endpush
@endsection
