{{-- resources/views/hr/interviews/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="tw-min-h-screen tw-bg-gray-50 tw-py-8">
    <div class="tw-max-w-4xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
        {{-- En-tête --}}
        <div class="tw-mb-8">
            <div class="tw-flex tw-items-center tw-justify-between">
                <div>
                    <h1 class="tw-text-3xl tw-font-bold tw-text-gray-900">Planifier un Entretien</h1>
                    <p class="tw-mt-2 tw-text-gray-600">
                        Pour {{ $application->first_name }} {{ $application->last_name }} - {{ $application->jobOffer->title }}
                    </p>
                </div>
                <a href="{{ route('applications.show', $application) }}" 
                   class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                    <i class="fas fa-arrow-left tw-mr-2"></i>
                    Retour à la candidature
                </a>
            </div>
        </div>

        {{-- Informations candidat --}}
        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden tw-mb-8">
            <div class="tw-bg-orange-50 tw-px-6 tw-py-4 tw-border-b tw-border-orange-200">
                <div class="tw-flex tw-items-center tw-space-x-4">
                    <div class="tw-h-12 tw-w-12 tw-rounded-full tw-bg-orange-100 tw-flex tw-items-center tw-justify-center">
                        <span class="tw-text-orange-600 tw-font-bold">
                            {{ substr($application->first_name, 0, 1) }}{{ substr($application->last_name, 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">
                            {{ $application->first_name }} {{ $application->last_name }}
                        </h3>
                        <p class="tw-text-orange-700">{{ $application->email }} • {{ $application->phone }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulaire --}}
        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
            <form method="POST" action="{{ route('interviews.store') }}" class="tw-space-y-6">
                @csrf
                <input type="hidden" name="job_application_id" value="{{ $application->id }}">
                
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
                                    <option value="phone" {{ old('type') == 'phone' ? 'selected' : '' }}>Téléphonique</option>
                                    <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Visioconférence</option>
                                    <option value="in_person" {{ old('type') == 'in_person' ? 'selected' : '' }}>En personne</option>
                                    <option value="technical" {{ old('type') == 'technical' ? 'selected' : '' }}>Technique</option>
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
                                        class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('interviewer_id') tw-border-red-500 @enderror">
                                    <option value="">Sélectionner un interviewer</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('interviewer_id') == $user->id ? 'selected' : '' }}>
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
                                       value="{{ old('scheduled_at') }}" required
                                       min="{{ date('Y-m-d\TH:i') }}"
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
                                    <option value="15" {{ old('duration_minutes') == '15' ? 'selected' : '' }}>15 minutes</option>
                                    <option value="30" {{ old('duration_minutes') == '30' ? 'selected' : '' }}>30 minutes</option>
                                    <option value="45" {{ old('duration_minutes') == '45' ? 'selected' : '' }}>45 minutes</option>
                                    <option value="60" {{ old('duration_minutes') == '60' ? 'selected' : '' }}>1 heure</option>
                                    <option value="90" {{ old('duration_minutes') == '90' ? 'selected' : '' }}>1h30</option>
                                    <option value="120" {{ old('duration_minutes') == '120' ? 'selected' : '' }}>2 heures</option>
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
                                       value="{{ old('location') }}"
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
                                       value="{{ old('meeting_link') }}"
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('meeting_link') tw-border-red-500 @enderror"
                                       placeholder="https://meet.google.com/... ou https://zoom.us/...">
                                @error('meeting_link')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Agenda et critères --}}
                    <div class="tw-mb-8">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-6 tw-border-b tw-border-orange-200 tw-pb-2">
                            Agenda et Évaluation
                        </h2>
                        
                        <div class="tw-space-y-6">
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Agenda de l'entretien
                                </label>
                                <textarea name="agenda" rows="4"
                                          class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('agenda') tw-border-red-500 @enderror"
                                          placeholder="Ex: Présentation du candidat (10min), Questions techniques (20min), Questions sur l'expérience (15min), Questions du candidat (15min)">{{ old('agenda') }}</textarea>
                                @error('agenda')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-4">
                                    Critères d'évaluation
                                </label>
                                <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
                                    <div class="tw-space-y-3">
                                        <div class="tw-flex tw-items-center">
                                            <input type="checkbox" name="evaluation_criteria[]" value="technical_skills" 
                                                   id="technical_skills" class="tw-h-4 tw-w-4 tw-text-orange-600 tw-focus:ring-orange-500 tw-border-gray-300 tw-rounded">
                                            <label for="technical_skills" class="tw-ml-2 tw-text-sm tw-text-gray-700">Compétences techniques</label>
                                        </div>
                                        <div class="tw-flex tw-items-center">
                                            <input type="checkbox" name="evaluation_criteria[]" value="communication" 
                                                   id="communication" class="tw-h-4 tw-w-4 tw-text-orange-600 tw-focus:ring-orange-500 tw-border-gray-300 tw-rounded">
                                            <label for="communication" class="tw-ml-2 tw-text-sm tw-text-gray-700">Communication</label>
                                        </div>
                                        <div class="tw-flex tw-items-center">
                                            <input type="checkbox" name="evaluation_criteria[]" value="experience" 
                                                   id="experience" class="tw-h-4 tw-w-4 tw-text-orange-600 tw-focus:ring-orange-500 tw-border-gray-300 tw-rounded">
                                            <label for="experience" class="tw-ml-2 tw-text-sm tw-text-gray-700">Expérience</label>
                                        </div>
                                        <div class="tw-flex tw-items-center">
                                            <input type="checkbox" name="evaluation_criteria[]" value="motivation" 
                                                   id="motivation" class="tw-h-4 tw-w-4 tw-text-orange-600 tw-focus:ring-orange-500 tw-border-gray-300 tw-rounded">
                                            <label for="motivation" class="tw-ml-2 tw-text-sm tw-text-gray-700">Motivation</label>
                                        </div>
                                    </div>
                                    <div class="tw-space-y-3">
                                        <div class="tw-flex tw-items-center">
                                            <input type="checkbox" name="evaluation_criteria[]" value="team_fit" 
                                                   id="team_fit" class="tw-h-4 tw-w-4 tw-text-orange-600 tw-focus:ring-orange-500 tw-border-gray-300 tw-rounded">
                                            <label for="team_fit" class="tw-ml-2 tw-text-sm tw-text-gray-700">Adéquation équipe</label>
                                        </div>
                                        <div class="tw-flex tw-items-center">
                                            <input type="checkbox" name="evaluation_criteria[]" value="problem_solving" 
                                                   id="problem_solving" class="tw-h-4 tw-w-4 tw-text-orange-600 tw-focus:ring-orange-500 tw-border-gray-300 tw-rounded">
                                            <label for="problem_solving" class="tw-ml-2 tw-text-sm tw-text-gray-700">Résolution de problèmes</label>
                                        </div>
                                        <div class="tw-flex tw-items-center">
                                            <input type="checkbox" name="evaluation_criteria[]" value="leadership" 
                                                   id="leadership" class="tw-h-4 tw-w-4 tw-text-orange-600 tw-focus:ring-orange-500 tw-border-gray-300 tw-rounded">
                                            <label for="leadership" class="tw-ml-2 tw-text-sm tw-text-gray-700">Leadership</label>
                                        </div>
                                        <div class="tw-flex tw-items-center">
                                            <input type="checkbox" name="evaluation_criteria[]" value="adaptability" 
                                                   id="adaptability" class="tw-h-4 tw-w-4 tw-text-orange-600 tw-focus:ring-orange-500 tw-border-gray-300 tw-rounded">
                                            <label for="adaptability" class="tw-ml-2 tw-text-sm tw-text-gray-700">Adaptabilité</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Interviewers additionnels --}}
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Interviewers additionnels (optionnel)
                                </label>
                                <div class="tw-space-y-2">
                                    @foreach($users as $user)
                                        <div class="tw-flex tw-items-center">
                                            <input type="checkbox" name="additional_interviewers[]" value="{{ $user->id }}" 
                                                   id="additional_{{ $user->id }}" class="tw-h-4 tw-w-4 tw-text-orange-600 tw-focus:ring-orange-500 tw-border-gray-300 tw-rounded">
                                            <label for="additional_{{ $user->id }}" class="tw-ml-2 tw-text-sm tw-text-gray-700">
                                                {{ $user->name }} 
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
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
                            <a href="{{ route('applications.show', $application) }}" 
                               class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-6 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-8 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 tw-shadow-sm hover:tw-shadow-md">
                                <i class="fas fa-calendar-plus tw-mr-2"></i>
                                Planifier l'entretien
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Note informative --}}
        <div class="tw-mt-6 tw-bg-orange-50 tw-border tw-border-orange-200 tw-rounded-lg tw-p-4">
            <div class="tw-flex">
                <i class="fas fa-info-circle tw-text-orange-400 tw-flex-shrink-0 tw-mt-0.5"></i>
                <div class="tw-ml-3">
                    <h3 class="tw-text-sm tw-font-medium tw-text-orange-800">Information</h3>
                    <p class="tw-mt-1 tw-text-sm tw-text-orange-700">
                        Une fois l'entretien planifié, le candidat et les interviewers recevront automatiquement une invitation par email avec tous les détails.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript pour la gestion dynamique --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.querySelector('select[name="type"]');
    const locationField = document.querySelector('input[name="location"]');
    const meetingLinkField = document.querySelector('input[name="meeting_link"]');
    
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
    
    typeSelect.addEventListener('change', toggleFields);
    toggleFields(); // Initialiser
});
</script>
@endsection