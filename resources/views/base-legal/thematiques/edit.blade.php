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
                    <a href="{{ route('base-legal.thematiques.show', $thematique) }}"
                        class="tw-ml-4 tw-text-sm tw-font-medium tw-text-gray-500 hover:tw-text-gray-700">{{ Str::limit($thematique->nom, 30) }}</a>
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
        <form action="{{ route('base-legal.thematiques.update', $thematique) }}" method="POST" class="tw-space-y-6">
            @csrf
            @method('PUT')

            <!-- Informations actuelles -->
            <div class="tw-bg-blue-50 tw-border tw-border-blue-200 tw-rounded-lg tw-p-4">
                <div class="tw-flex">
                    <div class="tw-flex-shrink-0">
                        <svg class="tw-h-5 tw-w-5 tw-text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="tw-ml-3">
                        <h3 class="tw-text-sm tw-font-medium tw-text-blue-800">
                            Informations actuelles
                        </h3>
                        <div class="tw-mt-2 tw-text-sm tw-text-blue-700">
                            <ul class="tw-list-disc tw-list-inside tw-space-y-1">
                                <li><strong>Nom actuel :</strong> {{ $thematique->nom }}</li>
                                <li><strong>Slug actuel :</strong> {{ $thematique->slug }}</li>
                                <li><strong>Documents associés :</strong> {{ $thematique->documents->count() }} document(s)
                                </li>
                                <li><strong>Dernière modification :</strong>
                                    {{ $thematique->updated_at->format('d/m/Y à H:i') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire de modification -->
            <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
                <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
                    <div class="md:tw-col-span-1">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Modifier la thématique</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                            Modifiez les informations de cette thématique. Le slug sera automatiquement mis à jour si vous
                            changez le nom.
                        </p>

                        <!-- Impact des modifications -->
                        @if ($thematique->documents->count() > 0)
                            <div class="tw-mt-4 tw-p-3 tw-bg-yellow-50 tw-border tw-border-yellow-200 tw-rounded-md">
                                <div class="tw-flex">
                                    <div class="tw-flex-shrink-0">
                                        <svg class="tw-h-5 tw-w-5 tw-text-yellow-400" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="tw-ml-3">
                                        <h3 class="tw-text-sm tw-font-medium tw-text-yellow-800">
                                            Impact sur les documents
                                        </h3>
                                        <div class="tw-mt-2 tw-text-sm tw-text-yellow-700">
                                            <p>Cette thématique est associée à {{ $thematique->documents->count() }}
                                                document(s). Les modifications n'affecteront pas ces associations.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                        <div class="tw-grid tw-grid-cols-6 tw-gap-6">
                            <!-- Nom de la thématique -->
                            <div class="tw-col-span-6">
                                <label for="nom" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                    Nom de la thématique *
                                </label>
                                <input type="text" name="nom" id="nom"
                                    value="{{ old('nom', $thematique->nom) }}" required
                                    class="tw-mt-1 focus:tw-ring-gray-500 focus:tw-border-gray-500 tw-block tw-w-full tw-shadow-sm sm:tw-text-sm tw-border-gray-300 tw-rounded-md tw-border tw-px-3 tw-py-2"
                                    placeholder="Ex: Contrats de travail">
                                @error('nom')
                                    <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror

                                <!-- Aperçu du nouveau slug -->
                                <div class="tw-mt-2 tw-text-sm tw-text-gray-500">
                                    <span class="tw-font-medium">Slug actuel :</span>
                                    <code
                                        class="tw-bg-gray-100 tw-px-1 tw-py-0.5 tw-rounded tw-text-xs">{{ $thematique->slug }}</code>
                                </div>
                                <div class="tw-mt-1 tw-text-sm tw-text-gray-500">
                                    <span class="tw-font-medium">Nouveau slug (aperçu) :</span>
                                    <code id="slug-preview"
                                        class="tw-bg-green-100 tw-px-1 tw-py-0.5 tw-rounded tw-text-xs">{{ $thematique->slug }}</code>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="tw-col-span-6">
                                <label for="description"
                                    class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Description</label>
                                <textarea id="description" name="description" rows="4"
                                    class="tw-mt-1 focus:tw-ring-gray-500 focus:tw-border-gray-500 tw-block tw-w-full tw-shadow-sm sm:tw-text-sm tw-border-gray-300 tw-rounded-md tw-border tw-px-3 tw-py-2"
                                    placeholder="Description détaillée de cette thématique...">{{ old('description', $thematique->description) }}</textarea>
                                @error('description')
                                    <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror

                                <!-- Compteur de caractères -->
                                <div class="tw-mt-2 tw-text-sm tw-text-gray-500">
                                    <span id="char-count">{{ strlen($thematique->description ?? '') }}</span> caractères
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents associés (lecture seule) -->
            @if ($thematique->documents->count() > 0)
                <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
                    <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
                        <div class="md:tw-col-span-1">
                            <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Documents associés</h3>
                            <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                                Liste des documents actuellement associés à cette thématique.
                            </p>
                        </div>
                        <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                            <div class="tw-border tw-border-gray-200 tw-rounded-md tw-divide-y tw-divide-gray-200">
                                @foreach ($thematique->documents->take(5) as $document)
                                    <div class="tw-p-3">
                                        <div class="tw-flex tw-items-center tw-justify-between">
                                            <div class="tw-flex-1 tw-min-w-0">
                                                <p class="tw-text-sm tw-font-medium tw-text-gray-900 tw-truncate">
                                                    {{ $document->titre }}
                                                </p>
                                                <p class="tw-text-sm tw-text-gray-500">
                                                    {{ $document->source->type_libelle }} - {{ $document->source->nom }}
                                                </p>
                                            </div>
                                            <div class="tw-flex-shrink-0">
                                                <a href="{{ route('base_documentaire_documents_show', $document) }}"
                                                    class="tw-text-gray-600 hover:tw-text-gray-500 tw-text-sm">
                                                    Voir
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @if ($thematique->documents->count() > 5)
                                    <div class="tw-p-3 tw-bg-gray-50">
                                        <p class="tw-text-sm tw-text-gray-500 tw-text-center">
                                            ... et {{ $thematique->documents->count() - 5 }} autre(s) document(s)
                                        </p>
                                        <div class="tw-text-center tw-mt-2">
                                            <a href="{{ route('base-legal.thematiques.show', $thematique) }}"
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

            <!-- Métadonnées (lecture seule) -->
            <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
                <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
                    <div class="md:tw-col-span-1">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Métadonnées</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                            Informations sur cette thématique (lecture seule).
                        </p>
                    </div>
                    <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                        <dl class="tw-grid tw-grid-cols-1 tw-gap-x-4 tw-gap-y-4 sm:tw-grid-cols-2">
                            <div>
                                <dt class="tw-text-sm tw-font-medium tw-text-gray-500">ID de la thématique</dt>
                                <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">#{{ $thematique->id }}</dd>
                            </div>
                            <div>
                                <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Slug actuel</dt>
                                <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">
                                    <code
                                        class="tw-bg-gray-100 tw-px-2 tw-py-1 tw-rounded tw-text-xs">{{ $thematique->slug }}</code>
                                </dd>
                            </div>
                            <div>
                                <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Créé le</dt>
                                <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">
                                    {{ $thematique->created_at->format('d/m/Y à H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Modifié le</dt>
                                <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">
                                    {{ $thematique->updated_at->format('d/m/Y à H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="tw-text-sm tw-font-medium tw-text-gray-500">Nombre de documents</dt>
                                <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">
                                    <span
                                        class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-green-100 tw-text-green-800">
                                        {{ $thematique->documents->count() }} document(s)
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="tw-text-sm tw-font-medium tw-text-gray-500">URL de consultation</dt>
                                <dd class="tw-mt-1 tw-text-sm tw-text-gray-900">
                                    <a href="{{ route('baselegal_consultation', ['thematique' => $thematique->slug]) }}"
                                        target="_blank" class="tw-text-gray-600 hover:tw-text-gray-500 tw-break-all">
                                        /legal/thematique/{{ $thematique->slug }}
                                        <svg class="tw-inline tw-h-3 tw-w-3 tw-ml-1" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
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
                    <a href="{{ route('base-legal.thematiques.show', $thematique) }}"
                        class="tw-bg-white tw-py-2 tw-px-4 tw-border tw-border-gray-300 tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                        <svg class="tw-inline tw-h-4 tw-w-4 tw-mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour à la thématique
                    </a>
                    <a href="{{ route('base-legal.thematiques.index') }}"
                        class="tw-bg-white tw-py-2 tw-px-4 tw-border tw-border-gray-300 tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                        Liste des thématiques
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
            // Génération d'aperçu du slug en temps réel
            function generateSlug(text) {
                return text
                    .toLowerCase()
                    .trim()
                    .replace(/[àáâãäå]/g, 'a')
                    .replace(/[èéêë]/g, 'e')
                    .replace(/[ìíîï]/g, 'i')
                    .replace(/[òóôõö]/g, 'o')
                    .replace(/[ùúûü]/g, 'u')
                    .replace(/[ýÿ]/g, 'y')
                    .replace(/[ñ]/g, 'n')
                    .replace(/[ç]/g, 'c')
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
            }

            // Mise à jour de l'aperçu du slug
            document.getElementById('nom').addEventListener('input', function(e) {
                const slugPreview = document.getElementById('slug-preview');
                const newSlug = generateSlug(e.target.value);
                slugPreview.textContent = newSlug || '{{ $thematique->slug }}';

                // Mise en évidence si le slug change
                if (newSlug && newSlug !== '{{ $thematique->slug }}') {
                    slugPreview.className = 'tw-bg-yellow-100 tw-px-1 tw-py-0.5 tw-rounded tw-text-xs tw-font-medium';
                } else {
                    slugPreview.className = 'tw-bg-green-100 tw-px-1 tw-py-0.5 tw-rounded tw-text-xs';
                }
            });

            // Compteur de caractères pour la description
            document.getElementById('description').addEventListener('input', function(e) {
                const charCount = document.getElementById('char-count');
                charCount.textContent = e.target.value.length;

                // Changement de couleur selon la longueur
                if (e.target.value.length > 500) {
                    charCount.className = 'tw-text-red-600 tw-font-medium';
                } else if (e.target.value.length > 300) {
                    charCount.className = 'tw-text-yellow-600 tw-font-medium';
                } else {
                    charCount.className = '';
                }
            });

            // Validation côté client
            document.querySelector('form').addEventListener('submit', function(e) {
                const nom = document.getElementById('nom').value.trim();
                if (nom.length < 3) {
                    e.preventDefault();
                    alert('Le nom de la thématique doit contenir au moins 3 caractères.');
                    return false;
                }
            });
        </script>
    @endpush
@endsection
