@extends('super-admin.layouts.saas-app')

@section('content')


    @include('super-admin.saas.section.header')
    
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sections Animées</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
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
            from { width: 0 }
            to { width: 100% }
        }
        
        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: #fb923c; }
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
        
        .form-input:focus + .form-label {
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
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        .stagger-5 { animation-delay: 0.5s; }
        .stagger-6 { animation-delay: 0.6s; }
        
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
    <!-- Hero Section -->
    <section id="home" class="tw-min-h-screen tw-flex tw-items-center tw-justify-center tw-bg-[#0c195e] tw-relative tw-overflow-hidden">
        <!-- Particules animées -->
        <div class="particle" style="left: 10%; width: 4px; height: 4px; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; width: 6px; height: 6px; animation-delay: 1s;"></div>
        <div class="particle" style="left: 30%; width: 3px; height: 3px; animation-delay: 2s;"></div>
        <div class="particle" style="left: 40%; width: 5px; height: 5px; animation-delay: 3s;"></div>
        <div class="particle" style="left: 50%; width: 4px; height: 4px; animation-delay: 4s;"></div>
        <div class="particle" style="left: 60%; width: 6px; height: 6px; animation-delay: 5s;"></div>
        <div class="particle" style="left: 70%; width: 3px; height: 3px; animation-delay: 6s;"></div>
        <div class="particle" style="left: 80%; width: 5px; height: 5px; animation-delay: 7s;"></div>
        <div class="particle" style="left: 90%; width: 4px; height: 4px; animation-delay: 8s;"></div>
        
        <div class="tw-absolute tw-inset-0 tw-bg-[#0c195e]"></div>
        <div class="tw-relative tw-z-10 tw-text-center tw-px-4 tw-max-w-4xl tw-mx-auto">
            <div class="floating">
                <i class="fas fa-rocket tw-text-6xl tw-mb-8 tw-text-orange-400"></i>
            </div>
            <h1 class="tw-text-2xl md:tw-text-6xl tw-mb-8 tw-font-bold tw-text-white fade-in ">
                Révolutionnez votre <span class="tw-text-orange-400 typewriter">Expérience</span>
            </h1>
            <p class="tw-text-xl md:tw-text-2xl tw-mb-8 tw-text-white fade-in stagger-1">
                Découvrez la prochaine génération de solutions technologiques qui transforment votre façon de travailler
            </p>
            <div class="tw-flex tw-flex-col sm:tw-flex-row tw-gap-4 tw-justify-center fade-in stagger-2">
                <a href="{{ route('front.signup.index') }}" class="animated-button tw-bg-orange-400 tw-text-white tw-px-8 tw-py-4 tw-rounded-full tw-font-semibold hover:tw-bg-white hover:tw-text-[#0c195e]">
                    Essayer Gratuitement
                </a>
            </div>
        </div>
        <!-- Animated Background Elements -->
        <div class="tw-absolute tw-top-20 tw-left-10 tw-w-20 tw-h-20 tw-bg-orange-400 tw-rounded-full tw-opacity-20 floating"></div>
        <div class="tw-absolute tw-bottom-20 tw-right-10 tw-w-32 tw-h-32 tw-bg-white tw-rounded-full tw-opacity-10 floating" style="animation-delay: 1s;"></div>
        <div class="tw-absolute tw-top-1/2 tw-left-1/4 tw-w-16 tw-h-16 tw-bg-[#0c195e] tw-rounded-full tw-opacity-30 floating" style="animation-delay: 2s;"></div>
    </section>

    <!-- Features Section -->
    <section id="features" class="tw-py-20 tw-bg-white tw-relative">
        <div class="tw-max-w-7xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
            <div class="tw-text-center tw-mb-16 fade-in">
                <h2 class="tw-text-4xl md:tw-text-5xl tw-font-bold tw-mb-4 tw-text-[#0c195e] reveal">Fonctionnalités Avancées</h2>
                <p class="tw-text-xl tw-text-[#0c195e] slide-in-left">Découvrez ce qui nous rend uniques</p>
            </div>
            <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-3 tw-gap-8">
                <div class="feature-card tw-bg-[#f8fafc] tw-p-8 tw-rounded-2xl hover-scale fade-in stagger-1 tw-group">
                    <div class="tw-text-4xl tw-mb-4 feature-icon tw-text-orange-400 tw-transition-all tw-duration-500">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h3 class="tw-text-2xl tw-font-semibold tw-mb-4 tw-text-[#0c195e] tw-transition-all tw-duration-300 group-hover:tw-text-orange-400">Gestion de Projets Simplifiée</h3>
                    <p class="tw-text-[#0c195e] tw-transition-all tw-duration-300 group-hover:tw-text-gray-700">Gardez une vue d'ensemble sur tous vos projets, assignez des tâches et suivez leur avancement en toute simplicité.</p>
                    <div class="tw-w-0 tw-h-1 tw-bg-orange-400 tw-transition-all tw-duration-500 group-hover:tw-w-full tw-mt-4"></div>
                </div>
                
                <div class="feature-card tw-bg-[#f8fafc] tw-p-8 tw-rounded-2xl hover-scale fade-in stagger-2 tw-group">
                    <div class="tw-text-4xl tw-mb-4 feature-icon tw-text-orange-400 tw-transition-all tw-duration-500 group-hover:tw-animate-bounce">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="tw-text-2xl tw-font-semibold tw-mb-4 tw-text-[#0c195e] tw-transition-all tw-duration-300 group-hover:tw-text-orange-400">Collaboration d'Équipe</h3>
                    <p class="tw-text-[#0c195e] tw-transition-all tw-duration-300 group-hover:tw-text-gray-700">Ajoutez des membres à vos projets et gardez toute l'équipe synchronisée avec le progrès en temps réel.</p>
                    <div class="tw-w-0 tw-h-1 tw-bg-orange-400 tw-transition-all tw-duration-500 group-hover:tw-w-full tw-mt-4"></div>
                </div>
                
                <div class="feature-card tw-bg-[#f8fafc] tw-p-8 tw-rounded-2xl hover-scale fade-in stagger-3 tw-group">
                    <div class="tw-text-4xl tw-mb-4 feature-icon tw-text-orange-400 tw-transition-all tw-duration-500 group-hover:tw-animate-spin">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h3 class="tw-text-2xl tw-font-semibold tw-mb-4 tw-text-[#0c195e] tw-transition-all tw-duration-300 group-hover:tw-text-orange-400">Analyse de Workflow</h3>
                    <p class="tw-text-[#0c195e] tw-transition-all tw-duration-300 group-hover:tw-text-gray-700">Analysez ce qui fonctionne ou non grâce à des rapports détaillés sur vos revenus, dépenses, tâches et tickets.</p>
                    <div class="tw-w-0 tw-h-1 tw-bg-orange-400 tw-transition-all tw-duration-500 group-hover:tw-w-full tw-mt-4"></div>
                </div>
                
                <div class="feature-card tw-bg-[#f8fafc] tw-p-8 tw-rounded-2xl hover-scale fade-in stagger-4 tw-group">
                    <div class="tw-text-4xl tw-mb-4 feature-icon tw-text-orange-400 tw-transition-all tw-duration-500 group-hover:tw-animate-pulse">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <h3 class="tw-text-2xl tw-font-semibold tw-mb-4 tw-text-[#0c195e] tw-transition-all tw-duration-300 group-hover:tw-text-orange-400">Gestion des Tickets de Support</h3>
                    <p class="tw-text-[#0c195e] tw-transition-all tw-duration-300 group-hover:tw-text-gray-700">Centralisez les demandes de support, attribuez-les aux bons agents et suivez leur résolution efficacement.</p>
                    <div class="tw-w-0 tw-h-1 tw-bg-orange-400 tw-transition-all tw-duration-500 group-hover:tw-w-full tw-mt-4"></div>
                </div>
                
                <div class="feature-card tw-bg-[#f8fafc] tw-p-8 tw-rounded-2xl hover-scale fade-in stagger-5 tw-group">
                    <div class="tw-text-4xl tw-mb-4 feature-icon tw-text-orange-400 tw-transition-all tw-duration-500 group-hover:tw-animate-bounce">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3 class="tw-text-2xl tw-font-semibold tw-mb-4 tw-text-[#0c195e] tw-transition-all tw-duration-300 group-hover:tw-text-orange-400">Satisfaction Client & Rentabilité</h3>
                    <p class="tw-text-[#0c195e] tw-transition-all tw-duration-300 group-hover:tw-text-gray-700">Des équipes responsabilisées, des clients satisfaits et une rentabilité accrue grâce à une gestion centralisée.</p>
                    <div class="tw-w-0 tw-h-1 tw-bg-orange-400 tw-transition-all tw-duration-500 group-hover:tw-w-full tw-mt-4"></div>
                </div>
                
                <div class="feature-card tw-bg-[#f8fafc] tw-p-8 tw-rounded-2xl hover-scale fade-in stagger-6 tw-group">
                    <div class="tw-text-4xl tw-mb-4 feature-icon tw-text-orange-400 tw-transition-all tw-duration-500 group-hover:tw-animate-spin">
                        <i class="fas fa-sync"></i>
                    </div>
                    <h3 class="tw-text-2xl tw-font-semibold tw-mb-4 tw-text-[#0c195e] tw-transition-all tw-duration-300 group-hover:tw-text-orange-400">Synchronisation & Suivi en Temps Réel</h3>
                    <p class="tw-text-[#0c195e] tw-transition-all tw-duration-300 group-hover:tw-text-gray-700">Gardez toutes vos données et équipes alignées avec une synchronisation instantanée et un suivi continu.</p>
                    <div class="tw-w-0 tw-h-1 tw-bg-orange-400 tw-transition-all tw-duration-500 group-hover:tw-w-full tw-mt-4"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="tw-bg-[#0c195e] tw-py-20 tw-relative tw-overflow-hidden">
        <div class="tw-max-w-5xl tw-mx-auto tw-px-4">
            <div class="tw-text-center tw-mb-12">
                <h2 class="tw-text-4xl tw-font-bold tw-text-white reveal">@lang('Ce que disent nos clients')</h2>
                <p class="tw-text-xl tw-text-orange-400 slide-in-right">@lang('Des entreprises de toutes tailles nous font confiance')</p>
            </div>
            <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-8">
                <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-p-8 fade-in stagger-1 hover-scale">
                    <div class="tw-flex tw-items-center tw-mb-4">
                        <div>
                            <div class="tw-font-semibold tw-text-[#0c195e]">Sophie Martin</div>
                            <div class="tw-text-sm tw-text-gray-400">@lang('CEO, StartUpX')</div>
                        </div>
                    </div>
                    <p class="tw-text-[#0c195e] tw-mb-4">“@lang('Une plateforme intuitive qui a transformé notre gestion de projet. Support réactif et fonctionnalités puissantes!')”</p>
                    <div class="tw-flex tw-gap-1">
                        <i class="fas fa-star tw-text-orange-400"></i>
                        <i class="fas fa-star tw-text-orange-400"></i>
                        <i class="fas fa-star tw-text-orange-400"></i>
                        <i class="fas fa-star tw-text-orange-400"></i>
                        <i class="fas fa-star-half-alt tw-text-orange-400"></i>
                    </div>
                </div>
                <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-p-8 fade-in stagger-2 hover-scale">
                    <div class="tw-flex tw-items-center tw-mb-4">
                        <div>
                            <div class="tw-font-semibold tw-text-[#0c195e]">Lucas Dubois</div>
                            <div class="tw-text-sm tw-text-gray-400">@lang('Responsable IT, AgenceWeb')</div>
                        </div>
                    </div>
                    <p class="tw-text-[#0c195e] tw-mb-4">“@lang('La synchronisation en temps réel nous a permis de gagner un temps précieux. Je recommande vivement!')”</p>
                    <div class="tw-flex tw-gap-1">
                        <i class="fas fa-star tw-text-orange-400"></i>
                        <i class="fas fa-star tw-text-orange-400"></i>
                        <i class="fas fa-star tw-text-orange-400"></i>
                        <i class="fas fa-star tw-text-orange-400"></i>
                        <i class="fas fa-star tw-text-orange-400"></i>
                    </div>
                </div>
                <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-p-8 fade-in stagger-3 hover-scale">
                    <div class="tw-flex tw-items-center tw-mb-4">
                        <div>
                            <div class="tw-font-semibold tw-text-[#0c195e]">Emma Leroy</div>
                            <div class="tw-text-sm tw-text-gray-400">@lang('Directrice, Leroy Consulting')</div>
                        </div>
                    </div>
                    <p class="tw-text-[#0c195e] tw-mb-4">“@lang('Un outil complet et facile à prendre en main. Nos équipes sont plus productives que jamais!')”</p>
                    <div class="tw-flex tw-gap-1">
                        <i class="fas fa-star tw-text-orange-400"></i>
                        <i class="fas fa-star tw-text-orange-400"></i>
                        <i class="fas fa-star tw-text-orange-400"></i>
                        <i class="fas fa-star tw-text-orange-400"></i>
                        <i class="fas fa-star tw-text-orange-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Animated Stats Section -->
    <section id="stats" class="tw-bg-white tw-py-20 tw-relative">
        <div class="tw-max-w-6xl tw-mx-auto tw-px-4">
            <div class="tw-text-center tw-mb-12">
                <h2 class="tw-text-4xl tw-font-bold tw-text-[#0c195e] reveal">@lang('Nos chiffres clés')</h2>
                <p class="tw-text-xl tw-text-[#0c195e] slide-in-left">@lang('Des résultats qui parlent d\'eux-mêmes')</p>
            </div>
            <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-4 tw-gap-8">
                <div class="tw-bg-[#f8fafc] tw-rounded-2xl tw-p-8 tw-text-center fade-in stagger-1">
                    <div class="tw-text-5xl tw-font-bold tw-text-orange-400 counter" data-target="1200">0</div>
                    <div class="tw-mt-2 tw-text-[#0c195e] tw-font-semibold">@lang('Entreprises clientes')</div>
                </div>
                <div class="tw-bg-[#f8fafc] tw-rounded-2xl tw-p-8 tw-text-center fade-in stagger-2">
                    <div class="tw-text-5xl tw-font-bold tw-text-orange-400 counter" data-target="98">0</div>
                    <div class="tw-mt-2 tw-text-[#0c195e] tw-font-semibold">@lang('Satisfaction (%)')</div>
                </div>
                <div class="tw-bg-[#f8fafc] tw-rounded-2xl tw-p-8 tw-text-center fade-in stagger-3">
                    <div class="tw-text-5xl tw-font-bold tw-text-orange-400 counter" data-target="25000">0</div>
                    <div class="tw-mt-2 tw-text-[#0c195e] tw-font-semibold">@lang('Utilisateurs actifs')</div>
                </div>
                <div class="tw-bg-[#f8fafc] tw-rounded-2xl tw-p-8 tw-text-center fade-in stagger-4">
                    <div class="tw-text-5xl tw-font-bold tw-text-orange-400 counter" data-target="4.9">0</div>
                    <div class="tw-mt-2 tw-text-[#0c195e] tw-font-semibold">@lang('Note moyenne')</div>
                </div>
            </div>
        </div>
        <script>
            // Compteur animé pour les statistiques
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.counter').forEach(function(counter) {
                    const target = parseFloat(counter.getAttribute('data-target'));
                    let current = 0;
                    const duration = 2000;
                    const step = Math.max(1, target / (duration / 16));
                    function updateCounter() {
                        if (current < target) {
                            current += step;
                            counter.textContent = target % 1 === 0 ? Math.floor(current) : current.toFixed(1);
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = target;
                        }
                    }
                    updateCounter();
                });
            });
        </script>
    </section>

    <!-- Contact Section -->
    <script>
        // Animation d'observation pour les éléments
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observer tous les éléments avec classes d'animation
        document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right, .reveal').forEach(el => {
            observer.observe(el);
        });

        // Animation de particules au scroll
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.floating');
            
            parallaxElements.forEach((element, index) => {
                const speed = 0.2 + (index * 0.1);
                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
        });

        // Animation de frappe pour le texte
        document.addEventListener('DOMContentLoaded', function() {
            const typewriterElement = document.querySelector('.typewriter');
            if (typewriterElement) {
                setTimeout(() => {
                    typewriterElement.style.borderRight = 'none';
                }, 4000);
            }
        });

        // Effet de pulsation sur les icônes au survol
        document.querySelectorAll('.feature-icon').forEach(icon => {
            icon.addEventListener('mouseenter', function() {
                this.style.animation = 'pulse 0.5s ease-in-out';
            });
            
            icon.addEventListener('animationend', function() {
                this.style.animation = '';
            });
        });

        // Animation du formulaire
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (this.value === '') {
                    this.parentElement.classList.remove('focused');
                }
            });
        });

        // Effet de ripple sur les boutons
        document.querySelectorAll('.animated-button').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255, 255, 255, 0.6)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s linear';
                ripple.style.pointerEvents = 'none';
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Animation CSS pour l'effet ripple
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Animation de compteur pour les statistiques (si vous en ajoutez)
        function animateCounter(element, target, duration = 2000) {
            let start = 0;
            const increment = target / (duration / 16);
            
            const timer = setInterval(() => {
                start += increment;
                element.textContent = Math.floor(start);
                
                if (start >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                }
            }, 16);
        }

        // Parallaxe pour l'arrière-plan
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroSection = document.getElementById('home');
            
            if (heroSection) {
                heroSection.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });

        // Animation des icônes sociales
        document.querySelectorAll('.social-icon').forEach((icon, index) => {
            icon.addEventListener('mouseenter', function() {
                this.style.animationDelay = `${index * 0.1}s`;
                this.classList.add('tw-animate-bounce');
            });
            
            icon.addEventListener('mouseleave', function() {
                this.classList.remove('tw-animate-bounce');
            });
        });

        // Effet de machine à écrire pour le sous-titre
        function typeWriter(element, text, speed = 100) {
            let i = 0;
            element.innerHTML = '';
            
            function typing() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(typing, speed);
                }
            }
            typing();
        }

        // Animation de révélation progressive au scroll
        const revealElements = document.querySelectorAll('.feature-card');
        revealElements.forEach((element, index) => {
            element.style.transitionDelay = `${index * 0.1}s`;
        });

        // Effet de survol sophistiqué pour les cartes
        document.querySelectorAll('.feature-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.background = 'linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.background = '#f8fafc';
            });
        });

        // Animation fluide lors du changement de section
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Gestion du redimensionnement de la fenêtre pour les animations
        window.addEventListener('resize', () => {
            // Recalculer les positions pour les animations responsives
            document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right').forEach(el => {
                if (el.classList.contains('visible')) {
                    el.style.transform = 'none';
                }
            });
        });

        // Animation de chargement de page
        window.addEventListener('load', () => {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease-in-out';
            
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });

        // Effet de pulsation sur les éléments importants
        setInterval(() => {
            document.querySelectorAll('.pulse-glow').forEach(element => {
                element.style.animation = 'none';
                element.offsetHeight; // Trigger reflow
                element.style.animation = 'pulseGlow 2s ease-in-out infinite alternate';
            });
        }, 4000);
    </script>

@endsection
@push('footer-script')
    <script>
        $(document).ready(function () {
            const maxHeight = Math.max(...$('.planNameHead').map(function () {
                return $(this).height();
            }));

            $('.planNameHead').height(Math.round(maxHeight)).next('.planNameTitle').height(Math.round(maxHeight - 28));
        });

        function planShow(type) {
            $('#monthlyPlan').toggle(type === 'monthly');
            $('#annualPlan').toggle(type !== 'monthly');
        }

    </script>

@endpush
