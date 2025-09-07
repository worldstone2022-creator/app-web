{{-- resources/views/hr/applications/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="tw-min-h-screen tw-bg-gray-50 tw-py-8">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
        {{-- En-tête --}}
         <div class="tw-mb-5">
            <a href="{{ route('hr.dashboard') }}" 
                   class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                    <i class="fas fa-arrow-left tw-mr-2"></i>
                    Tableau de bord récrutement 
                </a>
         </div>
        <div class="tw-mb-8">
            <div class="tw-flex tw-justify-between tw-items-center">
                <div>
                    <h1 class="tw-text-3xl tw-font-bold tw-text-gray-900">Gestion des Candidatures</h1>
                    <p class="tw-mt-2 tw-text-gray-600">Suivez et gérez toutes les candidatures reçues</p>
                </div>
                <div class="tw-flex tw-items-center tw-space-x-4">
                    <span class="tw-bg-orange-100 tw-text-orange-800 tw-px-4 tw-py-2 tw-rounded-lg tw-text-sm tw-font-medium">
                        {{ $applications->total() }} candidature(s)
                    </span>
                </div>
            </div>
        </div>

        {{-- Filtres --}}
        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-p-6 tw-mb-6">
            <form method="GET" action="{{ route('applications.index') }}" class="tw-space-y-4 lg:tw-space-y-0 lg:tw-flex lg:tw-items-end lg:tw-space-x-4">
                <div class="tw-flex-1">
                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Recherche</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Nom, prénom, email..."
                           class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                </div>
                
                <div class="tw-min-w-0 tw-flex-1">
                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Offre d'emploi</label>
                    <select name="job_offer_id" class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                        <option value="">Toutes les offres</option>
                        @foreach($jobOffers as $jobOffer)
                            <option value="{{ $jobOffer->id }}" {{ request('job_offer_id') == $jobOffer->id ? 'selected' : '' }}>
                                {{ $jobOffer->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="tw-min-w-0 tw-flex-1">
                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Statut</label>
                    <select name="status" class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                        <option value="">Tous les statuts</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="tw-min-w-0 tw-flex-1">
                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Évaluation min.</label>
                    <select name="rating" class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                        <option value="">Toutes</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                {{ $i }} étoile(s) et +
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="tw-flex tw-space-x-2">
                    <button type="submit" class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                        Filtrer
                    </button>
                    <a href="{{ route('applications.index') }}" class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-6 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>

        {{-- Statistiques rapides --}}
        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-5 tw-gap-4 tw-mb-6">
            @php
                $statusCounts = $applications->groupBy('status')->map->count();
                $statusLabels = [
                    'pending' => 'En attente',
                    'reviewing' => 'En cours',
                    'shortlisted' => 'Présélectionnés',
                    'interviewed' => 'Entretiens',
                    'accepted' => 'Acceptés'
                ];
            @endphp
            @foreach($statusLabels as $status => $label)
                <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-p-4">
                    <div class="tw-text-center">
                        <div class="tw-text-2xl tw-font-bold tw-text-orange-600">
                            {{ $statusCounts->get($status, 0) }}
                        </div>
                        <div class="tw-text-sm tw-text-gray-600">{{ $label }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Liste des candidatures --}}
        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
            @if($applications->count() > 0)
                <div class="tw-overflow-x-auto">
                    <table class="tw-min-w-full tw-divide-y tw-divide-gray-200">
                        <thead class="tw-bg-gray-50">
                            <tr>
                                <th class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Candidat
                                </th>
                                <th class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Offre
                                </th>
                                <th class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Statut
                                </th>
                                {{-- <th class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Évaluation
                                </th> --}}
                                <th class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Date
                                </th>
                                <th class="tw-px-6 tw-py-3 tw-text-right tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tw-bg-white tw-divide-y tw-divide-gray-200">
                            @foreach($applications as $application)
                                <tr class="hover:tw-bg-gray-50">
                                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                        <div class="tw-flex tw-items-center">
                                            <div class="tw-flex-shrink-0 tw-h-10 tw-w-10">
                                                <div class="tw-h-10 tw-w-10 tw-rounded-full tw-bg-orange-100 tw-flex tw-items-center tw-justify-center">
                                                    <span class="tw-text-orange-600 tw-font-medium tw-text-sm">
                                                        {{ substr($application->first_name, 0, 1) }}{{ substr($application->last_name, 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="tw-ml-4">
                                                <div class="tw-text-sm tw-font-medium tw-text-gray-900">
                                                    {{ $application->first_name }} {{ $application->last_name }}
                                                </div>
                                                <div class="tw-text-sm tw-text-gray-500">
                                                    {{ $application->email }}
                                                </div>
                                                @if($application->phone)
                                                    <div class="tw-text-xs tw-text-gray-400">
                                                        {{ $application->phone }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                        <div class="tw-text-sm tw-text-gray-900">{{ $application->jobOffer->title }}</div>
                                        <div class="tw-text-sm tw-text-gray-500">{{ $application->jobOffer->department }}</div>
                                    </td>
                                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
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
                                        <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium {{ $statusClasses[$application->status] ?? 'tw-bg-gray-100 tw-text-gray-800' }}">
                                            {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                        </span>
                                    </td>
                                    {{-- <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                        @if($application->rating)
                                            <div class="tw-flex tw-items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star tw-text-sm {{ $i <= $application->rating ? 'tw-text-orange-400' : 'tw-text-gray-300' }}"></i>
                                                @endfor
                                                <span class="tw-ml-2 tw-text-sm tw-text-gray-600">({{ $application->rating }})</span>
                                            </div>
                                        @else
                                            <span class="tw-text-sm tw-text-gray-400">Non évalué</span>
                                        @endif
                                    </td> --}}
                                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap tw-text-sm tw-text-gray-900">
                                        {{ $application->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap tw-text-right tw-text-sm tw-font-medium">
                                        <div class="tw-flex tw-items-center tw-justify-end tw-space-x-2">
                                            <a href="{{ route('applications.show', $application) }}" 
                                               class="tw-text-orange-600 hover:tw-text-orange-900 tw-transition tw-duration-200"
                                               title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($application->cv_path)
                                                <a href="{{ route('applications.download-cv', $application) }}" 
                                                   class="tw-text-blue-600 hover:tw-text-blue-900 tw-transition tw-duration-200"
                                                   title="Télécharger CV">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
                                            @if($application->linkedin_profile)
                                                <a href="{{ $application->linkedin_profile }}" target="_blank"
                                                   class="tw-text-blue-700 hover:tw-text-blue-900 tw-transition tw-duration-200"
                                                   title="Profil LinkedIn">
                                                    <i class="fab fa-linkedin"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="tw-px-6 tw-py-4 tw-border-t tw-border-gray-200">
                    {{ $applications->appends(request()->query())->links() }}
                </div>
            @else
                <div class="tw-text-center tw-py-12">
                    <i class="fas fa-users tw-text-gray-400 tw-text-6xl tw-mb-4"></i>
                    <h3 class="tw-text-lg tw-font-medium tw-text-gray-900 tw-mb-2">Aucune candidature</h3>
                    <p class="tw-text-gray-500 tw-mb-6">Les candidatures apparaîtront ici une fois que les offres seront publiées.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection