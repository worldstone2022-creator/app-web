@extends('super-admin.layouts.saas-app')

@section('header-section')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        .gradient-text {
            background: linear-gradient(135deg, #fb923c 0%, #0c195e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-card {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(251, 146, 60, 0.1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(12, 25, 94, 0.1);
            border-color: #fb923c;
        }

        .feature-icon {
            background: linear-gradient(135deg, #fb923c 0%, #0c195e 100%);
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            color: white;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
            box-shadow: 0 10px 30px rgba(251, 146, 60, 0.3);
        }

        .integrate-card {
            transition: all 0.3s ease;
            background: white;
            border: 2px solid transparent;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .integrate-card:hover {
            transform: translateY(-8px);
            border-color: #fb923c;
            box-shadow: 0 15px 40px rgba(251, 146, 60, 0.15);
        }

        .integrate-image {
            width: 64px;
            height: 64px;
            object-fit: contain;
            margin: 0 auto 1rem;
            transition: all 0.3s ease;
        }

        .integrate-card:hover .integrate-image {
            transform: scale(1.1);
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stagger-1 {
            transition-delay: 0.1s;
        }

        .stagger-2 {
            transition-delay: 0.2s;
        }

        .stagger-3 {
            transition-delay: 0.3s;
        }

        .stagger-4 {
            transition-delay: 0.4s;
        }

        .stagger-5 {
            transition-delay: 0.5s;
        }

        .stagger-6 {
            transition-delay: 0.6s;
        }

        .wave-bg {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            position: relative;
            overflow: hidden;
        }

        .wave-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='%23fb923c' fill-opacity='0.1'%3E%3C/path%3E%3C/svg%3E") no-repeat;
            background-size: cover;
            opacity: 0.3;
        }
    </style>
    @include('super-admin.saas.section.breadcrumb')
@endsection

@section('content')

   <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features & Integration Section</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #fb923c 0%, #0c195e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .feature-card {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(251, 146, 60, 0.1);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(12, 25, 94, 0.1);
            border-color: #fb923c;
        }
        
        .feature-icon {
            background: linear-gradient(135deg, #fb923c 0%, #0c195e 100%);
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            color: white;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1);
            box-shadow: 0 10px 30px rgba(251, 146, 60, 0.3);
        }
        
        .integrate-card {
            transition: all 0.3s ease;
            background: white;
            border: 2px solid transparent;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        
        .integrate-card:hover {
            transform: translateY(-8px);
            border-color: #fb923c;
            box-shadow: 0 15px 40px rgba(251, 146, 60, 0.15);
        }
        
        .integrate-image {
            width: 64px;
            height: 64px;
            object-fit: contain;
            margin: 0 auto 1rem;
            transition: all 0.3s ease;
        }
        
        .integrate-card:hover .integrate-image {
            transform: scale(1.1);
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .stagger-1 { transition-delay: 0.1s; }
        .stagger-2 { transition-delay: 0.2s; }
        .stagger-3 { transition-delay: 0.3s; }
        .stagger-4 { transition-delay: 0.4s; }
        .stagger-5 { transition-delay: 0.5s; }
        .stagger-6 { transition-delay: 0.6s; }
        
        .wave-bg {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            position: relative;
            overflow: hidden;
        }
        
        .wave-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='%23fb923c' fill-opacity='0.1'%3E%3C/path%3E%3C/svg%3E") no-repeat;
            background-size: cover;
            opacity: 0.3;
        }
    </style>
</head>
<body class="tw-bg-gray-50">
    @forelse($frontFeatures as $frontFeature)
        <!-- Features Section -->
        <section class="wave-bg tw-py-20 tw-border-b tw-border-gray-100 tw-relative">
            <div class="tw-container tw-mx-auto tw-px-4 tw-max-w-7xl tw-relative tw-z-10">
                <div class="tw-flex tw-justify-center tw-mb-16">
                    <div class="tw-w-full tw-text-center fade-in">
                        <div class="tw-mb-8">
                            <h3 class="tw-text-4xl md:tw-text-5xl tw-font-bold tw-mb-4 gradient-text">{{ $frontFeature->title }}</h3>
                            <div class="tw-text-xl tw-text-gray-600 tw-max-w-3xl tw-mx-auto tw-leading-relaxed">
                                {!! $frontFeature->description !!}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-3 tw-gap-8">
                    @forelse($frontFeature->features as $index => $feature)
                        <div class="fade-in stagger-{{ ($index % 6) + 1 }}">
                            @if($feature->type != 'image')
                                <div class="feature-card tw-rounded-2xl tw-p-8 tw-text-center tw-h-full">
                                    <div class="feature-icon">
                                        <i class="{{ $feature->icon }}"></i>
                                    </div>
                                    <h5 class="tw-text-xl tw-font-bold tw-text-gray-800 tw-mb-4">{{ $feature->title }}</h5>
                                    <div class="tw-text-gray-600 tw-leading-relaxed">{!! $feature->description !!}</div>
                                </div>
                            @else
                                <div class="integrate-card tw-h-full">
                                    <img src="{{ $feature->image_url }}" alt="{{ $feature->title }}" class="integrate-image tw-block">
                                    <h5 class="tw-text-xl tw-font-bold tw-text-gray-800 tw-mb-0">{{ $feature->title }}</h5>
                                </div>
                            @endif
                        </div>
                    @empty
                        <!-- Features par défaut si vide -->
                        <div class="fade-in stagger-1">
                            <div class="feature-card tw-rounded-2xl tw-p-8 tw-text-center tw-h-full">
                                <div class="feature-icon">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <h5 class="tw-text-xl tw-font-bold tw-text-gray-800 tw-mb-4">Performance Rapide</h5>
                                <div class="tw-text-gray-600 tw-leading-relaxed">Optimisé pour une vitesse maximale et une expérience utilisateur fluide.</div>
                            </div>
                        </div>
                        
                        <div class="fade-in stagger-2">
                            <div class="feature-card tw-rounded-2xl tw-p-8 tw-text-center tw-h-full">
                                <div class="feature-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h5 class="tw-text-xl tw-font-bold tw-text-gray-800 tw-mb-4">Sécurité Avancée</h5>
                                <div class="tw-text-gray-600 tw-leading-relaxed">Protection de niveau enterprise avec cryptage de bout en bout.</div>
                            </div>
                        </div>
                        
                        <div class="fade-in stagger-3">
                            <div class="feature-card tw-rounded-2xl tw-p-8 tw-text-center tw-h-full">
                                <div class="feature-icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <h5 class="tw-text-xl tw-font-bold tw-text-gray-800 tw-mb-4">Automatisation</h5>
                                <div class="tw-text-gray-600 tw-leading-relaxed">Automatisez vos tâches répétitives et gagnez du temps précieux.</div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    @empty
    @endforelse

    <!-- Integration Section -->
    <section class="tw-py-20 tw-bg-white">
        <div class="tw-container tw-mx-auto tw-px-4 tw-max-w-7xl">
            <div class="tw-flex tw-justify-center tw-mb-16">
                <div class="tw-w-full tw-text-center fade-in">
                    <div class="tw-mb-8">
                        <h3 class="tw-text-4xl md:tw-text-5xl tw-font-bold tw-mb-4 gradient-text">{{ $trFrontDetail->favourite_apps_title }}</h3>
                        <p class="tw-text-xl tw-text-gray-600 tw-max-w-3xl tw-mx-auto">{{ $trFrontDetail->favourite_apps_detail }}</p>
                    </div>
                </div>
            </div>
            
            <div class="tw-grid tw-grid-cols-2 md:tw-grid-cols-3 lg:tw-grid-cols-4 xl:tw-grid-cols-6 tw-gap-6">
                @forelse($featureApps as $index => $featureApp)
                    <div class="fade-in stagger-{{ ($index % 6) + 1 }}">
                        <div class="integrate-card">
                            <img src="{{ $featureApp->image_url }}" alt="{{ $featureApp->title }}" class="integrate-image tw-block">
                            <h5 class="tw-text-lg tw-font-semibold tw-text-gray-800 tw-mb-0 tw-leading-tight">{{ $featureApp->title }}</h5>
                        </div>
                    </div>
                @empty
                    <!-- Applications par défaut si vide -->
                    <div class="fade-in stagger-1">
                        <div class="integrate-card">
                            <div class="tw-w-16 tw-h-16 tw-mx-auto tw-mb-4 tw-bg-gradient-to-br tw-from-orange-400 tw-to-blue-900 tw-rounded-xl tw-flex tw-items-center tw-justify-center">
                                <i class="fab fa-slack tw-text-white tw-text-2xl"></i>
                            </div>
                            <h5 class="tw-text-lg tw-font-semibold tw-text-gray-800 tw-mb-0">Slack</h5>
                        </div>
                    </div>
                    
                    <div class="fade-in stagger-2">
                        <div class="integrate-card">
                            <div class="tw-w-16 tw-h-16 tw-mx-auto tw-mb-4 tw-bg-gradient-to-br tw-from-orange-400 tw-to-blue-900 tw-rounded-xl tw-flex tw-items-center tw-justify-center">
                                <i class="fab fa-google tw-text-white tw-text-2xl"></i>
                            </div>
                            <h5 class="tw-text-lg tw-font-semibold tw-text-gray-800 tw-mb-0">Google</h5>
                        </div>
                    </div>
                    
                    <div class="fade-in stagger-3">
                        <div class="integrate-card">
                            <div class="tw-w-16 tw-h-16 tw-mx-auto tw-mb-4 tw-bg-gradient-to-br tw-from-orange-400 tw-to-blue-900 tw-rounded-xl tw-flex tw-items-center tw-justify-center">
                                <i class="fab fa-microsoft tw-text-white tw-text-2xl"></i>
                            </div>
                            <h5 class="tw-text-lg tw-font-semibold tw-text-gray-800 tw-mb-0">Microsoft</h5>
                        </div>
                    </div>
                    
                    <div class="fade-in stagger-4">
                        <div class="integrate-card">
                            <div class="tw-w-16 tw-h-16 tw-mx-auto tw-mb-4 tw-bg-gradient-to-br tw-from-orange-400 tw-to-blue-900 tw-rounded-xl tw-flex tw-items-center tw-justify-center">
                                <i class="fab fa-dropbox tw-text-white tw-text-2xl"></i>
                            </div>
                            <h5 class="tw-text-lg tw-font-semibold tw-text-gray-800 tw-mb-0">Dropbox</h5>
                        </div>
                    </div>
                    
                    <div class="fade-in stagger-5">
                        <div class="integrate-card">
                            <div class="tw-w-16 tw-h-16 tw-mx-auto tw-mb-4 tw-bg-gradient-to-br tw-from-orange-400 tw-to-blue-900 tw-rounded-xl tw-flex tw-items-center tw-justify-center">
                                <i class="fab fa-github tw-text-white tw-text-2xl"></i>
                            </div>
                            <h5 class="tw-text-lg tw-font-semibold tw-text-gray-800 tw-mb-0">GitHub</h5>
                        </div>
                    </div>
                    
                    <div class="fade-in stagger-6">
                        <div class="integrate-card">
                            <div class="tw-w-16 tw-h-16 tw-mx-auto tw-mb-4 tw-bg-gradient-to-br tw-from-orange-400 tw-to-blue-900 tw-rounded-xl tw-flex tw-items-center tw-justify-center">
                                <i class="fab fa-trello tw-text-white tw-text-2xl"></i>
                            </div>
                            <h5 class="tw-text-lg tw-font-semibold tw-text-gray-800 tw-mb-0">Trello</h5>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <script>
        // Fade in animation on scroll
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

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Parallax effect for wave background
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.wave-bg::before');
            
            parallaxElements.forEach(element => {
                const speed = 0.3;
                const yPos = -(scrolled * speed);
                if (element.style) {
                    element.style.transform = `translateY(${yPos}px)`;
                }
            });
        });

        // Add loading animation
        window.addEventListener('load', () => {
            document.body.classList.add('loaded');
        });

        // Stagger animation for cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.feature-card, .integrate-card');
            
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
@endsection
@push('footer-script')
@endpush
