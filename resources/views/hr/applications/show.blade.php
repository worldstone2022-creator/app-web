{{-- resources/views/hr/applications/show.blade.php --}}
@extends('layouts.app')

@section('content')

    <div class="tw-min-h-screen tw-bg-gray-50 tw-py-8">
        <div class="tw-max-w-7xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
            {{-- Navigation --}}
            <div class="tw-mb-8">
                <a href="{{ route('applications.index') }}"
                    class="tw-inline-flex tw-items-center tw-font-bold tw-text-base  hover:tw-text-orange-800 tw-transition tw-duration-200">
                    <i class="fas fa-arrow-left tw-mr-2"></i>
                    Retour aux candidatures
                </a>
            </div>



            {{-- En-tête candidat --}}
            <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden tw-mb-8">
                <div class="tw-bg-gradient-to-r tw-from-orange-400 tw-to-orange-600 tw-px-6 tw-py-8 tw-text-white">
                    <div class="tw-flex tw-items-start tw-justify-between">
                        <div class="tw-flex tw-items-center tw-space-x-6">
                            <div
                                class="tw-h-20 tw-w-20 tw-rounded-full tw-bg-white tw-bg-opacity-20 tw-flex tw-items-center tw-justify-center">
                                <span class="tw-text-3xl tw-font-bold tw-text-white">
                                    {{ substr($application->first_name, 0, 1) }}{{ substr($application->last_name, 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <h1 class="tw-text-3xl tw-font-bold tw-mb-2">
                                    {{ $application->first_name }} {{ $application->last_name }}
                                </h1>
                                <div class="tw-space-y-1 tw-text-orange-100">
                                    <p class="tw-flex tw-items-center">
                                        <i class="fas fa-envelope tw-mr-2"></i>
                                        {{ $application->email }}
                                    </p>
                                    @if ($application->phone)
                                        <p class="tw-flex tw-items-center">
                                            <i class="fas fa-phone tw-mr-2"></i>
                                            {{ $application->phone }}
                                        </p>
                                    @endif
                                    @if ($application->address)
                                        <p class="tw-flex tw-items-center">
                                            <i class="fas fa-map-marker-alt tw-mr-2"></i>
                                            {{ $application->address }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tw-text-right">
                            @php
                                $statusClasses = [
                                    'pending' => 'tw-bg-yellow-100 tw-text-yellow-800',
                                    'reviewing' => 'tw-bg-blue-100 tw-text-blue-800',
                                    'shortlisted' => 'tw-bg-purple-100 tw-text-purple-800',
                                    'interview_scheduled' => 'tw-bg-indigo-100 tw-text-indigo-800',
                                    'interviewed' => 'tw-bg-cyan-100 tw-text-cyan-800',
                                    'test_assigned' => 'tw-bg-orange-100 tw-text-orange-800',
                                    'test_completed' => 'tw-bg-green-100 tw-text-green-800',
                                    'accepted' => 'tw-bg-green-100 tw-text-green-800',
                                    'rejected' => 'tw-bg-red-100 tw-text-red-800',
                                ];
                            @endphp
                            <span
                                class="tw-inline-flex tw-items-center tw-px-3 tw-py-1 tw-rounded-full tw-text-sm tw-font-medium {{ $statusClasses[$application->status] ?? 'tw-bg-gray-100 tw-text-gray-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                            </span>
                            @if ($application->rating)
                                <div class="tw-flex tw-items-center tw-justify-end tw-mt-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="fas fa-star tw-text-sm {{ $i <= $application->rating ? 'tw-text-yellow-300' : 'tw-text-white tw-text-opacity-30' }}"></i>
                                    @endfor
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="tw-px-6 tw-py-4 tw-bg-orange-50 tw-border-b tw-border-orange-200">
                    <div class="tw-flex tw-items-center tw-justify-between">
                        <div>
                            <h3 class="tw-font-medium tw-text-orange-900">{{ $application->jobOffer->title }}</h3>
                            <p class="tw-text-sm tw-text-orange-700">{{ $application->jobOffer->department }}</p>
                        </div>
                        <div class="tw-text-right tw-text-sm tw-text-orange-700">
                            <p>Candidature du {{ $application->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-8">
                {{-- Contenu principal --}}
                <div class="lg:tw-col-span-2 tw-space-y-8">
                    {{-- Message de motivation --}}
                    @if ($application->message)
                        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                            <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                                <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900">Message de Motivation</h2>
                            </div>
                            <div class="tw-px-6 tw-py-6">
                                <div class="tw-prose tw-prose-gray tw-max-w-none">
                                    <p class="tw-text-gray-700 tw-whitespace-pre-line">{{ $application->message }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Expérience --}}
                    @if ($application->experience && count($application->experience) > 0)
                        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                            <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                                <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900">Expérience Professionnelle</h2>
                            </div>
                            <div class="tw-px-6 tw-py-6">
                                <div class="tw-space-y-6">
                                    @foreach ($application->experience as $exp)
                                        <div class="tw-border-l-4 tw-border-orange-200 tw-pl-4">
                                            <h3 class="tw-font-semibold tw-text-gray-900">{{ $exp['title'] ?? 'Poste' }}
                                            </h3>
                                            @if (isset($exp['company']))
                                                <p class="tw-text-orange-600 tw-font-medium">{{ $exp['company'] }}</p>
                                            @endif
                                            @if (isset($exp['duration']))
                                                <p class="tw-text-sm tw-text-gray-500 tw-mb-2">{{ $exp['duration'] }}</p>
                                            @endif
                                            @if (isset($exp['description']))
                                                <p class="tw-text-gray-700 tw-text-sm">{{ $exp['description'] }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Formation --}}
                    @if ($application->education && count($application->education) > 0)
                        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                            <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                                <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900">Formation</h2>
                            </div>
                            <div class="tw-px-6 tw-py-6">
                                <div class="tw-space-y-4">
                                    @foreach ($application->education as $edu)
                                        <div class="tw-border-l-4 tw-border-gray-200 tw-pl-4">
                                            <h3 class="tw-font-semibold tw-text-gray-900">{{ $edu['degree'] ?? 'Diplôme' }}
                                            </h3>
                                            @if (isset($edu['school']))
                                                <p class="tw-text-gray-600">{{ $edu['school'] }}</p>
                                            @endif
                                            @if (isset($edu['year']))
                                                <p class="tw-text-sm tw-text-gray-500">{{ $edu['year'] }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Workflow/Historique --}}
                    @if ($application->workflows && $application->workflows->count() > 0)
                        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                            <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                                <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900">Historique du Processus</h2>
                            </div>
                            <div class="tw-px-6 tw-py-6">
                                <div class="tw-flow-root">
                                    <ul class="-tw-mb-8">
                                        @foreach ($application->workflows->sortBy('created_at') as $workflow)
                                            <li class="tw-relative tw-pb-8">
                                                @if (!$loop->last)
                                                    <span
                                                        class="tw-absolute tw-top-4 tw-left-4 -tw-ml-px tw-h-full tw-w-0.5 tw-bg-gray-200"
                                                        aria-hidden="true"></span>
                                                @endif
                                                <div class="tw-relative tw-flex tw-space-x-3">
                                                    <div>
                                                        <span
                                                            class="tw-h-8 tw-w-8 tw-rounded-full tw-bg-orange-500 tw-flex tw-items-center tw-justify-center tw-ring-8 tw-ring-white">
                                                            <i class="fas fa-check tw-text-white tw-text-xs"></i>
                                                        </span>
                                                    </div>
                                                    <div
                                                        class="tw-min-w-0 tw-flex-1 tw-pt-1.5 tw-flex tw-justify-between tw-space-x-4">
                                                        <div>
                                                            <p class="tw-text-sm tw-font-medium tw-text-gray-900">
                                                                {{ $workflow->stage }}</p>
                                                            @if ($workflow->description)
                                                                <p class="tw-text-sm tw-text-gray-500">
                                                                    {{ $workflow->description }}</p>
                                                            @endif
                                                            @if ($workflow->notes)
                                                                <p class="tw-text-sm tw-text-gray-600 tw-mt-1 tw-italic">
                                                                    {{ $workflow->notes }}</p>
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="tw-text-right tw-text-sm tw-whitespace-nowrap tw-text-gray-500">
                                                            <time>{{ $workflow->completed_at ? $workflow->completed_at->format('d/m/Y H:i') : $workflow->created_at->format('d/m/Y H:i') }}</time>
                                                            @if ($workflow->assignedUser)
                                                                <p class="tw-text-xs">{{ $workflow->assignedUser->name }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="tw-space-y-6">
                    {{-- Actions rapides --}}
                    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                            <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Actions</h3>
                        </div>
                        <div class="tw-px-6 tw-py-6">
                            <div class="tw-space-y-3">
                                <div class="tw-space-y-3">
                                    @if ($application->status === 'shortlisted' || $application->status === 'reviewing')
                                        <a href="{{ route('interviews.create', $application) }}"
                                            class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-2 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 tw-text-center tw-block">
                                            <i class="fas fa-calendar-plus tw-mr-2"></i>Planifier un entretien
                                        </a>
                                    @endif
                                </div>
                                {{-- Mise à jour du statut --}}
                                <form method="POST" action="{{ route('applications.update-status', $application) }}"
                                    class="tw-space-y-3">
                                    @csrf
                                    <div>
                                        <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                            Changer le statut
                                        </label>
                                        <select name="status"
                                            class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 tw-text-sm">
                                            @php
                                                $statuses = [
                                                    'pending' => 'En attente',
                                                    'reviewing' => 'En cours d\'examen',
                                                    'shortlisted' => 'Présélectionné',
                                                    'interview_scheduled' => 'Entretien programmé',
                                                    'interviewed' => 'Entretien réalisé',
                                                    'test_assigned' => 'Test assigné',
                                                    'test_completed' => 'Test complété',
                                                    'accepted' => 'Accepté',
                                                    'rejected' => 'Rejeté',
                                                ];
                                            @endphp
                                            @foreach ($statuses as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ $application->status == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                            Notes (optionnel)
                                        </label>
                                        <textarea name="notes" rows="3"
                                            class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 tw-text-sm"
                                            placeholder="Ajouter des notes..."></textarea>
                                    </div>
                                    <button type="submit"
                                        class="tw-w-full tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 tw-text-sm">
                                        <i class="fas fa-save tw-mr-2"></i>Mettre à jour
                                    </button>
                                </form>

                                <hr class="tw-my-4">

                                {{-- Évaluation --}}
                                {{-- <form method="POST" action="{{ route('applications.update-rating', $application) }}"
                                    class="tw-space-y-3">
                                    @csrf
                                    <div>
                                        <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                            Évaluation
                                        </label>
                                        <div class="tw-flex tw-items-center tw-space-x-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <button type="button"
                                                    class="rating-star tw-text-lg tw-transition tw-duration-200 p-1   {{ $application->rating && $i <= $application->rating ? 'tw-bg-orange-100 hover:tw-bg-orange-300' : 'tw-text-gray-100 hover:tw-bg-orange-300' }}"
                                                    data-rating="{{ $i }}">
                                                    <i class="fas fa-star"></i>
                                                </button>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rating" value="{{ $application->rating ?? 0 }}"
                                            id="rating-input">
                                    </div>
                                    <div>
                                        <textarea name="notes" rows="2"
                                            class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 tw-text-sm"
                                            placeholder="Commentaires sur l'évaluation...">{{ $application->notes ?? '' }}</textarea>
                                    </div>
                                    <button type="submit"
                                        class="tw-w-full tw-bg-blue-500 hover:tw-bg-blue-600 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 tw-text-sm">
                                        <i class="fas fa-star tw-mr-2"></i>Évaluer
                                    </button>
                                </form> --}}
                            </div>
                        </div>
                    </div>

                    {{-- Documents --}}
                    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                            <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Documents</h3>
                        </div>
                        <div class="tw-px-6 tw-py-6">
                            <div class="tw-space-y-3">
                                @if ($application->cv_path)
                                    <a href="{{ route('applications.download-cv', $application) }}"
                                        class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-border tw-border-gray-200 tw-rounded-lg hover:tw-bg-gray-50 tw-transition tw-duration-200">
                                        <div class="tw-flex tw-items-center">
                                            <i class="fas fa-file-pdf tw-text-red-500 tw-mr-3"></i>
                                            <span class="tw-text-sm tw-font-medium tw-text-gray-900">CV</span>
                                        </div>
                                        <i class="fas fa-download tw-text-gray-400"></i>
                                    </a>
                                @endif

                                @if ($application->cover_letter_path)
                                    <a href="{{ route('applications.download-cover-letter', $application) }}"
                                        class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-border tw-border-gray-200 tw-rounded-lg hover:tw-bg-gray-50 tw-transition tw-duration-200">
                                        <div class="tw-flex tw-items-center">
                                            <i class="fas fa-file-alt tw-text-blue-500 tw-mr-3"></i>
                                            <span class="tw-text-sm tw-font-medium tw-text-gray-900">Lettre de
                                                motivation</span>
                                        </div>
                                        <i class="fas fa-download tw-text-gray-400"></i>
                                    </a>
                                @endif

                                @if (!$application->cv_path && !$application->cover_letter_path)
                                    <p class="tw-text-sm tw-text-gray-500 tw-text-center tw-py-4">Aucun document disponible
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Liens externes --}}
                    @if ($application->linkedin_profile || $application->portfolio_url)
                        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                            <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                                <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Liens</h3>
                            </div>
                            <div class="tw-px-6 tw-py-6">
                                <div class="tw-space-y-3">
                                    @if ($application->linkedin_profile)
                                        <a href="{{ $application->linkedin_profile }}" target="_blank"
                                            class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-border tw-border-gray-200 tw-rounded-lg hover:tw-bg-gray-50 tw-transition tw-duration-200">
                                            <div class="tw-flex tw-items-center">
                                                <i class="fab fa-linkedin tw-text-blue-600 tw-mr-3"></i>
                                                <span class="tw-text-sm tw-font-medium tw-text-gray-900">LinkedIn</span>
                                            </div>
                                            <i class="fas fa-external-link-alt tw-text-gray-400"></i>
                                        </a>
                                    @endif

                                    @if ($application->portfolio_url)
                                        <a href="{{ $application->portfolio_url }}" target="_blank"
                                            class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-border tw-border-gray-200 tw-rounded-lg hover:tw-bg-gray-50 tw-transition tw-duration-200">
                                            <div class="tw-flex tw-items-center">
                                                <i class="fas fa-globe tw-text-green-500 tw-mr-3"></i>
                                                <span class="tw-text-sm tw-font-medium tw-text-gray-900">Portfolio</span>
                                            </div>
                                            <i class="fas fa-external-link-alt tw-text-gray-400"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Compétences --}}
                    @if ($application->skills && count($application->skills) > 0)
                        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                            <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                                <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Compétences</h3>
                            </div>
                            <div class="tw-px-6 tw-py-6">
                                <div class="tw-flex tw-flex-wrap tw-gap-2">
                                    @foreach ($application->skills as $skill)
                                        <span
                                            class="tw-inline-flex tw-items-center tw-px-3 tw-py-1 tw-rounded-full tw-text-xs tw-font-medium tw-bg-orange-100 tw-text-orange-800">
                                            {{ is_array($skill) ? $skill['name'] ?? $skill : $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Informations supplémentaires --}}
                    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                            <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Informations</h3>
                        </div>
                        <div class="tw-px-6 tw-py-6">
                            <div class="tw-space-y-4 tw-text-sm">
                                <div>
                                    <span class="tw-font-medium tw-text-gray-700">Candidature reçue</span>
                                    <p class="tw-text-gray-600">{{ $application->created_at->format('d/m/Y à H:i') }}</p>
                                </div>
                                @if ($application->updated_at != $application->created_at)
                                    <div>
                                        <span class="tw-font-medium tw-text-gray-700">Dernière mise à jour</span>
                                        <p class="tw-text-gray-600">{{ $application->updated_at->format('d/m/Y à H:i') }}
                                        </p>
                                    </div>
                                @endif
                                <div>
                                    <span class="tw-font-medium tw-text-gray-700">Offre</span>
                                    <p class="tw-text-gray-600">{{ $application->jobOffer->title }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript pour l'évaluation par étoiles --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.rating-star');
            const ratingInput = document.getElementById('rating-input');

            stars.forEach((star, index) => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    ratingInput.value = rating;

                    // Update visual state
                    stars.forEach((s, i) => {
                        if (i < rating) {
                            s.classList.remove('tw-text-gray-300');
                            s.classList.add('tw-text-orange-400');
                        } else {
                            s.classList.remove('tw-text-orange-400');
                            s.classList.add('tw-text-gray-300');
                        }
                    });
                });

                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);

                    stars.forEach((s, i) => {
                        if (i < rating) {
                            s.classList.add('tw-text-orange-300');
                        } else {
                            s.classList.remove('tw-text-orange-300');
                        }
                    });
                });
            });

            document.addEventListener('mouseleave', function() {
                const currentRating = parseInt(ratingInput.value);

                stars.forEach((s, i) => {
                    s.classList.remove('tw-text-orange-300');
                    if (i < currentRating) {
                        s.classList.add('tw-text-orange-400');
                    }
                });
            });
        });
    </script>

@endsection
