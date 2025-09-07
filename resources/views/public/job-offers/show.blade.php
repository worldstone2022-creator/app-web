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
            {{-- En-tête de l'offre --}}
            <nav class="tw-bg-black tw-shadow tw-py-4">
                <div
                    class="tw-max-w-7xl tw-mx-auto tw-flex tw-items-center tw-justify-between tw-px-4 sm:tw-px-6 lg:tw-px-8">
                    <div class="tw-flex tw-items-center">
                        <img src="{{ $company->logo_url }}" alt="Logo {{ $company->company_name }}"
                            class="tw-h-10 tw-w-auto tw-mr-3">
                        <span class="tw-font-semibold tw-text-lg tw-text-white">{{ $company->company_name }}</span>
                    </div>
                </div>
            </nav>
            <div class="tw-my-8">
                <a href="{{ route('public.job-offers.index', $jobOffer->companyId) }}"
                    class="tw-inline-flex tw-items-center hover:tw-text-orange-800 tw-transition tw-duration-200">
                    <i class="fas fa-arrow-left tw-mr-2"></i>
                    Toutes les offres d'emploi
                </a>
            </div>
            <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden tw-mb-8">
                <div class="tw-bg-gradient-to-r tw-from-orange-400 tw-to-orange-600 tw-px-6 tw-py-8 tw-text-white">
                    <div class="tw-flex tw-items-start tw-justify-between">
                        <div class="tw-flex-1">
                            <h1 class="tw-text-3xl tw-font-bold tw-mb-2">{{ $jobOffer->title }}</h1>
                            <div class="tw-flex tw-items-center tw-space-x-4 tw-text-orange-100">
                                <span class="tw-flex tw-items-center">
                                    <i class="fas fa-building tw-mr-2"></i>
                                    {{ $jobOffer->department }}
                                </span>
                                <span class="tw-flex tw-items-center">
                                    <i class="fas fa-map-marker-alt tw-mr-2"></i>
                                    {{ $jobOffer->location }}
                                </span>
                                <span class="tw-flex tw-items-center">
                                    <i class="fas fa-calendar tw-mr-2"></i>
                                    {{ $jobOffer->type }}
                                </span>
                            </div>
                        </div>
                        <div class="tw-text-right">
                            @if ($jobOffer->salary_range)
                                <p class="tw-text-xl tw-font-semibold tw-mb-1">{{ $jobOffer->salary_range }}</p>
                            @endif
                            <p class="tw-text-orange-100 tw-text-sm">
                                {{ $jobOffer->positions_available }} poste(s) disponible(s)
                            </p>
                        </div>
                    </div>
                </div>

                <div class="tw-px-6 tw-py-4 tw-bg-orange-50 tw-border-b tw-border-orange-200">
                    <div class="tw-flex tw-items-center tw-justify-between">
                        <p class="tw-text-sm tw-text-orange-800">
                            <i class="fas fa-clock tw-mr-2"></i>
                            Candidatures ouvertes jusqu'au {{ $jobOffer->deadline->format('d/m/Y') }}
                        </p>
                        <a href="{{ route('public.job-offers.apply-form', $jobOffer->id) }}"
                            class="tw-bg-orange-500 hover:tw-bg-orange-600 tw-text-white tw-px-6 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                            <i class="fas fa-paper-plane tw-mr-2"></i>
                            Postuler maintenant
                        </a>
                    </div>
                </div>
            </div>

            <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-8">
                {{-- Contenu principal --}}
                <div class="lg:tw-col-span-2 tw-space-y-8">
                    {{-- Description du poste --}}
                    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                            <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900">Description du Poste</h2>
                        </div>
                        <div class="tw-px-6 tw-py-6">
                            <div class="tw-prose tw-prose-gray tw-max-w-none">
                                <div class="tw-whitespace-pre-line tw-text-gray-700">{{ $jobOffer->description }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Exigences --}}
                    @if ($jobOffer->requirements)
                        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                            <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                                <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900">Exigences et Compétences</h2>
                            </div>
                            <div class="tw-px-6 tw-py-6">
                                <div class="tw-prose tw-prose-gray tw-max-w-none">
                                    <div class="tw-whitespace-pre-line tw-text-gray-700">{{ $jobOffer->requirements }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Avantages --}}
                    @if ($jobOffer->benefits)
                        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                            <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                                <h2 class="tw-text-xl tw-font-semibold tw-text-gray-900">Avantages</h2>
                            </div>
                            <div class="tw-px-6 tw-py-6">
                                <div class="tw-prose tw-prose-gray tw-max-w-none">
                                    <div class="tw-whitespace-pre-line tw-text-gray-700">{{ $jobOffer->benefits }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="tw-space-y-6">
                    {{-- Candidature --}}
                    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                        <div class="tw-px-2 tw-py-4 tw-border-b tw-border-gray-200">
                            <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Postuler</h3>
                        </div>
                        <div class="tw-px-2 tw-py-6 tw-space-y-4 tw-text-center">
                            <a href="{{ route('public.job-offers.apply-form', $jobOffer->id) }}"
                                class="tw-w-full tw-bg-orange-500 hover:tw-bg-orange-600 tw-text-white tw-px-6 tw-py-3 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 tw-mb-4">
                                Postuler maintenant
                            </a>
                            <p class="tw-text-xs tw-text-gray-500 tw-text-center mt-4">
                                Votre candidature sera traitée dans les plus brefs délais
                            </p>
                        </div>
                    </div>

                    {{-- Informations sur l'offre --}}
                    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                            <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Informations</h3>
                        </div>
                        <div class="tw-px-6 tw-py-6">
                            <div class="tw-space-y-4">
                                <div>
                                    <span class="tw-text-sm tw-font-medium tw-text-gray-500">Type de contrat</span>
                                    <p class="tw-text-sm tw-text-gray-900 tw-mt-1">{{ $jobOffer->type }}</p>
                                </div>

                                <div>
                                    <span class="tw-text-sm tw-font-medium tw-text-gray-500">Localisation</span>
                                    <p class="tw-text-sm tw-text-gray-900 tw-mt-1">{{ $jobOffer->location }}</p>
                                </div>

                                <div>
                                    <span class="tw-text-sm tw-font-medium tw-text-gray-500">Département</span>
                                    <p class="tw-text-sm tw-text-gray-900 tw-mt-1">{{ $jobOffer->department }}</p>
                                </div>

                                @if ($jobOffer->salary_range)
                                    <div>
                                        <span class="tw-text-sm tw-font-medium tw-text-gray-500">Rémunération</span>
                                        <p class="tw-text-sm tw-text-gray-900 tw-mt-1">{{ $jobOffer->salary_range }}
                                        </p>
                                    </div>
                                @endif

                                <div>
                                    <span class="tw-text-sm tw-font-medium tw-text-gray-500">Date limite</span>
                                    <p class="tw-text-sm tw-text-gray-900 tw-mt-1">
                                        {{ $jobOffer->deadline->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <body>

</html>
