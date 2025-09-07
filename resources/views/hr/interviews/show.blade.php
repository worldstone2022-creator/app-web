{{-- resources/views/hr/interviews/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="tw-min-h-screen tw-bg-gray-50 tw-py-8">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
        {{-- Navigation --}}
        <div class="tw-mb-8">
            <a href="{{ route('interviews.index') }}" 
               class="tw-inline-flex tw-items-center tw-text-orange-600 hover:tw-text-orange-800 tw-transition tw-duration-200">
                <i class="fas fa-arrow-left tw-mr-2"></i>
                Retour aux entretiens
            </a>
        </div>

        {{-- En-tête entretien --}}
        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden tw-mb-8">
            <div class="tw-bg-gradient-to-r tw-from-orange-400 tw-to-orange-600 tw-px-6 tw-py-8 tw-text-white">
                <div class="tw-flex tw-items-start tw-justify-between">
                    <div class="tw-flex tw-items-center tw-space-x-6">
                        <div class="tw-h-20 tw-w-20 tw-rounded-full tw-bg-white tw-bg-opacity-20 tw-flex tw-items-center tw-justify-center">
                            <span class="tw-text-3xl tw-font-bold tw-text-white">
                                {{ substr($interview->application->first_name, 0, 1) }}{{ substr($interview->application->last_name, 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <h1 class="tw-text-3xl tw-font-bold tw-mb-2">
                                Entretien - {{ $interview->application->first_name }} {{ $interview->application->last_name }}
                            </h1>
                            <div class="tw-space-y-1 tw-text-orange-100">
                                <p class="tw-flex tw-items-center">
                                    <i class="fas fa-briefcase tw-mr-2"></i>
                                    {{ $interview->application->jobOffer->title }}
                                </p>
                                <p class="tw-flex tw-items-center">
                                    <i class="fas fa-calendar tw-mr-2"></i>
                                    {{ $interview->scheduled_at->format('d/m/Y à H:i') }}
                                </p>
                                <p class="tw-flex tw-items-center">
                                    <i class="fas fa-clock tw-mr-2"></i>
                                    {{ $interview->duration_minutes }} minutes
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tw-text-right">
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
                        <span class="tw-inline-flex tw-items-center tw-px-3 tw-py-1 tw-rounded-full tw-text-sm tw-font-medium {{ $statusClasses[$interview->status] ?? 'tw-bg-gray-100 tw-text-gray-800' }}">
                            {{ $statusLabels[$interview->status] ?? $interview->status }}
                        </span>
                        
                        @if($interview->rating)
                            <div class="tw-flex tw-items-center tw-justify-end tw-mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star tw-text-sm {{ $i <= $interview->rating ? 'tw-text-yellow-300' : 'tw-text-white tw-text-opacity-30' }}"></i>
                                @endfor
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="tw-px-6 tw-py-4 tw-bg-orange-50 tw-border-b tw-border-orange-200">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div class="tw-flex tw-items-center tw-space-x-6">
                        @php
                            $typeLabels = [
                                'phone' => 'Téléphonique',
                                'video' => 'Visioconférence',
                                'in_person' => 'En personne',
                                'technical' => 'Technique'
                            ];
                        @endphp
                        <span class="tw-inline-flex tw-items-center tw-px-3 tw-py-1 tw-rounded-full tw-text-sm tw-font-medium tw-bg-blue-100 tw-text-blue-800">
                            {{ $typeLabels[$interview->type] ?? $interview->type }}
                        </span>
                        
                        <span class="tw-text-sm tw-text-orange-700">
                            <i class="fas fa-user tw-mr-2"></i>
                            Interviewer: {{ $interview->interviewer->name }}
                        </span>
                    </div>
                    
                    <div class="tw-flex tw-items-center tw-space-x-3">
                        @if($interview->meeting_link)
                            <a href="{{ $interview->meeting_link }}" target="_blank"
                               class="tw-bg-blue-500 hover:tw-bg-blue-600 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                <i class="fas fa-video tw-mr-2"></i>Rejoindre
                            </a>
                        @endif
                        
                        <a href="{{ route('interviews.edit', $interview) }}" 
                           class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                            <i class="fas fa-edit tw-mr-2"></i>Modifier
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-8">
            {{-- Contenu principal --}}
            <div class="lg:tw-col-span-2 tw-space-y-8">
                {{-- Détails de l'entretien --}}
                <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900">Détails de l'Entretien</h2>
                    </div>
                    
                    <div class="tw-px-6 tw-py-6">
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-6 tw-mb-6">
                            <div>
                                <h3 class="tw-text-sm tw-font-medium tw-text-gray-500 tw-mb-1">Date et heure</h3>
                                <p class="tw-text-sm tw-text-gray-900">{{ $interview->scheduled_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            
                            <div>
                                <h3 class="tw-text-sm tw-font-medium tw-text-gray-500 tw-mb-1">Durée</h3>
                                <p class="tw-text-sm tw-text-gray-900">{{ $interview->duration_minutes }} minutes</p>
                            </div>
                            
                            @if($interview->location)
                            <div>
                                <h3 class="tw-text-sm tw-font-medium tw-text-gray-500 tw-mb-1">Lieu</h3>
                                <p class="tw-text-sm tw-text-gray-900">{{ $interview->location }}</p>
                            </div>
                            @endif
                            
                            <div>
                                <h3 class="tw-text-sm tw-font-medium tw-text-gray-500 tw-mb-1">Interviewer principal</h3>
                                <p class="tw-text-sm tw-text-gray-900">{{ $interview->interviewer->name }}</p>
                            </div>
                        </div>

                        @if($interview->agenda)
                        <div class="tw-mb-6">
                            <h3 class="tw-text-lg tw-font-medium tw-text-gray-900 tw-mb-3">Agenda</h3>
                            <div class="tw-text-gray-700 tw-whitespace-pre-line tw-bg-gray-50 tw-p-4 tw-rounded-lg">{{ $interview->agenda }}</div>
                        </div>
                        @endif

                        @if($interview->evaluation_criteria && count($interview->evaluation_criteria) > 0)
                        <div>
                            <h3 class="tw-text-lg tw-font-medium tw-text-gray-900 tw-mb-3">Critères d'Évaluation</h3>
                            <div class="tw-flex tw-flex-wrap tw-gap-2">
                                @foreach($interview->evaluation_criteria as $criterion)
                                    @php
                                        $criteriaLabels = [
                                            'technical_skills' => 'Compétences techniques',
                                            'communication' => 'Communication',
                                            'experience' => 'Expérience',
                                            'motivation' => 'Motivation',
                                            'team_fit' => 'Adéquation équipe',
                                            'problem_solving' => 'Résolution de problèmes',
                                            'leadership' => 'Leadership',
                                            'adaptability' => 'Adaptabilité'
                                        ];
                                    @endphp
                                    <span class="tw-inline-flex tw-items-center tw-px-3 tw-py-1 tw-rounded-full tw-text-xs tw-font-medium tw-bg-gray-100 tw-text-gray-800">
                                        {{ $criteriaLabels[$criterion] ?? $criterion }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Feedback de l'entretien --}}
                @if($interview->status === 'completed' && $interview->feedback)
                    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                            <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900">Feedback d'Entretien</h2>
                        </div>
                        
                        <div class="tw-px-6 tw-py-6">
                            @if($interview->rating)
                                <div class="tw-mb-4">
                                    <h3 class="tw-text-sm tw-font-medium tw-text-gray-500 tw-mb-2">Évaluation globale</h3>
                                    <div class="tw-flex tw-items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star tw-text-lg {{ $i <= $interview->rating ? 'tw-text-orange-400' : 'tw-text-gray-300' }}"></i>
                                        @endfor
                                        <span class="tw-ml-2 tw-text-sm tw-text-gray-600">({{ $interview->rating }}/5)</span>
                                    </div>
                                </div>
                            @endif
                            
                            <div>
                                <h3 class="tw-text-sm tw-font-medium tw-text-gray-500 tw-mb-2">Commentaires</h3>
                                <div class="tw-text-gray-700 tw-whitespace-pre-line tw-bg-gray-50 tw-p-4 tw-rounded-lg">{{ $interview->feedback }}</div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Formulaire de feedback (si entretien programmé) --}}
                @if($interview->status === 'scheduled' || ($interview->status === 'completed' && !$interview->feedback))
                    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                            <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900">
                                {{ $interview->status === 'completed' ? 'Ajouter un Feedback' : 'Marquer comme Terminé' }}
                            </h2>
                        </div>
                        
                        <form method="POST" action="{{ route('interviews.add-feedback', $interview) }}" class="tw-px-6 tw-py-6">
                            @csrf
                            
                            <div class="tw-space-y-6">
                                <div>
                                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                        Évaluation globale *
                                    </label>
                                    <div class="tw-flex tw-items-center tw-space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button" 
                                                    class="rating-star tw-text-2xl tw-transition tw-duration-200 tw-text-gray-300 hover:tw-text-orange-300"
                                                    data-rating="{{ $i }}">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating-input" required>
                                    @error('rating')
                                        <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                        Feedback détaillé *
                                    </label>
                                    <textarea name="feedback" rows="6" required
                                              class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400"
                                              placeholder="Points forts du candidat, axes d'amélioration, recommandations...">{{ old('feedback') }}</textarea>
                                    @error('feedback')
                                        <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if($interview->evaluation_criteria && count($interview->evaluation_criteria) > 0)
                                    <div>
                                        <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-4">
                                            Évaluation par critères
                                        </label>
                                        <div class="tw-space-y-4">
                                            @foreach($interview->evaluation_criteria as $criterion)
                                                @php
                                                    $criteriaLabels = [
                                                        'technical_skills' => 'Compétences techniques',
                                                        'communication' => 'Communication',
                                                        'experience' => 'Expérience',
                                                        'motivation' => 'Motivation',
                                                        'team_fit' => 'Adéquation équipe',
                                                        'problem_solving' => 'Résolution de problèmes',
                                                        'leadership' => 'Leadership',
                                                        'adaptability' => 'Adaptabilité'
                                                    ];
                                                @endphp
                                                <div class="tw-flex tw-items-center tw-justify-between tw-p-3 tw-border tw-border-gray-200 tw-rounded-lg">
                                                    <span class="tw-text-sm tw-font-medium tw-text-gray-700">
                                                        {{ $criteriaLabels[$criterion] ?? $criterion }}
                                                    </span>
                                                    <div class="tw-flex tw-items-center tw-space-x-1">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <button type="button" 
                                                                    class="criterion-star tw-text-sm tw-transition tw-duration-200 tw-text-gray-300 hover:tw-text-orange-300"
                                                                    data-criterion="{{ $criterion }}" data-rating="{{ $i }}">
                                                                <i class="fas fa-star"></i>
                                                            </button>
                                                        @endfor
                                                    </div>
                                                    <input type="hidden" name="evaluation_criteria[{{ $criterion }}]" class="criterion-input" data-criterion="{{ $criterion }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="tw-flex tw-justify-end tw-mt-6">
                                <button type="submit" 
                                        class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-6 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                    <i class="fas fa-check tw-mr-2"></i>
                                    Valider le Feedback
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="tw-space-y-6">
                {{-- Informations candidat --}}
                <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                        <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Candidat</h3>
                    </div>
                    <div class="tw-px-6 tw-py-6">
                        <div class="tw-space-y-4">
                            <div>
                                <span class="tw-text-sm tw-font-medium tw-text-gray-500">Nom complet</span>
                                <p class="tw-text-sm tw-text-gray-900 tw-mt-1">{{ $interview->application->first_name }} {{ $interview->application->last_name }}</p>
                            </div>
                            
                            <div>
                                <span class="tw-text-sm tw-font-medium tw-text-gray-500">Email</span>
                                <p class="tw-text-sm tw-text-gray-900 tw-mt-1">{{ $interview->application->email }}</p>
                            </div>
                            
                            @if($interview->application->phone)
                                <div>
                                    <span class="tw-text-sm tw-font-medium tw-text-gray-500">Téléphone</span>
                                    <p class="tw-text-sm tw-text-gray-900 tw-mt-1">{{ $interview->application->phone }}</p>
                                </div>
                            @endif
                            
                            <div>
                                <span class="tw-text-sm tw-font-medium tw-text-gray-500">Statut candidature</span>
                                <p class="tw-text-sm tw-text-gray-900 tw-mt-1">{{ ucfirst($interview->application->status) }}</p>
                            </div>
                        </div>
                        
                        <div class="tw-mt-6">
                            <a href="{{ route('applications.show', $interview->application) }}" 
                               class="tw-w-full tw-bg-gray-100 hover:tw-bg-gray-200 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 tw-text-center tw-block">
                                <i class="fas fa-user tw-mr-2"></i>Voir la candidature
                            </a>
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
                            <a href="{{ route('interviews.edit', $interview) }}" 
                               class="tw-w-full tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 tw-text-center tw-block">
                                <i class="fas fa-edit tw-mr-2"></i>Modifier l'entretien
                            </a>
                            
                            @if($interview->meeting_link)
                                <a href="{{ $interview->meeting_link }}" target="_blank"
                                   class="tw-w-full tw-bg-blue-500 hover:tw-bg-blue-600 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 tw-text-center tw-block">
                                    <i class="fas fa-video tw-mr-2"></i>Rejoindre la réunion
                                </a>
                            @endif
                            
                            @if($interview->status === 'scheduled')
                            
                                <form action="{{ route('interviews.reschedule', $interview) }}" method="POST" class="tw-border-2 tw-rounded-xl p-2">
                                    @csrf
                                    @method('POST')
                                    <div class="tw-space-y-4">
                                        <div class="tw-flex tw-items-center">
                                            <input type="datetime-local" name="scheduled_at" value="{{ $interview->scheduled_at->format('Y-m-d\TH:i') }}" required class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                        </div>
                                        <div class="tw-flex tw-items-center">
                                            <select name="interviewer_id" required class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                                <option value="">Sélectionner un interviewer</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ $user->id == $interview->interviewer_id ? 'selected' : '' }}>
                                                        {{ $user->name }} 
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="tw-flex tw-items-center tw-justify-end tw-pt-4">
                                        <button type="submit" 
                                                class="tw-w-full tw-bg-green-500 hover:tw-bg-green-600 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                            <i class="fas fa-calendar-plus tw-mr-2"></i>
                                            Reporter l'entretien
                                        </button>
                                    </div>
                                </form>
                                
                                <button type="button" 
                                        class="tw-w-full tw-bg-red-500 hover:tw-bg-red-600 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200"
                                        onclick="confirmAction('Êtes-vous sûr de vouloir annuler cet entretien ?')">
                                    <i class="fas fa-times tw-mr-2"></i>Annuler
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Informations sur l'entretien --}}
                <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                        <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Informations</h3>
                    </div>
                    <div class="tw-px-6 tw-py-6">
                        <div class="tw-space-y-4 tw-text-sm">
                            <div>
                                <span class="tw-font-medium tw-text-gray-700">Créé le</span>
                                <p class="tw-text-gray-600">{{ $interview->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            
                            @if($interview->updated_at != $interview->created_at)
                                <div>
                                    <span class="tw-font-medium tw-text-gray-700">Modifié le</span>
                                    <p class="tw-text-gray-600">{{ $interview->updated_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            @endif
                            
                            <div>
                                <span class="tw-font-medium tw-text-gray-700">Poste</span>
                                <p class="tw-text-gray-600">{{ $interview->application->jobOffer->title }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript pour les étoiles interactives --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Évaluation globale
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating-input');
    
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            ratingInput.value = rating;
            
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
                }
            });
        });
        
        star.addEventListener('mouseleave', function() {
            stars.forEach(s => s.classList.remove('tw-text-orange-300'));
        });
    });
    
    // Évaluation par critères
    const criterionStars = document.querySelectorAll('.criterion-star');
    
    criterionStars.forEach(star => {
        star.addEventListener('click', function() {
            const criterion = this.dataset.criterion;
            const rating = parseInt(this.dataset.rating);
            const input = document.querySelector(`.criterion-input[data-criterion="${criterion}"]`);
            
            input.value = rating;
            
            const criterionStarsGroup = document.querySelectorAll(`.criterion-star[data-criterion="${criterion}"]`);
            criterionStarsGroup.forEach((s, i) => {
                if (i < rating) {
                    s.classList.remove('tw-text-gray-300');
                    s.classList.add('tw-text-orange-400');
                } else {
                    s.classList.remove('tw-text-orange-400');
                    s.classList.add('tw-text-gray-300');
                }
            });
        });
    });
});

function confirmAction(message) {
    if (confirm(message)) {
        // Implémenter l'action
        $.ajax({
            url: `{{ route('interviews.cancel', $interview) }}`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                action: 'report'
            },
            success: function(data) {
                console.log(data);
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
}


// Select2 pour les champs de formulaire
$(document).ready(function() {
    $('.select2').select2({
        width: '100%',
        placeholder: 'Sélectionnez une option',
        allowClear: true
    });
});

</script>
@endsection