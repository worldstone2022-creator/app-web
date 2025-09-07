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
                    <a href="{{ route('base-legal.sources.index') }}"
                        class="tw-ml-4 tw-text-sm tw-font-medium tw-text-gray-500 hover:tw-text-gray-700">Sources</a>
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

        <form action="{{ route('base-legal.sources.store') }}" method="POST" class="tw-space-y-6">
            @csrf

            <!-- Introduction et aide -->
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
                            Qu'est-ce qu'une source juridique ?
                        </h3>
                        <div class="tw-mt-2 tw-text-sm tw-text-blue-700">
                            <p class="tw-mb-2">Une source juridique est l'origine d'un texte de droit. Elle permet de
                                classer et d'identifier les documents selon leur autorité et leur portée :</p>
                            <ul class="tw-list-disc tw-list-inside tw-space-y-1">
                                <li><strong>Lois :</strong> Textes votés par le Parlement (codes, lois ordinaires...)</li>
                                <li><strong>Décrets :</strong> Textes pris par le pouvoir exécutif pour appliquer les lois
                                </li>
                                <li><strong>Conventions collectives :</strong> Accords négociés entre partenaires sociaux
                                </li>
                                <li><strong>Jurisprudence :</strong> Décisions de justice qui font référence</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire principal -->
            <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
                <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
                    <div class="md:tw-col-span-1">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Informations de la source</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                            Créez une nouvelle source pour identifier l'origine de vos documents juridiques.
                        </p>
                    </div>
                    <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                        <div class="tw-grid tw-grid-cols-6 tw-gap-6">
                            <!-- Type de source -->
                            <div class="tw-col-span-6">
                                <label for="type" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                    Type de source *
                                </label>
                                <select id="type" name="type" required onchange="updateTypeInfo()"
                                    class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                    <option value="">Sélectionner un type de source</option>
                                    @foreach ($types as $key => $label)
                                        <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror

                                <!-- Information sur le type sélectionné -->
                                <div id="type-info" class="tw-mt-3 tw-hidden">
                                    <div class="tw-bg-gray-50 tw-border tw-border-gray-200 tw-rounded-md tw-p-3">
                                        <div class="tw-flex tw-items-start">
                                            <div class="tw-flex-shrink-0">
                                                <svg id="type-icon" class="tw-h-5 tw-w-5 tw-text-gray-400" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div class="tw-ml-3 tw-flex-1">
                                                <h4 id="type-title" class="tw-text-sm tw-font-medium tw-text-gray-900"></h4>
                                                <p id="type-description" class="tw-mt-1 tw-text-sm tw-text-gray-600"></p>
                                                <p id="type-examples" class="tw-mt-2 tw-text-xs tw-text-gray-500"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nom de la source -->
                            <div class="tw-col-span-6">
                                <label for="nom" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700">
                                    Nom de la source *
                                </label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                                    class="tw-mt-1 focus:tw-ring-gray-500 focus:tw-border-gray-500 tw-block tw-w-full tw-shadow-sm sm:tw-text-sm tw-border-gray-300 tw-rounded-md tw-border tw-p-2"
                                    placeholder="Ex: Code du travail">
                                @error('nom')
                                    <p class="tw-mt-2 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror

                                <!-- Suggestions dynamiques -->
                                <div id="suggestions" class="tw-mt-2 tw-hidden">
                                    <p class="tw-text-sm tw-text-gray-600 tw-mb-2">Suggestions pour ce type :</p>
                                    <div id="suggestions-list" class="tw-flex tw-flex-wrap tw-gap-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aperçu de la source -->
            <div id="preview-section" class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6 tw-hidden">
                <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
                    <div class="md:tw-col-span-1">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Aperçu</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                            Voici comment apparaîtra votre source.
                        </p>
                    </div>
                    <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                        <div class="tw-border tw-border-gray-200 tw-rounded-lg tw-p-4 tw-bg-gray-50">
                            <div class="tw-flex tw-items-center tw-space-x-3">
                                <div
                                    class="tw-h-10 tw-w-10 tw-rounded-full tw-bg-gray-100 tw-flex tw-items-center tw-justify-center">
                                    <svg id="preview-icon" class="tw-h-6 tw-w-6 tw-text-gray-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="tw-flex-1">
                                    <div class="tw-flex tw-items-center tw-space-x-2 tw-mb-1">
                                        <span id="preview-badge"
                                            class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-gray-100 tw-text-gray-800">
                                            Type de source
                                        </span>
                                    </div>
                                    <h4 id="preview-nom" class="tw-text-lg tw-font-medium tw-text-gray-900">Nom de la
                                        source</h4>
                                    <p class="tw-text-xs tw-text-gray-400 tw-mt-1">0 document(s) associé(s)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sources existantes du même type -->
            <div id="existing-sources" class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6 tw-hidden">
                <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
                    <div class="md:tw-col-span-1">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Sources existantes</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                            Sources déjà créées de ce type dans votre base.
                        </p>
                    </div>
                    <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                        <div id="existing-sources-list" class="tw-space-y-2">
                            <!-- Liste générée dynamiquement -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guide des bonnes pratiques -->
            <div class="tw-bg-white tw-shadow tw-px-4 tw-py-5 sm:tw-rounded-lg sm:tw-p-6">
                <div class="md:tw-grid md:tw-grid-cols-3 md:tw-gap-6">
                    <div class="md:tw-col-span-1">
                        <h3 class="tw-text-lg tw-font-medium tw-leading-6 tw-text-gray-900">Bonnes pratiques</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">
                            Conseils pour bien nommer vos sources.
                        </p>
                    </div>
                    <div class="tw-mt-5 md:tw-mt-0 md:tw-col-span-2">
                        <div class="tw-space-y-4">
                            <div class="tw-flex tw-items-start">
                                <div class="tw-flex-shrink-0">
                                    <svg class="tw-h-5 tw-w-5 tw-text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="tw-ml-3">
                                    <h4 class="tw-text-sm tw-font-medium tw-text-gray-900">Noms recommandés</h4>
                                    <p class="tw-mt-1 tw-text-sm tw-text-gray-600">
                                        Utilisez des noms officiels et complets : "Code du travail", "Convention collective
                                        nationale du bâtiment", "Cour de cassation sociale"
                                    </p>
                                </div>
                            </div>

                            <div class="tw-flex tw-items-start">
                                <div class="tw-flex-shrink-0">
                                    <svg class="tw-h-5 tw-w-5 tw-text-yellow-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="tw-ml-3">
                                    <h4 class="tw-text-sm tw-font-medium tw-text-gray-900">Évitez les doublons</h4>
                                    <p class="tw-mt-1 tw-text-sm tw-text-gray-600">
                                        Vérifiez qu'une source similaire n'existe pas déjà. Les sources existantes du même
                                        type s'affichent automatiquement.
                                    </p>
                                </div>
                            </div>

                            <div class="tw-flex tw-items-start">
                                <div class="tw-flex-shrink-0">
                                    <svg class="tw-h-5 tw-w-5 tw-text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="tw-ml-3">
                                    <h4 class="tw-text-sm tw-font-medium tw-text-gray-900">Hiérarchie juridique</h4>
                                    <p class="tw-mt-1 tw-text-sm tw-text-gray-600">
                                        Respectez la hiérarchie : Constitution > Lois > Décrets > Arrêtés > Circulaires. Les
                                        conventions collectives et la jurisprudence ont leurs propres spécificités.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="tw-flex tw-justify-between tw-items-center tw-space-x-3">
                <div class="tw-flex tw-space-x-3">
                    <a href="{{ route('base-legal.sources.index') }}"
                        class="tw-bg-white tw-py-2 tw-px-4 tw-border tw-border-gray-300 tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-gray-500">
                        <svg class="tw-inline tw-h-4 tw-w-4 tw-mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour aux sources
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
                        Créer la source
                    </button>
                </div>
            </div>
        </form>

        @push('scripts')
            <script>
                // Données des types de sources
                const typesData = {
                    'loi': {
                        title: 'Loi',
                        description: 'Textes votés par le Parlement français (Assemblée nationale et Sénat). Ils ont une portée générale et s\'imposent à tous.',
                        examples: 'Exemples : Code du travail, Code civil, Code pénal, Loi sur les 35 heures',
                        suggestions: ['Code du travail', 'Code de la sécurité sociale', 'Code civil', 'Code pénal',
                            'Code de commerce'
                        ],
                        icon: 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z',
                        color: 'tw-bg-red-100 tw-text-red-800'
                    },
                    'decret': {
                        title: 'Décret',
                        description: 'Textes pris par le Président de la République ou le Premier ministre pour appliquer les lois. Ils précisent les modalités d\'application.',
                        examples: 'Exemples : Décrets d\'application du Code du travail, Décrets en Conseil d\'État',
                        suggestions: ['Décret sur le temps de travail', 'Décret relatif aux congés payés',
                            'Décret sur la formation professionnelle', 'Décret CHSCT'
                        ],
                        icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                        color: 'tw-bg-blue-100 tw-text-blue-800'
                    },
                    'convention_collective': {
                        title: 'Convention collective',
                        description: 'Accords négociés entre les représentants des employeurs et des salariés d\'une branche professionnelle. Elles complètent le Code du travail.',
                        examples: 'Exemples : CCN du bâtiment, CCN de la métallurgie, CCN du commerce',
                        suggestions: ['Convention collective nationale du bâtiment', 'Convention collective métallurgie',
                            'Convention collective commerce', 'Convention collective HCR', 'Convention collective transport'
                        ],
                        icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                        color: 'tw-bg-green-100 tw-text-green-800'
                    },
                    'jurisprudence': {
                        title: 'Jurisprudence',
                        description: 'Décisions rendues par les tribunaux et cours de justice qui font autorité et servent de référence pour l\'interprétation du droit.',
                        examples: 'Exemples : Arrêts de la Cour de cassation, du Conseil d\'État, des cours d\'appel',
                        suggestions: ['Cour de cassation sociale', 'Cour de cassation criminelle', 'Conseil d\'État',
                            'Cour d\'appel de Paris', 'Tribunal des conflits'
                        ],
                        icon: 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3',
                        color: 'tw-bg-purple-100 tw-text-purple-800'
                    },
                    'arrete': {
                        title: 'Arrêté',
                        description: 'Décisions prises par les ministres, préfets ou maires dans leur domaine de compétence. Ils ont une portée plus limitée que les décrets.',
                        examples: 'Exemples : Arrêtés ministériels, préfectoraux, municipaux',
                        suggestions: ['Arrêté ministériel', 'Arrêté préfectoral', 'Arrêté municipal', 'Arrêté DGT',
                            'Arrêté DIRECCTE'
                        ],
                        icon: 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z',
                        color: 'tw-bg-yellow-100 tw-text-yellow-800'
                    },
                    'circulaire': {
                        title: 'Circulaire',
                        description: 'Instructions données par l\'administration pour préciser l\'application des textes. Elles n\'ont pas de valeur juridique contraignante.',
                        examples: 'Exemples : Circulaires DGT, circulaires ministérielles, notes de service',
                        suggestions: ['Circulaire DGT', 'Circulaire ministérielle', 'Note de service', 'Instruction DGEFP',
                            'Circulaire URSSAF'
                        ],
                        icon: 'M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2',
                        color: 'tw-bg-gray-100 tw-text-gray-800'
                    }
                };

                // Sources existantes (à récupérer via AJAX en production)
                const existingSources = @json($sources ?? collect()) - > groupBy('type');

                // Mettre à jour les informations du type
                function updateTypeInfo() {
                    const typeSelect = document.getElementById('type');
                    const selectedType = typeSelect.value;
                    const typeInfo = document.getElementById('type-info');
                    const suggestions = document.getElementById('suggestions');
                    const existingSourcesSection = document.getElementById('existing-sources');

                    if (selectedType && typesData[selectedType]) {
                        const data = typesData[selectedType];

                        // Afficher les informations du type
                        document.getElementById('type-title').textContent = data.title;
                        document.getElementById('type-description').textContent = data.description;
                        document.getElementById('type-examples').textContent = data.examples;
                        document.getElementById('type-icon').innerHTML =
                            `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${data.icon}" />`;
                        typeInfo.classList.remove('tw-hidden');

                        // Afficher les suggestions
                        const suggestionsList = document.getElementById('suggestions-list');
                        suggestionsList.innerHTML = '';
                        data.suggestions.forEach(suggestion => {
                            const button = document.createElement('button');
                            button.type = 'button';
                            button.className =
                                'tw-inline-flex tw-items-center tw-px-3 tw-py-1 tw-rounded-full tw-text-xs tw-font-medium ' +
                                data.color + ' hover:tw-opacity-80 tw-cursor-pointer tw-transition-opacity';
                            button.textContent = suggestion;
                            button.onclick = () => fillSuggestion(suggestion);
                            suggestionsList.appendChild(button);
                        });
                        suggestions.classList.remove('tw-hidden');

                        // Afficher les sources existantes du même type
                        if (existingSources[selectedType] && existingSources[selectedType].length > 0) {
                            const existingList = document.getElementById('existing-sources-list');
                            existingList.innerHTML = '';
                            existingSources[selectedType].forEach(source => {
                                const div = document.createElement('div');
                                div.className =
                                    'tw-flex tw-items-center tw-justify-between tw-p-2 tw-bg-yellow-50 tw-border tw-border-yellow-200 tw-rounded-md';
                                div.innerHTML = `
                        <span class="tw-text-sm tw-text-gray-700">${source.nom}</span>
                        <span class="tw-text-xs tw-text-gray-500">${source.documents_count || 0} document(s)</span>
                    `;
                                existingList.appendChild(div);
                            });
                            existingSourcesSection.classList.remove('tw-hidden');
                        } else {
                            existingSourcesSection.classList.add('tw-hidden');
                        }

                        updatePreview();
                    } else {
                        typeInfo.classList.add('tw-hidden');
                        suggestions.classList.add('tw-hidden');
                        existingSourcesSection.classList.add('tw-hidden');
                    }
                }

                // Remplir le champ nom avec une suggestion
                function fillSuggestion(suggestion) {
                    document.getElementById('nom').value = suggestion;
                    updatePreview();
                }

                // Mettre à jour l'aperçu
                function updatePreview() {
                    const type = document.getElementById('type').value;
                    const nom = document.getElementById('nom').value;
                    const previewSection = document.getElementById('preview-section');

                    if (type && nom) {
                        const data = typesData[type];
                        if (data) {
                            document.getElementById('preview-badge').textContent = data.title;
                            document.getElementById('preview-badge').className =
                                'tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium ' +
                                data.color;
                            document.getElementById('preview-nom').textContent = nom;
                            document.getElementById('preview-icon').innerHTML =
                                `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${data.icon}" />`;
                            previewSection.classList.remove('tw-hidden');
                        }
                    } else {
                        previewSection.classList.add('tw-hidden');
                    }
                }

                // Effacer le formulaire
                function clearForm() {
                    document.getElementById('type').value = '';
                    document.getElementById('nom').value = '';
                    document.getElementById('type-info').classList.add('tw-hidden');
                    document.getElementById('suggestions').classList.add('tw-hidden');
                    document.getElementById('existing-sources').classList.add('tw-hidden');
                    document.getElementById('preview-section').classList.add('tw-hidden');
                }

                // Event listeners
                document.getElementById('nom').addEventListener('input', updatePreview);

                // Validation côté client
                document.querySelector('form').addEventListener('submit', function(e) {
                    const type = document.getElementById('type').value;
                    const nom = document.getElementById('nom').value.trim();

                    if (!type) {
                        e.preventDefault();
                        alert('Veuillez sélectionner un type de source.');
                        return false;
                    }

                    if (nom.length < 3) {
                        e.preventDefault();
                        alert('Le nom de la source doit contenir au moins 3 caractères.');
                        return false;
                    }

                    // Vérifier les doublons
                    if (existingSources[type]) {
                        const exists = existingSources[type].some(source =>
                            source.nom.toLowerCase() === nom.toLowerCase()
                        );
                        if (exists) {
                            const confirm = window.confirm(
                                'Une source avec ce nom existe déjà pour ce type. Voulez-vous continuer ?');
                            if (!confirm) {
                                e.preventDefault();
                                return false;
                            }
                        }
                    }
                });

                // Initialiser si des valeurs sont déjà sélectionnées (old values)
                document.addEventListener('DOMContentLoaded', function() {
                    const typeSelect = document.getElementById('type');
                    if (typeSelect.value) {
                        updateTypeInfo();
                    }
                });
            </script>
        @endpush

    </div>
@endsection
