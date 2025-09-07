{{-- resources/views/hr/job-offers/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="tw-min-h-screen tw-bg-gray-50 tw-py-8">
        <div class="tw-max-w-7xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
            {{-- En-tête --}}
            <div class="tw-mb-8">
                <div class="tw-flex tw-items-center tw-justify-between tw-mb-4">
                    <div class="tw-flex tw-items-center tw-space-x-4">
                        <a href="{{ route('job-offers.index') }}"
                            class="tw-text-gray-600 hover:tw-text-gray-900 tw-transition tw-duration-200">
                            <i class="fas fa-arrow-left tw-text-xl"></i>
                        </a>
                        <div>
                            <h1 class="tw-text-3xl tw-font-bold tw-text-gray-900">{{ $jobOffer->title }}</h1>
                            <p class="tw-mt-1 tw-text-gray-600">
                                {{ $jobOffer->department }} • {{ $jobOffer->location }}
                            </p>
                        </div>
                    </div>

                    <div class="tw-flex tw-items-center tw-space-x-3">
                        {{-- Statut --}}
                        @php
                            $statusClasses = [
                                'draft' => 'tw-bg-gray-100 tw-text-gray-800',
                                'active' => 'tw-bg-green-100 tw-text-green-800',
                                'paused' => 'tw-bg-yellow-100 tw-text-yellow-800',
                                'closed' => 'tw-bg-red-100 tw-text-red-800',
                            ];
                        @endphp
                        <span
                            class="tw-inline-flex tw-items-center tw-px-3 tw-py-1 tw-rounded-full tw-text-sm tw-font-medium {{ $statusClasses[$jobOffer->status] ?? 'tw-bg-gray-100 tw-text-gray-800' }}">
                            {{ ucfirst($jobOffer->status) }}
                        </span>

                        {{-- Actions de statut --}}
                        @if ($jobOffer->status === 'draft')
                            <form method="POST" action="{{ route('job-offers.publish', $jobOffer) }}" class="tw-inline">
                                @csrf
                                <button type="submit"
                                    class="tw-bg-green-500 hover:tw-bg-green-600 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                    <i class="fas fa-play tw-mr-2"></i>Publier
                                </button>
                            </form>
                        @elseif($jobOffer->status === 'active')
                            <form method="POST" action="{{ route('job-offers.close', $jobOffer) }}" class="tw-inline">
                                @csrf
                                <button type="submit"
                                    class="tw-bg-red-500 hover:tw-bg-red-600 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200"
                                    onclick="return confirm('Êtes-vous sûr de vouloir fermer cette offre ?')">
                                    <i class="fas fa-stop tw-mr-2"></i>Fermer
                                </button>
                            </form>
                        @endif

                        {{-- Bouton d'édition --}}
                        <a href="{{ route('job-offers.edit', $jobOffer) }}"
                            class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                            <i class="fas fa-edit tw-mr-2"></i>Modifier
                        </a>
                    </div>
                </div>
            </div>

            <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-8">
                {{-- Colonne principale --}}
                <div class="lg:tw-col-span-2 tw-space-y-8">
                    {{-- Informations de l'offre --}}
                    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                            <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900">Détails de l'Offre</h2>
                        </div>

                        <div class="tw-px-6 tw-py-6">
                            <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-6 tw-mb-6">
                                <div>
                                    <h3 class="tw-text-sm tw-font-medium tw-text-gray-500 tw-mb-1">Type de contrat</h3>
                                    <span
                                        class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-sm tw-font-medium tw-bg-orange-100 tw-text-orange-800">
                                        {{ $jobOffer->type }}
                                    </span>
                                </div>

                                <div>
                                    <h3 class="tw-text-sm tw-font-medium tw-text-gray-500 tw-mb-1">Postes disponibles</h3>
                                    <p class="tw-text-sm tw-text-gray-900">{{ $jobOffer->positions_available }}</p>
                                </div>

                                @if ($jobOffer->salary_range)
                                    <div>
                                        <h3 class="tw-text-sm tw-font-medium tw-text-gray-500 tw-mb-1">Salaire</h3>
                                        <p class="tw-text-sm tw-text-gray-900">{{ $jobOffer->salary_range }}</p>
                                    </div>
                                @endif

                                <div>
                                    <h3 class="tw-text-sm tw-font-medium tw-text-gray-500 tw-mb-1">Date limite</h3>
                                    <p class="tw-text-sm tw-text-gray-900">{{ $jobOffer->deadline->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <div class="tw-space-y-6">
                                <div>
                                    <h3 class="tw-text-lg tw-font-medium tw-text-gray-900 tw-mb-3">Description</h3>
                                    <div class="tw-text-gray-700 tw-whitespace-pre-line">{{ $jobOffer->description }}</div>
                                </div>

                                @if ($jobOffer->requirements)
                                    <div>
                                        <h3 class="tw-text-lg tw-font-medium tw-text-gray-900 tw-mb-3">Exigences</h3>
                                        <div class="tw-text-gray-700 tw-whitespace-pre-line">{{ $jobOffer->requirements }}
                                        </div>
                                    </div>
                                @endif

                                @if ($jobOffer->benefits)
                                    <div>
                                        <h3 class="tw-text-lg tw-font-medium tw-text-gray-900 tw-mb-3">Avantages</h3>
                                        <div class="tw-text-gray-700 tw-whitespace-pre-line">{{ $jobOffer->benefits }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Liste des candidatures --}}
                    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                            <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900">Candidatures</h2>
                        </div>

                        @if ($jobOffer->applications->count() > 0)
                            <div class="tw-overflow-x-auto">
                                <table class="tw-min-w-full tw-divide-y tw-divide-gray-200">
                                    <thead class="tw-bg-gray-50">
                                        <tr>
                                            <th
                                                class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                                Candidat
                                            </th>
                                            <th
                                                class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                                Statut
                                            </th>
                                            <th
                                                class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                                Date
                                            </th>
                                            <th
                                                class="tw-px-6 tw-py-3 tw-text-right tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="tw-bg-white tw-divide-y tw-divide-gray-200">
                                        @foreach ($jobOffer->applications as $application)
                                            <tr class="hover:tw-bg-gray-50">
                                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                                    <div class="tw-flex tw-items-center">
                                                        <div class="tw-flex-shrink-0 tw-h-10 tw-w-10">
                                                            <div
                                                                class="tw-h-10 tw-w-10 tw-rounded-full tw-bg-orange-100 tw-flex tw-items-center tw-justify-center">
                                                                <span class="tw-text-orange-600 tw-font-medium tw-text-sm">
                                                                    {{ substr($application->first_name, 0, 1) }}{{ substr($application->last_name, 0, 1) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="tw-ml-4">
                                                            <div class="tw-text-sm tw-font-medium tw-text-gray-900">
                                                                {{ $application->first_name }}
                                                                {{ $application->last_name }}
                                                            </div>
                                                            <div class="tw-text-sm tw-text-gray-500">
                                                                {{ $application->email }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                                    @php
                                                        $statusClasses = [
                                                            'pending' => 'tw-bg-yellow-100 tw-text-yellow-800',
                                                            'reviewing' => 'tw-bg-blue-100 tw-text-blue-800',
                                                            'shortlisted' => 'tw-bg-purple-100 tw-text-purple-800',
                                                            'interviewed' => 'tw-bg-indigo-100 tw-text-indigo-800',
                                                            'accepted' => 'tw-bg-green-100 tw-text-green-800',
                                                            'rejected' => 'tw-bg-red-100 tw-text-red-800',
                                                        ];
                                                    @endphp
                                                    <span
                                                        class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium {{ $statusClasses[$application->status] ?? 'tw-bg-gray-100 tw-text-gray-800' }}">
                                                        {{ ucfirst($application->status) }}
                                                    </span>
                                                </td>
                                                <td
                                                    class="tw-px-6 tw-py-4 tw-whitespace-nowrap tw-text-sm tw-text-gray-900">
                                                    {{ $application->created_at->format('d/m/Y') }}
                                                </td>
                                                <td
                                                    class="tw-px-6 tw-py-4 tw-whitespace-nowrap tw-text-right tw-text-sm tw-font-medium">
                                                   
                                                    <a href="{{ route('applications.show', $application) }}"
                                                        class="tw-text-orange-600 hover:tw-text-orange-900 tw-transition tw-duration-200"
                                                        title="Voir détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="tw-text-center tw-py-12">
                                <i class="fas fa-users tw-text-gray-400 tw-text-4xl tw-mb-4"></i>
                                <h3 class="tw-text-lg tw-font-medium tw-text-gray-900 tw-mb-2">Aucune candidature</h3>
                                <p class="tw-text-gray-500">Les candidatures apparaîtront ici une fois que l'offre sera
                                    publiée.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="tw-space-y-6">
                    {{-- Statistiques --}}
                    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                            <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Statistiques</h3>
                        </div>

                        <div class="tw-px-6 tw-py-6">
                            <div class="tw-space-y-4">
                                <div class="tw-flex tw-items-center tw-justify-between">
                                    <span class="tw-text-sm tw-text-gray-600">Total candidatures</span>
                                    <span
                                        class="tw-text-2xl tw-font-bold tw-text-orange-600">{{ $applicationStats['total'] }}</span>
                                </div>

                                <div class="tw-space-y-2">
                                    @foreach (['pending' => 'En attente', 'reviewing' => 'En cours', 'shortlisted' => 'Présélectionnés', 'interviewed' => 'Entretiens', 'accepted' => 'Acceptés', 'rejected' => 'Rejetés'] as $status => $label)
                                        @if ($applicationStats[$status] > 0)
                                            <div class="tw-flex tw-items-center tw-justify-between tw-text-sm">
                                                <span class="tw-text-gray-600">{{ $label }}</span>
                                                <span
                                                    class="tw-font-medium tw-text-gray-900">{{ $applicationStats[$status] }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Informations supplémentaires --}}
                    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                            <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Informations</h3>
                        </div>

                        <div class="tw-px-6 tw-py-6">
                            <div class="tw-space-y-4">
                                <div>
                                    <span class="tw-text-sm tw-text-gray-600">Créée le</span>
                                    <p class="tw-text-sm tw-font-medium tw-text-gray-900">
                                        {{ $jobOffer->created_at->format('d/m/Y à H:i') }}</p>
                                </div>

                                <div>
                                    <span class="tw-text-sm tw-text-gray-600">Créée par</span>
                                    <p class="tw-text-sm tw-font-medium tw-text-gray-900">
                                        {{ $jobOffer->creator->name ?? 'Utilisateur supprimé' }}</p>
                                </div>

                                <div>
                                    <span class="tw-text-sm tw-text-gray-600">Dernière modification</span>
                                    <p class="tw-text-sm tw-font-medium tw-text-gray-900">
                                        {{ $jobOffer->updated_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions rapides --}}
                    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                            <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Actions</h3>
                        </div>

                        <div class="tw-px-6 tw-py-6">
                            <div class="tw-space-y-3">
                                <a href="{{ route('job-offers.edit', $jobOffer) }}"
                                    class="tw-w-full tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 tw-text-center tw-block">
                                    <i class="fas fa-edit tw-mr-2"></i>Modifier l'offre
                                </a>

                                @if ($jobOffer->status === 'active')
                                    <a href="{{ route('public.job-offers.show', $jobOffer) }}" target="bank"
                                        class="tw-w-full tw-bg-gray-100 hover:tw-bg-gray-200 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 tw-text-center tw-block">
                                        <i class="fas fa-link tw-mr-2"></i>Lien public
                                    </a>
                                @endif

                                <form method="POST" action="{{ route('job-offers.destroy', $jobOffer) }}"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')"
                                    class="tw-w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="tw-w-full tw-bg-red-100 hover:tw-bg-red-200 tw-text-red-700 tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                        <i class="fas fa-trash tw-mr-2"></i>Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
