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
                    <span class="tw-ml-4 tw-text-sm tw-font-medium tw-text-gray-500">Nouvelle</span>
                </div>
            </li>
        </ul>
        <form action="{{ route('base-legal.thematiques.store') }}" method="POST" class="tw-space-y-6">
            @csrf

            <!-- Introduction et conseils -->
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
                            Conseils pour créer une thématique
                        </h3>
                        <div class="tw-mt-2 tw-text-sm tw-text-blue-700">
                            <ul class="tw-list-disc tw-list-inside tw-space-y-1">
                                <li>Choisissez un nom clair et précis qui décrit le domaine juridique</li>
                                <li>Le slug sera généré automatiquement à partir du nom</li>
                                <li>Une description détaillée aidera les utilisateurs à comprendre le contenu</li>
                                <li>Vous pourrez associer des documents à cette thématique après sa création</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire principal -->
            <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
                <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
                    <div class="md:tw-col-span-1">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Informations de la thématique
                        </h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                            Créez une nouvelle thématique pour organiser vos documents juridiques par domaine d'application.
                        </p>
                    </div>
                    <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                        <div class="tw-grid tw-grid-cols-6 tw-gap-6">
                            <!-- Nom de la thématique -->
                            <div class="tw-col-span-6">
                                <label for="nom" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                    Nom de la thématique *
                                </label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                                    class="tw-mt-1 focus:tw-ring-gray-500 focus:tw-border-gray-500 tw-block tw-w-full tw-shadow-sm sm:tw-text-sm tw-border-gray-300 tw-rounded-md tw-border tw-px-3 tw-py-2"
                                    placeholder="Ex: Contrats de travail">
                                @error('nom')
                                    <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror

                                <!-- Aperçu du slug -->
                                <div class="tw-mt-2 tw-text-sm tw-text-gray-500">
                                    <span class="tw-font-medium">Slug généré :</span>
                                    <code id="slug-preview"
                                        class="tw-bg-gray-100 tw-px-1 tw-py-0.5 tw-rounded tw-text-xs">slug-automatique</code>
                                </div>
                                <p class="tw-mt-1 tw-text-xs tw-text-gray-400">
                                    Le slug est utilisé dans les URLs et sera généré automatiquement
                                </p>
                            </div>

                            <!-- Description -->
                            <div class="tw-col-span-6">
                                <label for="description"
                                    class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">Description</label>
                                <textarea id="description" name="description" rows="4"
                                    class="tw-mt-1 focus:tw-ring-gray-500 focus:tw-border-gray-500 tw-block tw-w-full tw-shadow-sm sm:tw-text-sm tw-border-gray-300 tw-rounded-md tw-border tw-px-3 tw-py-2"
                                    placeholder="Description détaillée de cette thématique juridique...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror

                                <!-- Compteur de caractères -->
                                <div class="tw-mt-2 tw-flex tw-justify-between tw-text-sm tw-text-gray-500">
                                    <span>Description optionnelle mais recommandée</span>
                                    <span><span id="char-count">0</span> caractères</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Suggestions de thématiques -->
            <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
                <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
                    <div class="md:tw-col-span-1">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Suggestions</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                            Thématiques juridiques courantes pour vous inspirer.
                        </p>
                    </div>
                    <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                        <div class="tw-space-y-4">
                            <p class="tw-text-sm tw-text-gray-600">Cliquez sur une suggestion pour l'utiliser :</p>

                            <!-- Thématiques par catégorie -->
                            <div class="tw-space-y-3">
                                <!-- Droit du travail -->
                                <div>
                                    <h4 class="tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Droit du travail</h4>
                                    <div class="tw-flex tw-flex-wrap tw-gap-2">
                                        @php
                                            $suggestions_travail = [
                                                'Contrats de travail',
                                                'Durée du travail',
                                                'Rémunération et salaires',
                                                'Congés et absences',
                                                'Formation professionnelle',
                                                'Hygiène et sécurité',
                                                'Licenciement',
                                                'Relations sociales',
                                            ];
                                        @endphp
                                        @foreach ($suggestions_travail as $suggestion)
                                            <button type="button"
                                                onclick="fillSuggestion('{{ $suggestion }}', getDescription('{{ $suggestion }}'))"
                                                class="tw-inline-flex tw-items-center tw-px-3 tw-py-1 tw-rounded-full tw-text-xs tw-font-medium tw-bg-blue-100 tw-text-blue-700 hover:tw-bg-blue-200 tw-cursor-pointer tw-transition-colors">
                                                {{ $suggestion }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Droit social -->
                                <div>
                                    <h4 class="tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Droit social</h4>
                                    <div class="tw-flex tw-flex-wrap tw-gap-2">
                                        @php
                                            $suggestions_social = [
                                                'Sécurité sociale',
                                                'Retraites',
                                                'Chômage et emploi',
                                                'Handicap et insertion',
                                                'Protection sociale',
                                                'Égalité professionnelle',
                                            ];
                                        @endphp
                                        @foreach ($suggestions_social as $suggestion)
                                            <button type="button"
                                                onclick="fillSuggestion('{{ $suggestion }}', getDescription('{{ $suggestion }}'))"
                                                class="tw-inline-flex tw-items-center tw-px-3 tw-py-1 tw-rounded-full tw-text-xs tw-font-medium tw-bg-green-100 tw-text-green-700 hover:tw-bg-green-200 tw-cursor-pointer tw-transition-colors">
                                                {{ $suggestion }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Droit des entreprises -->
                                <div>
                                    <h4 class="tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Droit des entreprises
                                    </h4>
                                    <div class="tw-flex tw-flex-wrap tw-gap-2">
                                        @php
                                            $suggestions_entreprise = [
                                                'Création d\'entreprise',
                                                'Fiscalité des entreprises',
                                                'Droit commercial',
                                                'Propriété intellectuelle',
                                                'Concurrence et consommation',
                                                'Restructurations',
                                            ];
                                        @endphp
                                        @foreach ($suggestions_entreprise as $suggestion)
                                            <button type="button"
                                                onclick="fillSuggestion('{{ $suggestion }}', getDescription('{{ $suggestion }}'))"
                                                class="tw-inline-flex tw-items-center tw-px-3 tw-py-1 tw-rounded-full tw-text-xs tw-font-medium tw-bg-purple-100 tw-text-purple-700 hover:tw-bg-purple-200 tw-cursor-pointer tw-transition-colors">
                                                {{ $suggestion }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Bouton pour effacer -->
                            <div class="tw-pt-3 tw-border-t tw-border-gray-200">
                                <button type="button" onclick="clearForm()"
                                    class="tw-inline-flex tw-items-center tw-px-3 tw-py-1 tw-border tw-border-gray-300 tw-shadow-sm tw-text-xs tw-font-medium tw-rounded tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50">
                                    <svg class="tw-h-3 tw-w-3 tw-mr-1" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Effacer le formulaire
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aperçu -->
            <div id="preview-section" class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6 tw-hidden">
                <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
                    <div class="md:tw-col-span-1">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Aperçu</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                            Voici comment apparaîtra votre thématique.
                        </p>
                    </div>
                    <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                        <div class="tw-border tw-border-gray-200 tw-rounded-lg tw-p-4 tw-bg-gray-50">
                            <div class="tw-flex tw-items-center tw-space-x-3">
                                <svg class="tw-h-8 tw-w-8 tw-text-gray-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <div class="tw-flex-1">
                                    <h4 id="preview-nom" class="tw-text-lg tw-font-medium tw-text-gray-900">Nom de la
                                        thématique</h4>
                                    <p id="preview-description" class="tw-text-sm tw-text-gray-500 tw-hidden">Description
                                    </p>
                                    <p id="preview-slug" class="tw-text-xs tw-text-gray-400 tw-mt-1">slug: <code
                                            class="tw-bg-white tw-px-1 tw-py-0.5 tw-rounded">slug-automatique</code></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="tw-flex tw-justify-between tw-items-center tw-space-x-3">
                <div class="tw-flex tw-space-x-3">
                    <a href="{{ route('base-legal.thematiques.index') }}"
                        class="tw-bg-white tw-py-2 tw-px-4 tw-border tw-border-gray-300 tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                        <svg class="tw-inline tw-h-4 tw-w-4 tw-mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour aux thématiques
                    </a>
                </div>
                <div class="tw-flex tw-space-x-3">
                    <button type="button" onclick="clearForm()"
                        class="tw-bg-white tw-py-2 tw-px-4 tw-border tw-border-gray-300 tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                        Effacer
                    </button>
                    <button type="submit"
                        class="tw-inline-flex tw-justify-center tw-py-2 tw-px-4 tw-border tw-border-transparent tw-shadow-sm tw-text-sm tw-font-medium tw-rounded-md tw-text-white tw-bg-gray-600 hover:tw-bg-gray-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                        <svg class="tw-h-4 tw-w-4 tw-mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Créer la thématique
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Descriptions par défaut pour les suggestions
            const descriptions = {
                'Contrats de travail': 'Règles relatives aux différents types de contrats de travail (CDI, CDD, intérim, apprentissage...)',
                'Durée du travail': 'Temps de travail, heures supplémentaires, repos quotidien et hebdomadaire, aménagement du temps de travail',
                'Rémunération et salaires': 'Salaires, primes, avantages en nature, égalité salariale, modes de rémunération',
                'Congés et absences': 'Congés payés, congés maladie, congés familiaux, absences autorisées et non autorisées',
                'Formation professionnelle': 'Formation continue, CPF, plan de formation, apprentissage, validation des acquis',
                'Hygiène et sécurité': 'Conditions de travail, prévention des risques professionnels, équipements de protection',
                'Licenciement': 'Procédures de licenciement, motifs, indemnités, préavis, contestations',
                'Relations sociales': 'Représentation du personnel, négociation collective, dialogue social, conflits collectifs',
                'Sécurité sociale': 'Assurance maladie, accidents du travail, maladies professionnelles, prestations sociales',
                'Retraites': 'Régimes de retraite, pensions, réversion, rachats de trimestres',
                'Chômage et emploi': 'Assurance chômage, Pôle emploi, aides à l\'emploi, insertion professionnelle',
                'Handicap et insertion': 'Obligation d\'emploi, aménagements de postes, RQTH, insertion des personnes handicapées',
                'Protection sociale': 'Prestations familiales, RSA, aides sociales, protection universelle',
                'Égalité professionnelle': 'Égalité hommes-femmes, non-discrimination, diversité, harcèlement',
                'Création d\'entreprise': 'Statuts juridiques, formalités de création, aides à la création, régimes fiscaux',
                'Fiscalité des entreprises': 'Impôts sur les sociétés, TVA, taxes professionnelles, optimisation fiscale',
                'Droit commercial': 'Contrats commerciaux, vente, distribution, concurrence déloyale',
                'Propriété intellectuelle': 'Brevets, marques, droits d\'auteur, secrets d\'affaires, contrefaçon',
                'Concurrence et consommation': 'Pratiques anticoncurrentielles, protection des consommateurs, publicité',
                'Restructurations': 'Fusions-acquisitions, restructurations d\'entreprises, plans sociaux, liquidations'
            };

            // Génération de slug
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

            // Obtenir la description pour une suggestion
            function getDescription(nom) {
                return descriptions[nom] || '';
            }

            // Remplir le formulaire avec une suggestion
            function fillSuggestion(nom, description) {
                document.getElementById('nom').value = nom;
                document.getElementById('description').value = description;
                updatePreview();
                updateCharCount();
            }

            // Effacer le formulaire
            function clearForm() {
                document.getElementById('nom').value = '';
                document.getElementById('description').value = '';
                updatePreview();
                updateCharCount();
            }

            // Mettre à jour l'aperçu
            function updatePreview() {
                const nom = document.getElementById('nom').value;
                const description = document.getElementById('description').value;
                const slug = generateSlug(nom);

                document.getElementById('preview-nom').textContent = nom || 'Nom de la thématique';
                document.getElementById('preview-slug').innerHTML =
                    `slug: <code class="tw-bg-white tw-px-1 tw-py-0.5 tw-rounded">${slug || 'slug-automatique'}</code>`;

                const previewDesc = document.getElementById('preview-description');
                if (description) {
                    previewDesc.textContent = description;
                    previewDesc.classList.remove('tw-hidden');
                } else {
                    previewDesc.classList.add('tw-hidden');
                }

                // Afficher/masquer la section aperçu
                const previewSection = document.getElementById('preview-section');
                if (nom || description) {
                    previewSection.classList.remove('tw-hidden');
                } else {
                    previewSection.classList.add('tw-hidden');
                }

                // Mettre à jour le slug preview
                document.getElementById('slug-preview').textContent = slug || 'slug-automatique';
            }

            // Mettre à jour le compteur de caractères
            function updateCharCount() {
                const description = document.getElementById('description').value;
                const charCount = document.getElementById('char-count');
                charCount.textContent = description.length;

                // Couleurs selon la longueur
                if (description.length > 500) {
                    charCount.className = 'tw-text-red-600 tw-font-medium';
                } else if (description.length > 300) {
                    charCount.className = 'tw-text-yellow-600 tw-font-medium';
                } else {
                    charCount.className = '';
                }
            }

            // Event listeners
            document.getElementById('nom').addEventListener('input', updatePreview);
            document.getElementById('description').addEventListener('input', function() {
                updatePreview();
                updateCharCount();
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

            // Initialiser
            updateCharCount();
        </script>
    @endpush
@endsection
