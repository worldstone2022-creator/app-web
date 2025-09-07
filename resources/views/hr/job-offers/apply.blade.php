{{-- resources/views/public/job-offers/apply.blade.php --}}
@extends('layouts.public')

@section('content')
<div class="tw-min-h-screen tw-bg-gray-50 tw-py-8">
    <div class="tw-max-w-4xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
        {{-- Navigation --}}
        <div class="tw-mb-8">
            <a href="{{ route('public.job-offers.show', $jobOffer->id) }}" 
               class="tw-inline-flex tw-items-center tw-text-orange-600 hover:tw-text-orange-800 tw-transition tw-duration-200">
                <i class="fas fa-arrow-left tw-mr-2"></i>
                Retour à l'offre
            </a>
        </div>

        {{-- En-tête --}}
        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden tw-mb-8">
            <div class="tw-bg-gradient-to-r tw-from-orange-400 tw-to-orange-600 tw-px-6 tw-py-8 tw-text-white">
                <div class="tw-text-center">
                    <h1 class="tw-text-3xl tw-font-bold tw-mb-2">Postuler pour ce poste</h1>
                    <p class="tw-text-xl tw-text-orange-100">{{ $jobOffer->title }}</p>
                    <p class="tw-text-orange-100">{{ $jobOffer->department }} • {{ $jobOffer->location }}</p>
                </div>
            </div>
        </div>

        {{-- Formulaire de candidature --}}
        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
            <form method="POST" action="{{ route('public.job-offers.apply', $jobOffer) }}" enctype="multipart/form-data" class="tw-space-y-6">
                @csrf
                
                <div class="tw-px-6 tw-py-6">
                    {{-- Informations personnelles --}}
                    <div class="tw-mb-8">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-6 tw-border-b tw-border-orange-200 tw-pb-2">
                            Informations Personnelles
                        </h2>
                        
                       
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-6">
                            <div>
                                
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Prénom *
                                </label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('first_name') tw-border-red-500 @enderror">
                                @error('first_name')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Nom *
                                </label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('last_name') tw-border-red-500 @enderror">
                                @error('last_name')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Email *
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('email') tw-border-red-500 @enderror">
                                @error('email')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Téléphone *
                                </label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('phone') tw-border-red-500 @enderror">
                                @error('phone')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:tw-col-span-2">
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Adresse
                                </label>
                                <textarea name="address" rows="2"
                                          class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('address') tw-border-red-500 @enderror"
                                          placeholder="Adresse complète">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Documents --}}
                    <div class="tw-mb-8">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-6 tw-border-b tw-border-orange-200 tw-pb-2">
                            Documents
                        </h2>
                        
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-6">
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    CV * (PDF, DOC, DOCX - Max 5Mo)
                                </label>
                                <div class="tw-relative">
                                    <input type="file" name="cv" required accept=".pdf,.doc,.docx"
                                           class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('cv') tw-border-red-500 @enderror">
                                </div>
                                @error('cv')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Lettre de motivation (PDF, DOC, DOCX - Max 5Mo)
                                </label>
                                <input type="file" name="cover_letter" accept=".pdf,.doc,.docx"
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('cover_letter') tw-border-red-500 @enderror">
                                @error('cover_letter')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Message de motivation --}}
                    <div class="tw-mb-8">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-6 tw-border-b tw-border-orange-200 tw-pb-2">
                            Message de Motivation
                        </h2>
                        
                        <div>
                            <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                Présentez-vous et expliquez votre motivation
                            </label>
                            <textarea name="message" rows="6"
                                      class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('message') tw-border-red-500 @enderror"
                                      placeholder="Pourquoi ce poste vous intéresse-t-il ? Que pouvez-vous apporter à l'entreprise ?">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Liens professionnels --}}
                    <div class="tw-mb-8">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-6 tw-border-b tw-border-orange-200 tw-pb-2">
                            Liens Professionnels
                        </h2>
                        
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-6">
                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Profil LinkedIn
                                </label>
                                <input type="url" name="linkedin_profile" value="{{ old('linkedin_profile') }}"
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('linkedin_profile') tw-border-red-500 @enderror"
                                       placeholder="https://linkedin.com/in/votre-profil">
                                @error('linkedin_profile')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                    Portfolio / Site web
                                </label>
                                <input type="url" name="portfolio_url" value="{{ old('portfolio_url') }}"
                                       class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400 @error('portfolio_url') tw-border-red-500 @enderror"
                                       placeholder="https://votre-portfolio.com">
                                @error('portfolio_url')
                                    <p class="tw-mt-1 tw-text-sm tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Expérience professionnelle --}}
                    <div class="tw-mb-8">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-6 tw-border-b tw-border-orange-200 tw-pb-2">
                            Expérience Professionnelle
                        </h2>
                        
                        <div id="experience-container">
                            <div class="experience-item tw-p-4 tw-border tw-border-gray-200 tw-rounded-lg tw-mb-4">
                                <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
                                    <div>
                                        <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                            Titre du poste
                                        </label>
                                        <input type="text" name="experience[0][title]" 
                                               class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                    </div>
                                    <div>
                                        <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                            Entreprise
                                        </label>
                                        <input type="text" name="experience[0][company]" 
                                               class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                    </div>
                                    <div>
                                        <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                            Période
                                        </label>
                                        <input type="text" name="experience[0][duration]" 
                                               class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400"
                                               placeholder="Ex: Jan 2020 - Déc 2022">
                                    </div>
                                    <div class="md:tw-col-span-2">
                                        <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                            Description
                                        </label>
                                        <textarea name="experience[0][description]" rows="3"
                                                  class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400"
                                                  placeholder="Décrivez vos missions et réalisations..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-experience" 
                                class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded-lg tw-text-sm tw-font-medium tw-transition tw-duration-200">
                            <i class="fas fa-plus tw-mr-2"></i>Ajouter une expérience
                        </button>
                    </div>

                    {{-- Formation --}}
                    <div class="tw-mb-8">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-6 tw-border-b tw-border-orange-200 tw-pb-2">
                            Formation
                        </h2>
                        
                        <div id="education-container">
                            <div class="education-item tw-p-4 tw-border tw-border-gray-200 tw-rounded-lg tw-mb-4">
                                <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-4">
                                    <div>
                                        <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                            Diplôme
                                        </label>
                                        <input type="text" name="education[0][degree]" 
                                               class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                    </div>
                                    <div>
                                        <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                            École/Université
                                        </label>
                                        <input type="text" name="education[0][school]" 
                                               class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                                    </div>
                                    <div>
                                        <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                            Année
                                        </label>
                                        <input type="text" name="education[0][year]" 
                                               class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400"
                                               placeholder="Ex: 2020">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-education" 
                                class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded-lg tw-text-sm tw-font-medium tw-transition tw-duration-200">
                            <i class="fas fa-plus tw-mr-2"></i>Ajouter une formation
                        </button>
                    </div>

                    {{-- Compétences --}}
                    <div class="tw-mb-8">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900 tw-mb-6 tw-border-b tw-border-orange-200 tw-pb-2">
                            Compétences
                        </h2>
                        
                        <div>
                            <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                Listez vos principales compétences (appuyez sur Entrée pour ajouter)
                            </label>
                            <input type="text" id="skill-input" 
                                   class="tw-w-full tw-px-4 tw-py-3 tw-border tw-border-gray-300 tw-rounded-lg tw-appearance-none tw-bg-white tw-text-gray-700 tw-shadow-sm tw-focus:outline-none tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400"
                                   placeholder="Ex: JavaScript, PHP, React...">
                            
                            <div id="skills-container" class="tw-mt-4 tw-flex tw-flex-wrap tw-gap-2"></div>
                            <input type="hidden" name="skills" id="skills-hidden">
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
                            <a href="{{ route('public.job-offers.show', $jobOffer->id) }}" 
                               class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-6 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-8 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 tw-shadow-sm hover:tw-shadow-md">
                                <i class="fas fa-paper-plane tw-mr-2"></i>
                                Envoyer ma candidature
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Information sur la confidentialité --}}
        <div class="tw-mt-6 tw-bg-orange-50 tw-border tw-border-orange-200 tw-rounded-lg tw-p-4">
            <div class="tw-flex">
                <i class="fas fa-shield-alt tw-text-orange-400 tw-flex-shrink-0 tw-mt-0.5"></i>
                <div class="tw-ml-3">
                    <h3 class="tw-text-sm tw-font-medium tw-text-orange-800">Confidentialité</h3>
                    <p class="tw-mt-1 tw-text-sm tw-text-orange-700">
                        Vos informations personnelles sont protégées et ne seront utilisées que dans le cadre de ce processus de recrutement. 
                        Elles ne seront pas partagées avec des tiers sans votre consentement.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript pour la gestion dynamique des sections --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    let experienceIndex = 1;
    let educationIndex = 1;
    let skills = [];

    // Gestion des expériences
    document.getElementById('add-experience').addEventListener('click', function() {
        const container = document.getElementById('experience-container');
        const newExperience = document.createElement('div');
        newExperience.className = 'experience-item tw-p-4 tw-border tw-border-gray-200 tw-rounded-lg tw-mb-4 tw-relative';
        newExperience.innerHTML = `
            <button type="button" class="remove-experience tw-absolute tw-top-2 tw-right-2 tw-text-red-500 hover:tw-text-red-700 tw-transition tw-duration-200">
                <i class="fas fa-times"></i>
            </button>
            <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
                <div>
                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Titre du poste</label>
                    <input type="text" name="experience[${experienceIndex}][title]" class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                </div>
                <div>
                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Entreprise</label>
                    <input type="text" name="experience[${experienceIndex}][company]" class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                </div>
                <div>
                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Période</label>
                    <input type="text" name="experience[${experienceIndex}][duration]" class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400" placeholder="Ex: Jan 2020 - Déc 2022">
                </div>
                <div class="md:tw-col-span-2">
                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Description</label>
                    <textarea name="experience[${experienceIndex}][description]" rows="3" class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400" placeholder="Décrivez vos missions et réalisations..."></textarea>
                </div>
            </div>
        `;
        container.appendChild(newExperience);
        experienceIndex++;
    });

    // Gestion des formations
    document.getElementById('add-education').addEventListener('click', function() {
        const container = document.getElementById('education-container');
        const newEducation = document.createElement('div');
        newEducation.className = 'education-item tw-p-4 tw-border tw-border-gray-200 tw-rounded-lg tw-mb-4 tw-relative';
        newEducation.innerHTML = `
            <button type="button" class="remove-education tw-absolute tw-top-2 tw-right-2 tw-text-red-500 hover:tw-text-red-700 tw-transition tw-duration-200">
                <i class="fas fa-times"></i>
            </button>
            <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-4">
                <div>
                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Diplôme</label>
                    <input type="text" name="education[${educationIndex}][degree]" class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                </div>
                <div>
                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">École/Université</label>
                    <input type="text" name="education[${educationIndex}][school]" class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400">
                </div>
                <div>
                    <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">Année</label>
                    <input type="text" name="education[${educationIndex}][year]" class="tw-w-full tw-px-3 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg tw-focus:ring-2 tw-focus:ring-orange-400 tw-focus:border-orange-400" placeholder="Ex: 2020">
                </div>
            </div>
        `;
        container.appendChild(newEducation);
        educationIndex++;
    });

    // Suppression des éléments
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-experience')) {
            e.target.closest('.experience-item').remove();
        }
        if (e.target.closest('.remove-education')) {
            e.target.closest('.education-item').remove();
        }
        if (e.target.closest('.remove-skill')) {
            const skillText = e.target.closest('.skill-tag').textContent.replace('×', '').trim();
            skills = skills.filter(skill => skill !== skillText);
            updateSkillsDisplay();
        }
    });

    // Gestion des compétences
    const skillInput = document.getElementById('skill-input');
    skillInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const skill = this.value.trim();
            if (skill && !skills.includes(skill)) {
                skills.push(skill);
                updateSkillsDisplay();
                this.value = '';
            }
        }
    });

    function updateSkillsDisplay() {
        const container = document.getElementById('skills-container');
        const hiddenInput = document.getElementById('skills-hidden');
        
        container.innerHTML = skills.map(skill => 
            `<span class="skill-tag tw-inline-flex tw-items-center tw-px-3 tw-py-1 tw-rounded-full tw-text-sm tw-font-medium tw-bg-orange-100 tw-text-orange-800">
                ${skill}
                <button type="button" class="remove-skill tw-ml-2 tw-text-orange-600 hover:tw-text-orange-800">×</button>
            </span>`
        ).join('');
        
        hiddenInput.value = JSON.stringify(skills);
    }
});
</script>
@endsection