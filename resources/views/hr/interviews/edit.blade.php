{{-- resources/views/hr/interviews/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="tw-min-h-screen tw-bg-gray-50 tw-py-8">
    <div class="tw-max-w-4xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
        {{-- En-tête --}}
        <div class="tw-mb-8">
            <div class="tw-flex tw-items-center tw-justify-between">
                <div>
                    <h1 class="tw-text-3xl tw-font-bold tw-text-gray-900">Modifier l'Entretien</h1>
                    <p class="tw-mt-2 tw-text-gray-600">
                        {{ $interview->application->first_name }} {{ $interview->application->last_name }} - {{ $interview->application->jobOffer->title }}
                    </p>
                </div>
                <a href="{{ route('interviews.show', $interview) }}" 
                   class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                    <i class="fas fa-arrow-left tw-mr-2"></i>
                    Retour
                </a>
            </div>
        </div>

        {{-- Informations candidat --}}
        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden tw-mb-8">
            <div class="tw-bg-orange-50 tw-px-6 tw-py-4 tw-border-b tw-border-orange-200">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div class="tw-flex tw-items-center tw-space-x-4">
                        <div class="tw-h-12 tw-w-12 tw-rounded-full tw-bg-orange-100 tw-flex tw-items-center tw-justify-center">
                            <span class="tw-text-orange-600 tw-font-bold">
                                {{ substr($interview->application->first_name, 0, 1) }}{{ substr($interview->application->last_name, 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">
                                {{ $interview->application->first_name }} {{ $interview->application->last_name }}
                            </h3>
                            <p class="tw-text-orange-700">{{ $interview->application->email }} • {{ $interview->application->phone }}</p>
                        </div>
                    </div>
                    
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
                </div>
            </div>
        </div>

        {{-- Formulaire --}}
        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
            <form method="POST" action="{{ route('interviews.update', $interview) }}" class="tw-space-y-6">
                @csrf
                @method('PUT')
                
                <div class="tw-px-6 tw-py-6">
                    {{-- Type et planning --}}
                    <div class="tw-mb-8">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-6 tw-border-b tw-border-orange-200 tw-pb-2">
                            Détails de l'Entretien
                        </h2>
                        
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-6">
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Type d'entretien *
                                </label>
                                <select name="type" required
                                        class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('type') tw-border-red-500 @enderror">
                                    <option value="">Sélectionner un type</option>
                                    <option value="phone" {{ old('type', $interview->type) == 'phone' ? 'selected' : '' }}>Téléphonique</option>
                                    <option value="video" {{ old('type', $interview->type) == 'video' ? 'selected' : '' }}>Visioconférence</option>
                                    <option value="in_person" {{ old('type', $interview->type) == 'in_person' ? 'selected' : '' }}>En personne</option>
                                    <option value="technical" {{ old('type', $interview->type) == 'technical' ? 'selected' : '' }}>Technique</option>
                                </select>
                                @error('type')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Interviewer principal *
                                </label>
                                <select name="interviewer_id" required
                                        class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400  @error('interviewer_id') tw-border-red-500 @enderror">
                                    <option value="" disabled selected>Sélectionner un interviewer</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('interviewer_id', $interview->interviewer_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} 
                                        </option>
                                    @endforeach
                                </select>
                                @error('interviewer_id')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Date et heure *
                                </label>
                                <input type="datetime-local" name="scheduled_at" 
                                       value="{{ old('scheduled_at', $interview->scheduled_at->format('Y-m-d\TH:i')) }}" required
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('scheduled_at') tw-border-red-500 @enderror">
                                @error('scheduled_at')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Durée (minutes) *
                                </label>
                                <select name="duration_minutes" required
                                        class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('duration_minutes') tw-border-red-500 @enderror">
                                    <option value="">Sélectionner une durée</option>
                                    <option value="15" {{ old('duration_minutes', $interview->duration_minutes) == '15' ? 'selected' : '' }}>15 minutes</option>
                                    <option value="30" {{ old('duration_minutes', $interview->duration_minutes) == '30' ? 'selected' : '' }}>30 minutes</option>
                                    <option value="45" {{ old('duration_minutes', $interview->duration_minutes) == '45' ? 'selected' : '' }}>45 minutes</option>
                                    <option value="60" {{ old('duration_minutes', $interview->duration_minutes) == '60' ? 'selected' : '' }}>1 heure</option>
                                    <option value="90" {{ old('duration_minutes', $interview->duration_minutes) == '90' ? 'selected' : '' }}>1h30</option>
                                    <option value="120" {{ old('duration_minutes', $interview->duration_minutes) == '120' ? 'selected' : '' }}>2 heures</option>
                                </select>
                                @error('duration_minutes')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Localisation et lien --}}
                    <div class="tw-mb-8">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-6 tw-border-b tw-border-orange-200 tw-pb-2">
                            Localisation
                        </h2>
                        
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-6">
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Lieu de l'entretien
                                </label>
                                <input type="text" name="location" 
                                       value="{{ old('location', $interview->location) }}"
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('location') tw-border-red-500 @enderror"
                                       placeholder="Salle de réunion, adresse...">
                                @error('location')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Lien de visioconférence
                                </label>
                                <input type="url" name="meeting_link" 
                                       value="{{ old('meeting_link', $interview->meeting_link) }}"
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('meeting_link') tw-border-red-500 @enderror"
                                       placeholder="https://meet.google.com/... ou https://zoom.us/...">
                                @error('meeting_link')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Statut et agenda --}}
                    <div class="tw-mb-8">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-6 tw-border-b tw-border-orange-200 tw-pb-2">
                            Statut et Agenda
                        </h2>
                        
                        <div class="tw-space-y-6">
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Statut de l'entretien *
                                </label>
                                <select name="status" required
                                        class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('status') tw-border-red-500 @enderror">
                                    <option value="scheduled" {{ old('status', $interview->status) == 'scheduled' ? 'selected' : '' }}>Programmé</option>
                                    <option value="completed" {{ old('status', $interview->status) == 'completed' ? 'selected' : '' }}>Terminé</option>
                                    <option value="cancelled" {{ old('status', $interview->status) == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                                    <option value="rescheduled" {{ old('status', $interview->status) == 'rescheduled' ? 'selected' : '' }}>Reporté</option>
                                </select>
                                @error('status')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Agenda de l'entretien
                                </label>
                                <textarea name="agenda" rows="4"
                                          class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('agenda') tw-border-red-500 @enderror"
                                          placeholder="Ex: Présentation du candidat (10min), Questions techniques (20min), Questions sur l'expérience (15min), Questions du candidat (15min)">{{ old('agenda', $interview->agenda) }}</textarea>
                                @error('agenda')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Interviewers additionnels --}}
                    <div class="tw-mb-8">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-6 tw-border-b tw-border-orange-200 tw-pb-2">
                            Participants Additionnels
                        </h2>
                        
                        <div>
                            <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-4">
                                Interviewers additionnels (optionnel)
                            </label>
                            <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-3">
                                @foreach($users as $user)
                                    @if($user->id != $interview->interviewer_id)
                                        <div class="tw-flex tw-items-center">
                                            <input type="checkbox" name="additional_interviewers[]" value="{{ $user->id }}" 
                                                   id="additional_{{ $user->id }}" 
                                                   {{ in_array($user->id, old('additional_interviewers', $interview->additional_interviewers ?? [])) ? 'checked' : '' }}
                                                   class="tw-h-4 tw-w-4 tw-text-orange-600 tw-focus:ring-orange-500 tw-border-gray-300 tw-rounded">
                                            <label for="additional_{{ $user->id }}" class="tw-ml-2 tw-text-sm tw-text-gray-700">
                                                {{ $user->name }} 
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Boutons d'action --}}
                <div class="tw-bg-gray-50 tw-px-6 tw-py-4 tw-border-t tw-border-gray-200">
                    <div class="tw-flex tw-items-center tw-justify-between">
                        <p class="tw-text-sm tw-text-gray-500">
                            * Champs obligatoires
                        </p>
                        <div class="tw-flex tw-items-center tw-space-x-4">
                            <a href="{{ route('interviews.show', $interview) }}" 
                               class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-6 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-8 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 tw-shadow-sm hover:tw-shadow-md">
                                <i class="fas fa-save tw-mr-2"></i>
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Informations d'audit --}}
        <div class="tw-mt-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-p-4">
            <div class="tw-flex tw-items-center tw-space-x-4 tw-text-sm tw-text-gray-600">
                <div>
                    <span class="tw-font-medium">Créé le:</span> {{ $interview->created_at->format('d/m/Y à H:i') }}
                </div>
                <div>
                    <span class="tw-font-medium">Modifié le:</span> {{ $interview->updated_at->format('d/m/Y à H:i') }}
                </div>
                <div>
                    <span class="tw-font-medium">Interviewer:</span> {{ $interview->interviewer->name }}
                </div>
            </div>
        </div>

        {{-- Historique des modifications --}}
        @if($interview->status === 'rescheduled' || $interview->status === 'cancelled')
            <div class="tw-mt-6 tw-bg-yellow-50 tw-border tw-border-yellow-200 tw-rounded-lg tw-p-4">
                <div class="tw-flex">
                    <i class="fas fa-exclamation-triangle tw-text-yellow-400 tw-flex-shrink-0 tw-mt-0.5"></i>
                    <div class="tw-ml-3">
                        <h3 class="tw-text-sm tw-font-medium tw-text-yellow-800">Attention</h3>
                        <p class="tw-mt-1 tw-text-sm tw-text-yellow-700">
                            @if($interview->status === 'rescheduled')
                                Cet entretien a été reporté. Les participants ont été notifiés des changements.
                            @else
                                Cet entretien a été annulé. Assurez-vous d'informer le candidat des prochaines étapes.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- JavaScript pour la gestion dynamique --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.querySelector('select[name="type"]');
    const locationField = document.querySelector('input[name="location"]');
    const meetingLinkField = document.querySelector('input[name="meeting_link"]');
    const statusSelect = document.querySelector('select[name="status"]');
    const interviewerSelect = document.querySelector('select[name="interviewer_id"]');
    
    function toggleFields() {
        const type = typeSelect.value;
        
        if (type === 'video') {
            meetingLinkField.required = true;
            locationField.required = false;
            meetingLinkField.closest('div').style.opacity = '1';
            locationField.closest('div').style.opacity = '0.6';
        } else if (type === 'in_person') {
            locationField.required = true;
            meetingLinkField.required = false;
            locationField.closest('div').style.opacity = '1';
            meetingLinkField.closest('div').style.opacity = '0.6';
        } else {
            locationField.required = false;
            meetingLinkField.required = false;
            locationField.closest('div').style.opacity = '1';
            meetingLinkField.closest('div').style.opacity = '1';
        }
    }
    
    function updateAdditionalInterviewers() {
        const selectedInterviewer = interviewerSelect.value;
        const checkboxes = document.querySelectorAll('input[name="additional_interviewers[]"]');
        
        checkboxes.forEach(checkbox => {
            if (checkbox.value === selectedInterviewer) {
                checkbox.checked = false;
                checkbox.disabled = true;
                checkbox.closest('div').style.opacity = '0.5';
            } else {
                checkbox.disabled = false;
                checkbox.closest('div').style.opacity = '1';
            }
        });
    }
    
    // Alertes pour changement de statut
    statusSelect.addEventListener('change', function() {
        const status = this.value;
        
        if (status === 'cancelled') {
            if (!confirm('Êtes-vous sûr de vouloir annuler cet entretien ? Le candidat sera automatiquement notifié.')) {
                this.value = this.defaultValue;
                return;
            }
        }
        
        if (status === 'rescheduled') {
            alert('N\'oubliez pas de modifier la date et l\'heure pour reporter l\'entretien.');
        }
    });
    
    typeSelect.addEventListener('change', toggleFields);
    interviewerSelect.addEventListener('change', updateAdditionalInterviewers);
    
    // Initialiser
    toggleFields();
    updateAdditionalInterviewers();
});
</script>
@endsection