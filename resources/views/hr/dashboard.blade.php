{{-- resources/views/hr/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard RH')

@section('content')
    <div class="tw-container tw-mx-auto tw-px-4 tw-py-4">
        <!-- En-tête -->
        <div class="tw-flex tw-justify-between tw-items-center tw-mb-8 tw-pb-4 tw-border-b tw-border-gray-200">

            <div>
                <h1 class="tw-text-2xl tw-font-bold tw-text-gray-900">Tableau de bord récrutement</h1>
            </div>
            <div class="tw-flex tw-gap-3">
                <a href="{{ route('applications.index') }}"
                    class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">

                    Gestion des candidatures
                </a>
                <a href="{{ route('job-offers.index') }}"
                    class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">

                    Gestion des Offres d'Emploi
                </a>
                <a href="{{ route('job-offers.create') }}"
                    class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                    <i class="fas fa-plus tw-mr-2"></i>
                    Nouvelle Offre
                </a>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 xl:tw-grid-cols-4 tw-gap-4 tw-mb-4">
            <!-- Offres Actives -->
            <div class="tw-bg-white tw-p-3 tw-border-l-2 tw-border-blue-500 hover:tw-shadow-md tw-transition-shadow">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <div class="tw-text-xs tw-font-semibold tw-text-[#838383] tw-uppercase tw-tracking-wide tw-mb-1">
                            Offres Actives
                        </div>
                        <div class="tw-text-2xl tw-font-bold tw-text-gray-900">{{ $stats['active_jobs'] }}</div>
                    </div>
                    <div class="tw-bg-blue-100 tw-p-3 tw-rounded-full">
                        <i class="fas fa-briefcase tw-text-2xl tw-text-[#838383]"></i>
                    </div>
                </div>
            </div>

            <!-- Candidatures ce mois -->
            <div class="tw-bg-white tw-p-3 tw-border-l-2 tw-border-green-500 hover:tw-shadow-md tw-transition-shadow">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <div class="tw-text-xs tw-font-semibold tw-text-green-600 tw-uppercase tw-tracking-wide tw-mb-1">
                            Candidatures ce mois
                        </div>
                        <div class="tw-text-2xl tw-font-bold tw-text-gray-900">{{ $stats['applications_this_month'] }}</div>
                    </div>
                    <div class="tw-bg-green-100 tw-p-3 tw-rounded-full">
                        <i class="fas fa-user-plus tw-text-2xl tw-text-green-600"></i>
                    </div>
                </div>
            </div>

            <!-- Entretiens cette semaine -->
            <div class="tw-bg-white tw-p-3 tw-border-l-2 tw-border-purple-500 hover:tw-shadow-md tw-transition-shadow">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <div class="tw-text-xs tw-font-semibold tw-text-purple-600 tw-uppercase tw-tracking-wide tw-mb-1">
                            Entretiens cette semaine
                        </div>
                        <div class="tw-text-2xl tw-font-bold tw-text-gray-900">{{ $stats['interviews_this_week'] }}</div>
                    </div>
                    <div class="tw-bg-purple-100 tw-p-3 tw-rounded-full">
                        <i class="fas fa-calendar-check tw-text-2xl tw-text-purple-600"></i>
                    </div>
                </div>
            </div>

            <!-- Candidatures en attente -->
            <div class="tw-bg-white  tw-p-3 tw-border-l-2 tw-border-orange-500 hover:tw-shadow-md tw-transition-shadow">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <div class="tw-text-xs tw-font-semibold tw-text-orange-600 tw-uppercase tw-tracking-wide tw-mb-1">
                            Candidatures en attente
                        </div>
                        <div class="tw-text-2xl tw-font-bold tw-text-gray-900">{{ $stats['pending_applications'] }}</div>
                    </div>
                    <div class="tw-bg-orange-100 tw-p-3 tw-rounded-full">
                        <i class="fas fa-clock tw-text-2xl tw-text-orange-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="tw-grid tw-grid-cols-1 xl:tw-grid-cols-3 tw-gap-4 tw-mb-8">
            <!-- Graphique des candidatures -->
            <div class="xl:tw-col-span-2">
                <div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-overflow-hidden">
                    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200 tw-bg-gray-50">
                        <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900 tw-flex tw-items-center">
                            <i class="fas fa-chart-line tw-mr-2 tw-text-[#838383]"></i>
                            Évolution des candidatures
                        </h3>
                    </div>
                    <div class="tw-p-6">
                        <div class="tw-h-80">
                            <canvas id="applicationsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Répartition par statut -->
            <div class="xl:tw-col-span-1">
                <div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-overflow-hidden">
                    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200 tw-bg-gray-50">
                        <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900 tw-flex tw-items-center">
                            <i class="fas fa-chart-pie tw-mr-2 tw-text-purple-600"></i>
                            Candidatures par statut
                        </h3>
                    </div>
                    <div class="tw-p-6">
                        <div class="tw-h-80 tw-flex tw-items-center tw-justify-center">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Entretiens et Candidatures récentes -->
        <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-6 tw-mb-8">
            <!-- Entretiens à venir -->
            <div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-overflow-hidden">
                <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200 tw-bg-gray-50">
                    <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900 tw-flex tw-items-center">
                        <i class="fas fa-calendar-alt tw-mr-2 tw-text-green-600"></i>
                        Entretiens à venir
                    </h3>
                </div>
                <div class="tw-p-6">
                    @forelse($upcomingInterviews as $interview)
                        <div
                            class="tw-flex tw-items-center tw-p-4 tw-bg-gray-50 tw-rounded-lg tw-mb-4 hover:tw-bg-gray-100 tw-transition-colors">
                            <div class="tw-flex-shrink-0 tw-mr-4">
                                <div
                                    class="tw-w-10 tw-h-10 tw-bg-[#838383] tw-rounded-full tw-flex tw-items-center tw-justify-center">
                                    <i class="fas fa-calendar tw-text-white tw-text-sm"></i>
                                </div>
                            </div>
                            <div class="tw-flex-grow">
                                <div class="tw-text-sm tw-text-gray-500 tw-mb-1">
                                    {{ $interview->scheduled_at->format('d/m/Y H:i') }}
                                </div>
                                <div class="tw-font-semibold tw-text-gray-900">
                                    {{ $interview->application->full_name }}
                                </div>
                                <div class="tw-text-sm tw-text-gray-600">
                                    {{ $interview->application->jobOffer->title }}
                                </div>
                            </div>
                            <div class="tw-flex-shrink-0">
                                <span
                                    class="tw-px-3 tw-py-1 tw-text-xs tw-font-medium tw-rounded-full
                                {{ $interview->type == 'technical' ? 'tw-bg-orange-100 tw-text-orange-800' : 'tw-bg-blue-100 tw-text-blue-800' }}">
                                    {{ ucfirst($interview->type) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="tw-text-center tw-py-8">
                            <i class="fas fa-calendar-times tw-text-4xl tw-text-gray-300 tw-mb-3"></i>
                            <p class="tw-text-gray-500">Aucun entretien programmé</p>
                        </div>
                    @endforelse
                    <div class="tw-text-center tw-mt-4">
                        <a href="{{ route('interviews.index') }}"
                            class="tw-text-[#838383] hover:tw-text-blue-800 tw-font-medium tw-text-sm">
                            Voir tous les entretiens →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Candidatures récentes -->
            <div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-overflow-hidden">
                <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200 tw-bg-gray-50">
                    <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900 tw-flex tw-items-center">
                        <i class="fas fa-users tw-mr-2 tw-text-purple-600"></i>
                        Candidatures récentes
                    </h3>
                </div>
                <div class="tw-p-6">
                    @forelse($recentApplications as $application)
                        <div
                            class="tw-flex tw-items-center tw-p-4 tw-bg-gray-50 tw-rounded-lg tw-mb-4 hover:tw-bg-gray-100 tw-transition-colors">
                            <div class="tw-flex-shrink-0 tw-mr-4">
                                <div
                                    class="tw-w-10 tw-h-10 tw-bg-white tw-rounded-full tw-flex tw-items-center tw-justify-center">
                                    <i class="fas fa-user tw-text-white tw-text-sm"></i>
                                </div>
                            </div>
                            <div class="tw-flex-grow">
                                <div class="tw-font-semibold tw-text-gray-900">
                                    {{ $application->full_name }}
                                </div>
                                <div class="tw-text-sm tw-text-gray-600 tw-mb-1">
                                    {{ $application->jobOffer->title }}
                                </div>
                                <div class="tw-text-xs tw-text-gray-500">
                                    {{ $application->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <div class="tw-flex-shrink-0">
                                <span
                                    class="tw-px-3 tw-py-1 tw-text-xs tw-font-medium tw-rounded-full
                                @switch($application->status)
                                    @case('pending')
                                        tw-bg-yellow-100 tw-text-yellow-800
                                        @break
                                    @case('accepted')
                                        tw-bg-green-100 tw-text-green-800
                                        @break
                                    @case('rejected')
                                        tw-bg-red-100 tw-text-red-800
                                        @break
                                    @default
                                        tw-bg-blue-100 tw-text-blue-800
                                @endswitch">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="tw-text-center tw-py-8">
                            <i class="fas fa-user-slash tw-text-4xl tw-text-gray-300 tw-mb-3"></i>
                            <p class="tw-text-gray-500">Aucune candidature récente</p>
                        </div>
                    @endforelse
                    <div class="tw-text-center tw-mt-4">
                        <a href="{{ route('applications.index') }}"
                            class="tw-text-[#838383] hover:tw-text-blue-800 tw-font-medium tw-text-sm">
                            Voir toutes les candidatures →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Offres populaires -->
        <div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-overflow-hidden">
            <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200 tw-bg-gray-50">
                <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900 tw-flex tw-items-center">
                    <i class="fas fa-star tw-mr-2 tw-text-yellow-500"></i>
                    Offres les plus populaires
                </h3>
            </div>
            <div class="tw-overflow-x-auto">
                <table class="tw-w-full tw-divide-y tw-divide-gray-200">
                    <thead class="tw-bg-gray-50">
                        <tr>
                            <th
                                class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                Poste
                            </th>
                            <th
                                class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                Département
                            </th>
                            <th
                                class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                Type
                            </th>
                            <th
                                class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                Candidatures
                            </th>
                            <th
                                class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                Statut
                            </th>
                            <th
                                class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="tw-bg-white tw-divide-y tw-divide-gray-200">
                        @forelse($popularJobs as $job)
                            <tr class="hover:tw-bg-gray-50 tw-transition-colors">
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                    <div class="tw-text-sm tw-font-medium tw-text-gray-900">
                                        {{ $job->title }}
                                    </div>
                                </td>
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                    <div class="tw-text-sm tw-text-gray-600">
                                        {{ $job->department }}
                                    </div>
                                </td>
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                    <span
                                        class="tw-px-3 tw-py-1 tw-text-xs tw-font-medium tw-bg-blue-100 tw-text-blue-800 tw-rounded-full">
                                        {{ $job->type }}
                                    </span>
                                </td>
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                    <span
                                        class="tw-px-3 tw-py-1 tw-text-xs tw-font-medium tw-bg-purple-100 tw-text-purple-800 tw-rounded-full">
                                        {{ $job->applications_count }}
                                    </span>
                                </td>
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                    <span
                                        class="tw-px-3 tw-py-1 tw-text-xs tw-font-medium tw-rounded-full
                                    {{ $job->status == 'active' ? 'tw-bg-green-100 tw-text-green-800' : 'tw-bg-gray-100 tw-text-gray-800' }}">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </td>
                                <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap tw-text-sm tw-font-medium">
                                    <a href="{{ route('job-offers.show', $job) }}"
                                        class="tw-bg-gray-400 hover:tw-gray-orange-500 tw-text-white tw-px-2 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                        <i class="fas fa-eye tw-mr-1"></i>
                                        Voir
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="tw-px-6 tw-py-12 tw-text-center">
                                    <div class="tw-text-gray-500">
                                        <i class="fas fa-briefcase tw-text-4xl tw-mb-3 tw-block"></i>
                                        Aucune offre d'emploi
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts pour les graphiques -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Configuration des couleurs
        const colors = {
            primary: '#2563eb',
            success: '#059669',
            warning: '#d97706',
            danger: '#dc2626',
            info: '#7c3aed',
            gray: '#6b7280'
        };

        // Graphique des candidatures par mois
        const ctx1 = document.getElementById('applicationsChart').getContext('2d');
        const applicationsChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                datasets: [{
                    label: 'Candidatures',
                    data: @json(array_values($applicationsByMonth->toArray())),
                    borderColor: colors.primary,
                    backgroundColor: colors.primary + '20',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: colors.primary,
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: colors.gray
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        },
                        ticks: {
                            color: colors.gray
                        }
                    }
                }
            }
        });

        // Graphique des statuts (doughnut)
        const ctx2 = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: @json($applicationsByStatus->keys()),
                datasets: [{
                    data: @json($applicationsByStatus->values()),
                    backgroundColor: [
                        colors.warning,
                        colors.primary,
                        colors.success,
                        colors.info,
                        colors.danger,
                        colors.gray
                    ],
                    borderWidth: 0,
                    cutout: '60%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            color: colors.gray
                        }
                    }
                }
            }
        });
    </script>

@endsection
