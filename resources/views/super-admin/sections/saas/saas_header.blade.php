<!-- START Header -->
<header>

    <!-- START Header -->
    <header>

        <nav class="tw-fixed tw-top-0 tw-w-full tw-z-50 glass-effect tw-bg-white tw-shadow-md">
            <div class="tw-max-w-7xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
                <div class="tw-flex tw-justify-between tw-h-16">
                    <div class="tw-flex tw-items-center">
                        <div class="tw-flex-shrink-0">
                            <a class="logo" href="{{ route('front.home') }}">
                                <div class="tw-flex tw-items-center">
                                    <img class="tw-mr-2 tw-rounded tw-max-h-10"
                                        src="{{ global_setting()->logo_front_url }}" alt="Logo" />
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="tw-hidden md:tw-flex tw-items-center tw-space-x-8">
                        <a class="hover:tw-text-orange-400 tw-transition-colors tw-text-gray-700"
                            href="{{ route('front.home') }}">{{ $frontMenu->home }}</a>
                        <a class="hover:tw-text-orange-400 tw-transition-colors tw-text-gray-700"
                            href="{{ route('front.feature') }}">{{ $frontMenu->feature }}</a>
                        <a class="hover:tw-text-orange-400 tw-transition-colors tw-text-gray-700"
                            href="{{ route('front.pricing') }}">{{ $frontMenu->price }}</a>
                        <a class="hover:tw-text-orange-400 tw-transition-colors tw-text-gray-700"
                            href="{{ route('front.contact') }}">{{ $frontMenu->contact }}</a>
                        <button
                            class=" tw-px-4 tw-py-2 tw-rounded-full hover:tw-shadow-lg tw-transition-all tw-text-white">
                            Commencer
                        </button>
                    </div>
                    <div class="md:tw-hidden tw-flex tw-items-center">
                        <button id="mobile-menu-btn" class="tw-text-gray-700">
                            <i class="fa fa-bars tw-text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="tw-hidden md:tw-hidden glass-effect">
                <div class="tw-px-2 tw-pt-2 tw-pb-3 tw-space-y-1">
                    <a href="{{ route('front.home') }}"
                        class="tw-block tw-px-3 tw-py-2 hover:tw-bg-orange-400 tw-rounded tw-text-gray-700 hover:tw-text-white tw-transition-all">Accueil</a>
                    <a href="{{ route('front.feature') }}"
                        class="tw-block tw-px-3 tw-py-2 hover:tw-bg-orange-400 tw-rounded tw-text-gray-700 hover:tw-text-white tw-transition-all">Fonctionnalités</a>
                    <a href="{{ route('front.pricing') }}"
                        class="tw-block tw-px-3 tw-py-2 hover:tw-bg-orange-400 tw-rounded tw-text-gray-700 hover:tw-text-white tw-transition-all">Tarification</a>
                    <a href="{{ route('front.contact') }}"
                        class="tw-block tw-px-3 tw-py-2 hover:tw-bg-orange-400 tw-rounded tw-text-gray-700 hover:tw-text-white tw-transition-all">Contact</a>
                </div>
            </div>
        </nav>

        <script>
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('tw-hidden');
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!mobileMenuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                    mobileMenu.classList.add('tw-hidden');
                }
            });

            // Close mobile menu when clicking on a link
            const mobileLinks = mobileMenu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('tw-hidden');
                });
            });
        </script>

    </header>
    <!-- END Header -->


    <!-- START Navigation -->
    <nav class="tw-fixed tw-top-0 tw-w-full tw-z-50 glass-effect tw-bg-white tw-shadow-md">
        <div class="tw-max-w-7xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
            <div class="tw-flex tw-justify-between tw-h-16">
                <div class="tw-flex tw-items-center">
                    <div class="tw-flex-shrink-0">
                        <a class="logo" href="{{ route('front.home') }}">
                            <div class="d-flex align-items-center">
                                <img class="mr-2 rounded logo-default" style="max-height: 32px;"
                                    src="{{ global_setting()->logo_front_url }}" alt="Logo" />
                            </div>
                        </a>
                    </div>
                </div>
                <div class="tw-hidden md:tw-flex tw-items-center tw-space-x-8">
                    <a class="hover:tw-text-purple-300 tw-transition-colors"
                        href="{{ route('front.home') }}">{{ $frontMenu->home }}</a>
                    <a class="hover:tw-text-purple-300 tw-transition-colors"
                        href="{{ route('front.feature') }}">{{ $frontMenu->feature }}</a>
                    <a class="hover:tw-text-purple-300 tw-transition-colors"
                        href="{{ route('front.pricing') }}">{{ $frontMenu->price }}</a>
                    <a class="hover:tw-text-purple-300 tw-transition-colors"
                        href="{{ route('front.contact') }}">{{ $frontMenu->contact }}</a>
                    <div class="my-3 my-lg-0">
                        @guest
                            <a href="{{ module_enabled('Subdomain') ? route('front.workspace') : route('login') }}"
                                class=" tw-bg-blue-900 tw-px-5 tw-py-2 tw-rounded-full hover:tw-text-white hover:tw-shadow-lg tw-transition-all tw-text-white">
                                {{ $frontMenu->login }}
                            </a>
                            @if ($global->enable_register)
                                <a href="{{ route('front.signup.index') }}"
                                    class=" tw-bg-blue-900 tw-px-5 tw-py-2 tw-rounded-full hover:tw-text-white hover:tw-shadow-lg tw-transition-all tw-text-white ml-2">
                                    {{ $frontMenu->get_start }}
                                </a>
                            @endif
                        @else
                            <a href="{{ module_enabled('Subdomain') ? (user()->is_superadmin ? \App\Providers\RouteServiceProvider::SUPER_ADMIN_HOME : \App\Providers\RouteServiceProvider::HOME) : route('login') }}"
                                class=" tw-bg-blue-900 tw-px-5 tw-py-2 tw-rounded-full hover:tw-text-white hover:tw-shadow-lg tw-transition-all tw-text-white flex items-center">
                                @if (isset(user()->image_url))
                                    <img src="{{ user()->image_url }}" class="rounded mr-2" width="25"
                                        alt="@lang('superadmin.myAccount')">
                                @endif
                                @lang('superadmin.myAccount')
                            </a>
                        @endguest
                    </div>
                </div>
                <div class="md:tw-hidden tw-flex tw-items-center">
                    <button id="mobile-menu-btn" class="tw-text-white">
                        <i class="fa fa-bars tw-text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="tw-hidden md:tw-hidden glass-effect">
            <div class="tw-px-2 tw-pt-2 tw-pb-3 tw-space-y-1">
                <a href="#home" class="tw-block tw-px-3 tw-py-2 hover:tw-bg-purple-700 tw-rounded">Home</a>
                <a href="#features" class="tw-block tw-px-3 tw-py-2 hover:tw-bg-purple-700 tw-rounded">Features</a>
                <a href="#pricing" class="tw-block tw-px-3 tw-py-2 hover:tw-bg-purple-700 tw-rounded">Pricing</a>
                <a href="#contact" class="tw-block tw-px-3 tw-py-2 hover:tw-bg-purple-700 tw-rounded">Contact</a>
            </div>
        </div>
    </nav>
    {{-- <div class="navigation-bar" id="affix">
        <div class="container">
            <nav class="navbar navbar-expand-lg p-0">
                <a class="logo" href="{{ route('front.home') }}">
                    <div class="d-flex align-items-center">
                        <img class="mr-2 rounded logo-default" style="max-height: 32px;"
                            src="{{ global_setting()->logo_front_url }}" alt="Logo" />
                    </div>
                </a>
                <button class="navbar-toggler border-0 p-0" type="button" data-toggle="collapse"
                    data-target="#theme-navbar" aria-controls="theme-navbar" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-lines"></span>
                </button>

                <div class="collapse navbar-collapse gap-3" id="theme-navbar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('front.home') }}">{{ $frontMenu->home }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('front.feature') }}">{{ $frontMenu->feature }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('front.pricing') }}">{{ $frontMenu->price }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('front.contact') }}">{{ $frontMenu->contact }}</a>
                        </li>
                        @foreach ($footerSettings as $footerSetting)
                            @unless ($footerSetting->type == 'footer')
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ !is_null($footerSetting->external_link) ? $footerSetting->external_link : route('front.page', $footerSetting->slug) }}">{{ $footerSetting->name }}</a>
                                </li>
                            @endif
                            @endforeach

                        </ul>
                        <div class="my-3 my-lg-0">
                            @guest
                                <a href="{{ module_enabled('Subdomain') ? route('front.workspace') : route('login') }}"
                                    class="btn btn-border shadow-none">{{ $frontMenu->login }}</a>
                                @if ($global->enable_register)
                                    <a href="{{ route('front.signup.index') }}"
                                        class="btn btn-menu-signup shadow-none ml-2">{{ $frontMenu->get_start }}</a>
                                @endif
                            @else
                                <a href="{{ module_enabled('Subdomain') ? (user()->is_superadmin ? \App\Providers\RouteServiceProvider::SUPER_ADMIN_HOME : \App\Providers\RouteServiceProvider::HOME) : route('login') }}"
                                    class="btn btn-border shadow-none px-3 py-1">
                                    @if (isset(user()->image_url))
                                        <img src="{{ user()->image_url }}" class="rounded" width="25"
                                            alt="@lang('superadmin.myAccount')">
                                    @endif @lang('superadmin.myAccount')
                                </a>
                            @endguest
                        </div>
                    </div>
                </nav>
            </div>
        </div> --}}
    <!-- END Navigation -->
</header>
<!-- END Header -->
