{{-- resources/views/hr/interviews/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="tw-min-h-screen tw-bg-gray-50 tw-py-8">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
        {{-- En-tête --}}
        <div class="tw-mb-8">
            <div class="tw-flex tw-justify-between tw-items-center">
                <div>
                    <h1 class="tw-text-3xl tw-font-bold tw-text-gray-900">Gestion des Entretiens</h1>
                    <p class="tw-mt-2 tw-text-gray-600">Planifiez et suivez tous vos entretiens de recrutement</p>
                </div>
                <div class="tw-flex tw-items-center tw-space-x-4">
                   
                    <span class="tw-bg-orange-100 tw-text-orange-800 tw-px-4 tw-py-2 tw-rounded-lg tw-text-sm tw-font-medium">
                        {{ $interviews->total() }} entretien(s)
                    </span>
                </div>
            </div>
        </div>

        <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-4 tw-gap-8">
            {{-- Colonne principale --}}
            <div class="lg:tw-col-span-3 tw-space-y-6">
                {{-- Filtres --}}
                <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-p-6">
                    <form method="GET" action="{{ route('interviews.index') }}" class="tw-space-y-4 lg:tw-space-y-0 lg:tw-flex lg:tw-items-end lg:tw-space-x-4">
                        <div class="tw-flex-1">
                            <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Type d'entretien</label>
                            <select name="type" class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                <option value="">Tous les types</option>
                                <option value="phone" {{ request('type') == 'phone' ? 'selected' : '' }}>Téléphonique</option>
                                <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Visioconférence</option>
                                <option value="in_person" {{ request('type') == 'in_person' ? 'selected' : '' }}>En personne</option>
                                <option value="technical" {{ request('type') == 'technical' ? 'selected' : '' }}>Technique</option>
                            </select>
                        </div>

                        <div class="tw-flex-1">
                            <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Statut</label>
                            <select name="status" class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                <option value="">Tous les statuts</option>
                                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Programmé</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminé</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                                <option value="rescheduled" {{ request('status') == 'rescheduled' ? 'selected' : '' }}>Reporté</option>
                            </select>
                        </div>

                        <div class="tw-flex-1">
                            <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Date</label>
                            <input type="date" name="date" value="{{ request('date') }}" 
                                   class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                        </div>

                        <div class="tw-flex tw-space-x-2">
                            <button type="submit" class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                Filtrer
                            </button>
                            <a href="{{ route('interviews.index') }}" class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-6 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                {{-- Liste des entretiens --}}
                <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                    @if($interviews->count() > 0)
                        <div class="tw-overflow-x-auto">
                            <table class="tw-min-w-full tw-divide-y tw-divide-gray-200">
                                <thead class="tw-bg-gray-50">
                                    <tr>
                                        <th class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                            Candidat & Poste
                                        </th>
                                        <th class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                            Type & Date
                                        </th>
                                        <th class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                            Interviewer
                                        </th>
                                        <th class="tw-px-6 tw-py-3 tw-text-left tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                            Statut
                                        </th>
                                        <th class="tw-px-6 tw-py-3 tw-text-right tw-text-xs tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="tw-bg-white tw-divide-y tw-divide-gray-200">
                                    @foreach($interviews as $interview)
                                        <tr class="hover:tw-bg-gray-50">
                                            <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                                @if ($interview->application)
                                                    
                                               
                                                <div class="tw-flex tw-items-center">
                                                    <div class="tw-flex-shrink-0 tw-h-10 tw-w-10">
                                                        <div class="tw-h-10 tw-w-10 tw-rounded-full tw-bg-orange-100 tw-flex tw-items-center tw-justify-center">
                                                            <span class="tw-text-orange-600 tw-font-medium tw-text-sm">
                                                                {{ substr($interview->application->first_name, 0, 1) }}{{ substr($interview->application->last_name, 0, 1) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="tw-ml-4">
                                                        <div class="tw-text-sm tw-font-medium tw-text-gray-900">
                                                            {{ $interview->application->first_name }} {{ $interview->application->last_name }}
                                                        </div>
                                                        <div class="tw-text-sm tw-text-gray-500">
                                                            {{ $interview->application->jobOffer->title }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                    <div>
                                                        <span class="tw-text-sm tw-font-medium tw-text-gray-500">Candidat supprimé</span>
                                                    </div>
                                                 @endif
                                            </td>
                                            <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                                <div class="tw-text-sm tw-text-gray-900">
                                                    @php
                                                        $typeLabels = [
                                                            'phone' => 'Téléphonique',
                                                            'video' => 'Visioconférence',
                                                            'in_person' => 'En personne',
                                                            'technical' => 'Technique'
                                                        ];
                                                    @endphp
                                                    <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-blue-100 tw-text-blue-800">
                                                        {{ $typeLabels[$interview->type] ?? $interview->type }}
                                                    </span>
                                                </div>
                                                <div class="tw-text-sm tw-text-gray-500">
                                                    {{ $interview->scheduled_at->format('d/m/Y à H:i') }}
                                                </div>
                                                <div class="tw-text-xs tw-text-gray-400">
                                                    {{ $interview->duration_minutes }} min
                                                </div>
                                            </td>
                                            <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                                @if ($interview->interviewer)
                                                    
                                                
                                                <div class="tw-text-sm tw-font-medium tw-text-gray-900">
                                                    {{ $interview->interviewer->name }}
                                                </div>
                                                @if($interview->location)
                                                    <div class="tw-text-sm tw-text-gray-500">
                                                        {{ $interview->location }}
                                                    </div>
                                                @endif
                                                @else

                                                    <div>
                                                        <span class="tw-text-sm tw-font-medium tw-text-gray-500">Interviewer supprimé</span>
                                                    </div>

                                                @endif
                                            </td>
                                            <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                                                @php
                                                    $statusClasses = [
                                                        'scheduled' => 'tw-bg-yellow-100 tw-text-yellow-800',
                                                        'completed' => 'tw-bg-green-100 tw-text-green-800',
                                                        'cancelled' => 'tw-bg-red-100 tw-text-red-800',
                                                        'rescheduled' => 'tw-bg-blue-100 tw-text-blue-800',
                                                    ];
                                                    $statusLabels = [
                                                        'scheduled' => 'Programmé',
                                                        'completed' => 'Terminé',
                                                        'cancelled' => 'Annulé',
                                                        'rescheduled' => 'Reporté',
                                                    ];
                                                @endphp
                                                <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium {{ $statusClasses[$interview->status] ?? 'tw-bg-gray-100 tw-text-gray-800' }}">
                                                    {{ $statusLabels[$interview->status] ?? $interview->status }}
                                                </span>
                                            </td>
                                            <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap tw-text-right tw-text-sm tw-font-medium">
                                                 @if ($interview->application)
                                                <div class="tw-flex tw-items-center tw-justify-end tw-space-x-2">
                                                    <a href="{{ route('interviews.show', $interview) }}" 
                                                       class="tw-text-orange-600 hover:tw-text-orange-900 tw-transition tw-duration-200"
                                                       title="Voir détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('interviews.edit', $interview) }}" 
                                                       class="tw-text-gray-600 hover:tw-text-gray-900 tw-transition tw-duration-200"
                                                       title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if($interview->meeting_link)
                                                        <a href="{{ $interview->meeting_link }}" target="_blank"
                                                           class="tw-text-blue-600 hover:tw-text-blue-900 tw-transition tw-duration-200"
                                                           title="Rejoindre">
                                                            <i class="fas fa-video"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                                @else 
                                                     <span>
                                                        Aucune action disponible
                                                     </span>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="tw-px-6 tw-py-4 tw-border-t tw-border-gray-200">
                            {{ $interviews->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="tw-text-center tw-py-12">
                            <i class="fas fa-calendar-alt tw-text-gray-400 tw-text-6xl tw-mb-4"></i>
                            <h3 class="tw-text-lg tw-font-medium tw-text-gray-900 tw-mb-2">Aucun entretien</h3>
                            <p class="tw-text-gray-500 tw-mb-6">Les entretiens programmés apparaîtront ici.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar - Entretiens à venir --}}
            <div class="tw-space-y-6">
                {{-- Entretiens à venir --}}
                <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                        <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Prochains Entretiens</h3>
                    </div>
                    <div class="tw-px-6 tw-py-6">
                        @if($upcomingInterviews->count() > 0)
                            <div class="tw-space-y-4">
                                @foreach($upcomingInterviews as $upcoming)
                                    <div class="tw-border-l-4 tw-border-orange-400 tw-pl-4">
                                        <div class="tw-flex tw-items-center tw-justify-between">
                                            <div>
                                                <h4 class="tw-text-sm tw-font-medium tw-text-gray-900">
                                                    {{ $upcoming->application->first_name }} {{ $upcoming->application->last_name }}
                                                </h4>
                                                <p class="tw-text-xs tw-text-gray-500">
                                                    {{ $upcoming->scheduled_at->format('d/m H:i') }}
                                                </p>
                                                <p class="tw-text-xs tw-text-gray-400">
                                                    {{ $upcoming->duration_minutes }}min - {{ $upcoming->interviewer->name }}
                                                </p>
                                            </div>
                                            <a href="{{ route('interviews.show', $upcoming) }}" 
                                               class="tw-text-orange-600 hover:tw-text-orange-800 tw-transition tw-duration-200">
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="tw-text-sm tw-text-gray-500 tw-text-center tw-py-4">
                                Aucun entretien programmé dans les prochains jours
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Statistiques rapides --}}
                <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                        <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Statistiques</h3>
                    </div>
                    <div class="tw-px-6 tw-py-6">
                        @php
                            $stats = [
                                'scheduled' => $interviews->where('status', 'scheduled')->count(),
                                'completed' => $interviews->where('status', 'completed')->count(),
                                'cancelled' => $interviews->where('status', 'cancelled')->count(),
                            ];
                        @endphp
                        <div class="tw-space-y-4">
                            <div class="tw-flex tw-items-center tw-justify-between">
                                <span class="tw-text-sm tw-text-gray-600">Programmés</span>
                                <span class="tw-text-lg tw-font-bold tw-text-yellow-600">{{ $stats['scheduled'] }}</span>
                            </div>
                            <div class="tw-flex tw-items-center tw-justify-between">
                                <span class="tw-text-sm tw-text-gray-600">Terminés</span>
                                <span class="tw-text-lg tw-font-bold tw-text-green-600">{{ $stats['completed'] }}</span>
                            </div>
                            <div class="tw-flex tw-items-center tw-justify-between">
                                <span class="tw-text-sm tw-text-gray-600">Annulés</span>
                                <span class="tw-text-lg tw-font-bold tw-text-red-600">{{ $stats['cancelled'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection