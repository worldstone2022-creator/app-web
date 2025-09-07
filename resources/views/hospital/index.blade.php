@extends('layouts.app')

@section('content')
    <div class="tw-container tw-mx-auto tw-px-4 tw-py-6">
        
        <div class="tw-flex tw-justify-between tw-items-center tw-mb-6">
            <h1 class="tw-text-3xl tw-font-bold tw-text-gray-900">Médecine du Travail</h1>
            <a href="{{ route('medical-visits.create') }}"
                class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                Programmer une visite
            </a>
        </div>

        <!-- Statistiques -->
        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-6 tw-mb-6">

            <div class="tw-bg-white tw-p-6 tw-rounded-lg tw-shadow">
                <div class="tw-flex tw-items-center">
                    <div class="tw-p-3 tw-rounded-full tw-bg-blue-500 tw-bg-opacity-75">
                        <svg class="tw-w-8 tw-h-8 tw-text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <div class="tw-ml-5 tw-w-0 tw-flex-1">
                        <dl>
                            <dt class="tw-text-sm tw-font-medium tw-text-gray-500 tw-truncate">Total visites</dt>
                            <dd class="tw-text-lg tw-font-medium tw-text-gray-900">{{ $stats['total'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="tw-bg-white tw-p-6 tw-rounded-lg tw-shadow">
                <div class="tw-flex tw-items-center">
                    <div class="tw-p-3 tw-rounded-full tw-bg-yellow-500 tw-bg-opacity-75">
                        <svg class="tw-w-8 tw-h-8 tw-text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="tw-ml-5 tw-w-0 tw-flex-1">
                        <dl>
                            <dt class="tw-text-sm tw-font-medium tw-text-gray-500 tw-truncate">À venir</dt>
                            <dd class="tw-text-lg tw-font-medium tw-text-gray-900">{{ $stats['upcoming'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="tw-bg-white tw-p-6 tw-rounded-lg tw-shadow">
                <div class="tw-flex tw-items-center">
                    <div class="tw-p-3 tw-rounded-full tw-bg-red-500 tw-bg-opacity-75">
                        <svg class="tw-w-8 tw-h-8 tw-text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>
                    <div class="tw-ml-5 tw-w-0 tw-flex-1">
                        <dl>
                            <dt class="tw-text-sm tw-font-medium tw-text-gray-500 tw-truncate">En retard</dt>
                            <dd class="tw-text-lg tw-font-medium tw-text-gray-900">{{ $stats['overdue'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des visites -->
        <div class="tw-bg-white tw-shadow tw-overflow-hidden tw-sm:rounded-md">
            <div class="tw-px-4 tw-py-5 tw-sm:px-6">
                <h3 class="tw-text-lg tw-leading-6 tw-font-medium tw-text-gray-900">Visites médicales</h3>
            </div>
            <ul class="tw-divide-y tw-divide-gray-200">
                @forelse($medicalVisits as $visit)
            
                    <li class="tw-px-6 tw-py-4">
                        <div class="tw-flex tw-items-center tw-justify-between">
                            <div class="tw-flex tw-items-center">
                                <div class="tw-flex-shrink-0">
                                    <div
                                        class="tw-h-10 tw-w-10 tw-rounded-full tw-bg-gray-300 tw-flex tw-items-center tw-justify-center">
                                        <span class="tw-text-sm tw-font-medium tw-text-gray-700">
                                            {{ $visit->user? substr($visit->user->name, 0, 1) : 'Insconnu' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="tw-ml-4">
                                    <div class="tw-text-sm tw-font-medium tw-text-gray-900">
                                        {{ $visit->user?$visit->user->name: 'Insconnu' }}
                                    </div>
                                    <div class="tw-text-sm tw-text-gray-500">
                                        {{ $visit->visit_type }} - {{ $visit->doctor_name }}
                                    </div>
                                </div>
                            </div>
                            <div class="tw-flex tw-items-center tw-space-x-4">
                                <div class="tw-text-right">
                                    <div class="tw-text-sm tw-text-gray-900">
                                        {{ $visit->scheduled_date->format('d/m/Y') }}
                                    </div>
                                    <div class="tw-text-xs">
                                        @if ($visit->result === 'Apte')
                                            <span
                                                class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-green-100 tw-text-green-800">
                                                Apte
                                            </span>
                                        @elseif($visit->result === 'Inapte')
                                            <span
                                                class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-red-100 tw-text-red-800">
                                                Inapte
                                            </span>
                                        @else
                                            <span
                                                class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-gray-100 tw-text-gray-800">
                                                Non effectué
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="tw-flex tw-space-x-2">
                                    <a href="{{ route('medical-visits.show', $visit) }}"
                                        class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                        Voir
                                    </a>
                                    <a href="{{ route('medical-visits.edit', $visit) }}"
                                        class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                        Modifier
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tw-mt-2">
                            <p class="tw-text-sm tw-text-gray-600">{{ Str::limit($visit->visit_object, 100) }}</p>
                        </div>
                        {{-- @if ($visit && $visit->is_overdue)
                            <div class="tw-mt-2">
                                <span
                                    class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-red-100 tw-text-red-800">
                                    En retard de {{ abs($visit->days_until_visit) }} jour(s)
                                </span>
                            </div>
                        @endif --}}
                    </li>
                @empty
                    <li class="tw-px-6 tw-py-12 tw-text-center">
                        <svg class="tw-mx-auto tw-h-12 tw-w-12 tw-text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        <h3 class="tw-mt-2 tw-text-sm tw-font-medium tw-text-gray-900">Aucune visite médicale</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-gray-500">Commencez par programmer une visite médicale.</p>
                        <div class="tw-mt-6">
                            <a href="{{ route('medical-visits.create') }}"
                                class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                Programmer une visite
                            </a>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>

        <div class="tw-mt-6">
            {{ $medicalVisits->links() }}
        </div>
    </div>
@endsection
