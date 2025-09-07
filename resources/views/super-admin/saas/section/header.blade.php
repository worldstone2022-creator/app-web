<section>

    {{-- <nav class="tw-fixed tw-top-0 tw-w-full tw-z-50 glass-effect">
        <div class="tw-max-w-7xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
            <div class="tw-flex tw-justify-between tw-h-16">
                <div class="tw-flex tw-items-center">
                    <div class="tw-flex-shrink-0">
                        <h1 class="tw-text-2xl tw-font-bold gradient-text">InnovateTech</h1>
                    </div>
                </div>
                <div class="tw-hidden md:tw-flex tw-items-center tw-space-x-8">
                    <a href="#home" class="hover:tw-text-purple-300 tw-transition-colors">Home</a>
                    <a href="#features" class="hover:tw-text-purple-300 tw-transition-colors">Features</a>
                    <a href="#pricing" class="hover:tw-text-purple-300 tw-transition-colors">Pricing</a>
                    <a href="#contact" class="hover:tw-text-purple-300 tw-transition-colors">Contact</a>
                    <button
                        class="tw-bg-gradient-to-r tw-from-purple-500 tw-to-pink-500 tw-px-4 tw-py-2 tw-rounded-full hover:tw-shadow-lg tw-transition-all">
                        Commencer
                    </button>
                </div>
                <div class="md:tw-hidden tw-flex tw-items-center">
                    <button id="mobile-menu-btn" class="tw-text-white">
                        <i class="fas fa-bars tw-text-xl"></i>
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
    </nav> --}}


    {{-- <div class="banner position-relative">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-12 text-lg-left text-center">
                    <div class="banner-text mr-0 mr-lg-5 mb-2">
                        <h3 class="mb-3 mb-md-4 font-weight-bold"> {{ $trFrontDetail->header_title }}</h3>
                        <div class="ql-editor">{!! $trFrontDetail->header_description !!}</div>
                        @if ($setting->enable_register)
                            @if (isset($packageSetting) && isset($trialPackage) && $packageSetting && !is_null($trialPackage))
                                <a href="{{ route('front.signup.index') }}"
                                    class="btn btn-lg btn-custom mt-4 btn-outline">{{ $packageSetting->trial_message }}
                                </a>
                            @else
                                <a href="{{ route('front.signup.index') }}" style ="margin-bottom: 46px;"
                                    class="btn btn-lg btn-custom mt-4 btn-outline">{{ $frontMenu->get_start }}</a>
                            @endif

                        @endif

                    </div>
                </div>
                <div class="col-lg-6 col-12 d-lg-block wow zoomIn" data-wow-delay="0.2s">
                    <div class="banner-img shadow1">
                        <img src="{{ $trFrontDetail->image_url }}" alt="business" class="shadow1">
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</section>
