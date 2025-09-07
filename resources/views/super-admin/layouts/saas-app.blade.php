<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <title> {{ __(isset($seoDetail) ? $seoDetail->seo_title : $pageTitle) }}
        | {{ global_setting()->global_app_name }}</title>

    <meta name="description" content="{{ isset($seoDetail) ? $seoDetail->seo_description : '' }}">
    <meta name="author" content="{{ isset($seoDetail) ? $seoDetail->seo_author : '' }}">
    <meta name="keywords" content="{{ isset($seoDetail) ? $seoDetail->seo_keywords : '' }}">

    <meta property="og:title" content="{{ isset($seoDetail) ? $seoDetail->seo_title : '' }}">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:site_name" content="{{ global_setting()->global_app_name }}" />
    <meta property="og:description" content="{{ isset($seoDetail) ? $seoDetail->seo_description : '' }}">
    <meta property="og:image" content="{{ isset($seoDetail) ? $seoDetail->og_image_url : '' }}" />

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ global_setting()->favicon_url }}">
    <meta name="msapplication-TileImage" content="{{ global_setting()->favicon_url }}">

    <!-- Bootstrap CSS -->
    <link type="text/css" rel="stylesheet" media="all"
        href="{{ asset('saas/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet" media="all"
        href="{{ asset('saas/vendor/animate-css/animate.min.css') }}">
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('saas/vendor/slick/slick.css') }}">
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('saas/vendor/slick/slick-theme.css') }}">
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('saas/fonts/flaticon/flaticon.css') }}">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap-icons.css') }}">
    <!-- Template CSS -->
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('saas/css/main.css') }}">
    <!-- Template Font Family  -->

    <link type="text/css" rel="stylesheet" media="all"
        href="{{ asset('saas/vendor/material-design-iconic-font/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('saas/css/cookieconsent.css') }}" media="print" onload="this.media='all'">
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('saas/css/quill.snow.css') }}">
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('saas/css/saas-rtl.css') }}">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

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


    <script src="https://www.google.com/recaptcha/api.js"></script>
    <style>
        {!! $frontDetail->custom_css_theme_two !!} :root {
            --main-color: {{ $frontDetail->primary_color }};
            --main-home-background: {{ $frontDetail->background_color }};
        }

        /*To be removed to next 3.6.8 update. Added so as cached main.css to show background image on load*/
        .section-hero .banner::after {
            position: absolute;
            content: '';
            left: 0;
            top: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            background-color: #CDDCDC;
            background-image: radial-gradient(at 50% 100%, rgba(255, 255, 255, 0.50) 0%, rgba(0, 0, 0, 0.50) 100%), linear-gradient(to bottom, rgba(255, 255, 255, 0.25) 0%, rgba(0, 0, 0, 0.25) 100%);
            background-blend-mode: screen, overlay;
            opacity: 0.95;
            padding-bottom: 400px;
        }

        .help-block {
            color: #8a1f11 !important;
        }

        .login-box h5 {
            padding: 35px 40px 15px;
            font-size: 21px;
            text-align: center;
            font-weight: 600;
        }

        @media (max-width: 767px) {
            .login-box form {
                padding: 10px;
            }

            .input-group-text {
                font-size: 13px;
            }

            .login-box h5 {
                padding: 35px 15px 15px;
                font-size: 21px;
                text-align: center;
                font-weight: 600;
            }
        }

        .form-group label sup {
            color: #fd0202;
            top: 0px;
        }

        .f-14 {
            font-size: 14px !important;
        }
    </style>

    @if ($frontDetail->homepage_background != 'default')

        @if ($frontDetail->homepage_background == 'image' || $frontDetail->homepage_background == 'image_and_color')
            <style>
                .section-hero .banner {
                    background: url("{!! $frontDetail->background_image_url !!}") center center/cover no-repeat !important;
                }
            </style>
        @endif
        @if ($frontDetail->homepage_background == 'image')
            <style>
                .section-hero .banner::after {
                    background-color: unset !important;
                }
            </style>
        @endif

        @if ($frontDetail->homepage_background == 'color' || $frontDetail->homepage_background == 'image_and_color')
            <style>
                .section-hero .banner::after {
                    background-color: {{ $frontDetail->background_color }} !important;
                }

                .breadcrumb-section {
                    background-color: {{ $frontDetail->background_color }}30 !important;
                }
            </style>
        @endif

    @endif

    @foreach ($frontWidgets as $item)
        @if (!is_null($item->header_script))
            {!! $item->header_script !!}
        @endif
    @endforeach

    @stack('head-script')

</head>

<body id="home"
    class="{{ isRtl() ? (session('changedRtl') === false ? '' : 'rtl') : (session('changedRtl') == true ? 'rtl' : '') }}">

    @include('super-admin.sections.saas.saas_header')

    @yield('header-section')

    @yield('content')

    @include('super-admin.saas.section.cta')

    @include('super-admin.sections.saas.saas_footer')

    <!-- Scripts -->
    <script src="{{ asset('saas/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('saas/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('saas/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('saas/vendor/wowjs/wow.min.js') }}"></script>
    <script src="{{ asset('saas/js/main.js') }}"></script>
    <script src="{{ asset('front/plugin/froiden-helper/helper.js') }}"></script>

    <!-- Global Required JS -->
    @foreach ($frontWidgets as $item)
        @if (!is_null($item->footer_script))
            {!! $item->footer_script !!}
        @endif
    @endforeach

    @stack('footer-script')

    @includeIf('super-admin.sections.cookie-consent')

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('tw-hidden');
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
                // Close mobile menu if open
                mobileMenu.classList.add('tw-hidden');
            });
        });

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

        // Modal functionality
        const privacyModal = document.getElementById('privacy-modal');
        const termsModal = document.getElementById('terms-modal');
        const closePrivacy = document.getElementById('close-privacy');
        const closeTerms = document.getElementById('close-terms');

        // Open modals
        document.querySelector('a[href="#privacy"]').addEventListener('click', (e) => {
            e.preventDefault();
            privacyModal.classList.remove('tw-hidden');
        });

        document.querySelector('a[href="#terms"]').addEventListener('click', (e) => {
            e.preventDefault();
            termsModal.classList.remove('tw-hidden');
        });

        // Close modals
        closePrivacy.addEventListener('click', () => {
            privacyModal.classList.add('tw-hidden');
        });

        closeTerms.addEventListener('click', () => {
            termsModal.classList.add('tw-hidden');
        });

        // Close modals when clicking outside
        privacyModal.addEventListener('click', (e) => {
            if (e.target === privacyModal) {
                privacyModal.classList.add('tw-hidden');
            }
        });

        termsModal.addEventListener('click', (e) => {
            if (e.target === termsModal) {
                termsModal.classList.add('tw-hidden');
            }
        });

        // Form submission
        document.querySelector('form').addEventListener('submit', (e) => {
            e.preventDefault();

            // Simple form validation
            const inputs = e.target.querySelectorAll('input, textarea');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('tw-border-red-500');
                    isValid = false;
                } else {
                    input.classList.remove('tw-border-red-500');
                }
            });

            if (isValid) {
                // Simulate form submission
                const button = e.target.querySelector('button');
                const originalText = button.textContent;
                button.textContent = 'Envoi en cours...';
                button.disabled = true;

                setTimeout(() => {
                    button.textContent = 'Message envoyé !';
                    button.classList.remove('tw-from-purple-500', 'tw-to-pink-500');
                    button.classList.add('tw-bg-green-500');

                    setTimeout(() => {
                        button.textContent = originalText;
                        button.disabled = false;
                        button.classList.add('tw-from-purple-500', 'tw-to-pink-500');
                        button.classList.remove('tw-bg-green-500');
                        e.target.reset();
                    }, 2000);
                }, 1500);
            }
        });

        // Navbar background on scroll
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                /* nav.style.backgroundColor = 'rgba(17, 24, 39, 0.9)'; */
            } else {
                /* nav.style.backgroundColor = 'rgba(255, 255, 255, 0.1)'; */
            }
        });

        // Parallax effect for hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.floating');

            parallaxElements.forEach((element, index) => {
                const speed = 0.5 + (index * 0.1);
                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
        });

        // Counter animation for pricing
        const animateCounter = (element, target) => {
            let current = 0;
            const increment = target / 100;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current);
            }, 20);
        };

        // Trigger counter animation when pricing section is visible
        const pricingSection = document.getElementById('pricing');
        const pricingObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const priceElements = entry.target.querySelectorAll('.tw-text-4xl');
                    priceElements.forEach(el => {
                        const price = parseInt(el.textContent.replace('€', ''));
                        if (price) {
                            el.textContent = '€0';
                            animateCounter(el, price);
                        }
                    });
                    pricingObserver.unobserve(entry.target);
                }
            });
        });

        pricingObserver.observe(pricingSection);

        // Add loading animation
        window.addEventListener('load', () => {
            document.body.classList.add('loaded');
        });
    </script>

</body>

</html>
