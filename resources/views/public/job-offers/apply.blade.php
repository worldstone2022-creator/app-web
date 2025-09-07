<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sections Animées</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/css/all.min.css') }}" defer="defer">
    <!-- Optionnel : config custom via CDN -->
    <script>
        tailwind.config = {
            prefix: 'tw-', // pour éviter les conflits avec Bootstrap
            theme: {
                extend: {
                    colors: {
                        primary: '#1E40AF',
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        /* Animations de base */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .slide-in-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.8s ease-out;
        }

        .slide-in-left.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .slide-in-right {
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.8s ease-out;
        }

        .slide-in-right.visible {
            opacity: 1;
            transform: translateX(0);
        }

        /* Effets de parallaxe */
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        /* Animations spécifiques */
        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            from {
                box-shadow: 0 0 20px rgba(251, 146, 60, 0.4);
            }

            to {
                box-shadow: 0 0 30px rgba(251, 146, 60, 0.8);
            }
        }

        .text-glow {
            text-shadow: 0 0 20px rgba(251, 146, 60, 0.5);
        }

        /* Effets hover améliorés */
        .hover-scale {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
        }

        .hover-scale:hover {
            transform: translateY(-15px) scale(1.05);
            box-shadow: 0 25px 50px rgba(12, 25, 94, 0.15);
        }

        .feature-card {
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(251, 146, 60, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .feature-card:hover::before {
            left: 100%;
        }

        .feature-icon {
            transition: all 0.4s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.2) rotate(5deg);
            filter: drop-shadow(0 10px 20px rgba(251, 146, 60, 0.3));
        }

        /* Animations de texte */
        .typewriter {
            overflow: hidden;
            border-right: 3px solid #fb923c;
            white-space: nowrap;
            margin: 0 auto;
            letter-spacing: 0.1em;
            animation: typing 3.5s steps(40, end), blink-caret 0.75s step-end infinite;
        }

        @keyframes typing {
            from {
                width: 0
            }

            to {
                width: 100%
            }
        }

        @keyframes blink-caret {

            from,
            to {
                border-color: transparent
            }

            50% {
                border-color: #fb923c;
            }
        }

        /* Boutons animés */
        .animated-button {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .animated-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .animated-button:hover::before {
            left: 100%;
        }

        .animated-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Particules flottantes */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(251, 146, 60, 0.3);
            animation: particle 8s linear infinite;
        }

        @keyframes particle {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Formulaire animé */
        .form-group {
            position: relative;
        }

        .form-input {
            transition: all 0.3s ease;
        }

        .form-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(251, 146, 60, 0.15);
        }

        .form-input:focus+.form-label {
            transform: translateY(-25px) scale(0.8);
            color: #fb923c;
        }

        .social-icon {
            transition: all 0.3s ease;
            position: relative;
        }

        .social-icon:hover {
            transform: translateY(-5px) rotate(10deg);
        }

        .social-icon::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            width: 0;
            height: 2px;
            background: #fb923c;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .social-icon:hover::after {
            width: 100%;
        }

        /* Délais d'animation pour effet cascade */
        .stagger-1 {
            animation-delay: 0.1s;
        }

        .stagger-2 {
            animation-delay: 0.2s;
        }

        .stagger-3 {
            animation-delay: 0.3s;
        }

        .stagger-4 {
            animation-delay: 0.4s;
        }

        .stagger-5 {
            animation-delay: 0.5s;
        }

        .stagger-6 {
            animation-delay: 0.6s;
        }

        /* Effet de révélation progressive */
        .reveal {
            clip-path: polygon(0 100%, 100% 100%, 100% 100%, 0% 100%);
            transition: clip-path 0.8s ease;
        }

        .reveal.visible {
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);
        }
    </style>
</head>

<body class="tw-bg-gray-50">
<div class="tw-min-h-screen tw-bg-gray-50 tw-py-8">
    <div class="tw-max-w-4xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
         <nav class="tw-bg-black tw-shadow tw-py-4">
            <div class="tw-max-w-7xl tw-mx-auto tw-flex tw-items-center tw-justify-between tw-px-4 sm:tw-px-6 lg:tw-px-8">
            <div class="tw-flex tw-items-center">
                <img src="{{ $company->logo_url }}" alt="Logo {{ $company->company_name }}" class="tw-h-10 tw-w-auto tw-mr-3">
                <span class="tw-font-semibold tw-text-lg tw-text-white">{{ $company->company_name }}</span>
            </div>
            </div>
        </nav>
        {{-- Navigation --}}
        <div class="tw-my-8">
            <a href="{{ route('public.job-offers.show', $jobOffer->id) }}" 
               class="tw-inline-flex tw-items-center hover:tw-text-orange-800 tw-transition tw-duration-200">
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
                
                <div class="tw-px-6 tw-py-2">
                    {{-- Informations personnelles --}}
                    <div class="tw-mb-8">
                         <input type="text" name="companyId" class="tw-hidden" value="{{ $jobOffer->companyId }}" >
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
    <body>
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


</html>