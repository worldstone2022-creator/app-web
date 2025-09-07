{{-- resources/views/hr/job-offers/index.blade.php --}}
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
                    <h1 class="tw-text-3xl tw-font-bold tw-text-gray-900">Gestion des Offres d'Emploi</h1>
                    <p class="tw-mt-2 tw-text-gray-600">Gérez vos offres d'emploi et suivez les candidatures</p>
                </div>
                <a href="{{ route('job-offers.create') }}" 
                   class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 tw-shadow-sm hover:tw-shadow-md">
                    <i class="fas fa-plus tw-mr-2"></i>
                    Nouvelle Offre
                </a>
            </div>
        </div>

        {{-- Filtres --}}
        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-p-6 tw-mb-6">
            <form method="GET" action="{{ route('job-offers.index') }}" class="tw-space-y-4 lg:tw-space-y-0 lg:tw-flex lg:tw-items-end lg:tw-space-x-4">
                <div class="tw-flex-1">
                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Recherche</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Titre, description..."
                           class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                </div>
                 
                <div class="tw-min-w-0 tw-flex-1">
                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Département</label>
                    <select name="department" class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                        <option value="">Tous les départements</option>
                        @foreach($departments as $department)
                            <option value="{{ $department }}" {{ request('department') == $department ? 'selected' : '' }}>
                                {{ $department }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="tw-min-w-0 tw-flex-1">
                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Type</label>
                    <select name="type" class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                        <option value="">Tous les types</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="tw-min-w-0 tw-flex-1">
                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Statut</label>
                    <select name="status" class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                        <option value="">Tous les statuts</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="paused" {{ request('status') == 'paused' ? 'selected' : '' }}>Pausée</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Fermée</option>
                    </select>
                </div>

                <div class="tw-flex tw-space-x-2">
                    <button type="submit" class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                        Filtrer
                    </button>
                    <a href="{{ route('job-offers.index') }}" class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-6 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Liste des offres --}}
        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
            @if($jobOffers->count() > 0)
                <div class="tw-overflow-x-auto">
                    <table class="tw-min-w-full tw-divide-y tw-divide-gray-200">
                        <thead class="tw-bg-gray-50">
                            <tr>
                                <th class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Offre
                                </th>
                                <th class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Département
                                </th>
                                <th class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Type
                                </th>
                                <th class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Statut
                                </th>
                                <th class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Candidatures
                                </th>
                                <th class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Date limite
                                </th>
                                <th class="tw-px-6 tw-py-3 tw-text-right tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tw-bg-white tw-divide-y tw-divide-gray-200">
                            @foreach($jobOffers as $jobOffer)
                                <tr class="hover:tw-bg-gray-50">
                                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                        <div class="tw-flex tw-items-center">
                                            <div>
                                                <div class="tw-text-sm tw-font-medium tw-text-gray-900">
                                                    {{ $jobOffer->title }}
                                                </div>
                                                <div class="tw-text-sm tw-text-gray-500">
                                                    {{ $jobOffer->location }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap tw-text-sm tw-text-gray-900">
                                        {{ $jobOffer->department }}
                                    </td>
                                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                        <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-orange-100 tw-text-orange-800">
                                            {{ $jobOffer->type }}
                                        </span>
                                    </td>
                                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                        @php
                                            $statusClasses = [
                                                'draft' => 'tw-bg-gray-100 tw-text-gray-800',
                                                'active' => 'tw-bg-green-100 tw-text-green-800',
                                                'paused' => 'tw-bg-yellow-100 tw-text-yellow-800',
                                                'closed' => 'tw-bg-red-100 tw-text-red-800',
                                            ];
                                        @endphp
                                        <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium {{ $statusClasses[$jobOffer->status] ?? 'tw-bg-gray-100 tw-text-gray-800' }}">
                                            {{ ucfirst($jobOffer->status) }}
                                        </span>
                                    </td>
                                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap tw-text-sm tw-text-gray-900">
                                        <span class="tw-bg-orange-100 tw-text-orange-800 tw-px-2 tw-py-1 tw-rounded-full tw-text-xs tw-font-medium">
                                            {{ $jobOffer->applications->count() }} candidatures
                                        </span>
                                    </td>
                                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap tw-text-sm tw-text-gray-900">
                                        {{ $jobOffer->deadline->format('d/m/Y') }}
                                    </td>
                                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap tw-text-right tw-text-sm tw-font-medium">
                                        <div class="tw-flex tw-items-center tw-justify-end tw-space-x-2">
                                            <a href="{{ route('job-offers.show', $jobOffer) }}" 
                                               class="tw-text-orange-600 hover:tw-text-orange-900 tw-transition tw-duration-200">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('job-offers.edit', $jobOffer) }}" 
                                               class="tw-text-gray-600 hover:tw-text-gray-900 tw-transition tw-duration-200">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('job-offers.destroy', $jobOffer) }}" 
                                                  class="tw-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="tw-text-red-600 hover:tw-text-red-900 tw-transition tw-duration-200">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="tw-px-6 tw-py-4 tw-border-t tw-border-gray-200">
                    {{ $jobOffers->appends(request()->query())->links() }}
                </div>
            @else
                <div class="tw-text-center tw-py-12">
                    <i class="fas fa-briefcase tw-text-gray-400 tw-text-6xl tw-mb-4"></i>
                    <h3 class="tw-text-lg tw-font-medium tw-text-gray-900 tw-mb-2">Aucune offre d'emploi</h3>
                    <p class="tw-text-gray-500 tw-mb-6">Commencez par créer votre première offre d'emploi.</p>
                    <a href="{{ route('job-offers.create') }}" 
                       class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                        Créer une offre
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection