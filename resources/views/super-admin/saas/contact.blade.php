@extends('super-admin.layouts.saas-app')
@section('header-section')
    @include('super-admin.saas.section.breadcrumb')
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #fb923c 0%, #0c195e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
@endsection

@section('content')
    <!-- START Contact Section -->
    <section id="contact" class="tw-py-20 tw-bg-white tw-relative tw-overflow-hidden">
        <!-- Arrière-plan décoratif -->
        <div
            class="tw-absolute tw-top-0 tw-right-0 tw-w-96 tw-h-96 tw-bg-orange-400 tw-rounded-full tw-opacity-5 tw-transform tw-translate-x-1/2 tw--translate-y-1/2">
        </div>
        <div
            class="tw-absolute tw-bottom-0 tw-left-0 tw-w-80 tw-h-80 tw-bg-[#0c195e] tw-rounded-full tw-opacity-5 tw-transform tw--translate-x-1/2 tw-translate-y-1/2">
        </div>

        <div class="tw-max-w-4xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8 tw-relative tw-z-10">
            <div class="tw-text-center tw-mb-16 fade-in">
                <h2 class="tw-text-4xl md:tw-text-5xl tw-font-bold tw-mb-4 tw-text-orange-400 reveal gradient-text">@lang('Contactez-nous')</h2>
                <p class="tw-text-xl tw-text-[#0c195e] slide-in-right">@lang('Prêt à commencer ? Parlons de votre projet')</p>
            </div>
            <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-12">
                <!-- Contact Info -->
                <div class="slide-in-left">
                    <h3 class="tw-text-2xl tw-font-bold tw-mb-6 tw-text-[#0c195e]">@lang('Restons en contact')</h3>
                    <div class="tw-space-y-4">
                        @if ($frontDetail->email)
                            <div
                                class="tw-flex tw-items-center tw-group tw-transition-all tw-duration-300 hover:tw-transform hover:tw-translate-x-2">
                                <i
                                    class="fas fa-envelope tw-text-orange-400 tw-text-xl tw-mr-4 tw-transition-all tw-duration-300 group-hover:tw-scale-125"></i>
                                <span
                                    class="tw-text-[#0c195e] tw-transition-all tw-duration-300 group-hover:tw-text-orange-400">{{ $frontDetail->email }}</span>
                            </div>
                        @endif
                        @if ($frontDetail->phone)
                            <div
                                class="tw-flex tw-items-center tw-group tw-transition-all tw-duration-300 hover:tw-transform hover:tw-translate-x-2">
                                <i
                                    class="fas fa-phone tw-text-orange-400 tw-text-xl tw-mr-4 tw-transition-all tw-duration-300 group-hover:tw-scale-125 group-hover:tw-animate-pulse"></i>
                                <span
                                    class="tw-text-[#0c195e] tw-transition-all tw-duration-300 group-hover:tw-text-orange-400">{{ $frontDetail->phone }}</span>
                            </div>
                        @endif
                        @if ($frontDetail->address)
                            <div
                                class="tw-flex tw-items-center tw-group tw-transition-all tw-duration-300 hover:tw-transform hover:tw-translate-x-2">
                                <i
                                    class="fas fa-map-marker-alt tw-text-orange-400 tw-text-xl tw-mr-4 tw-transition-all tw-duration-300 group-hover:tw-scale-125 group-hover:tw-animate-bounce"></i>
                                <span
                                    class="tw-text-[#0c195e] tw-transition-all tw-duration-300 group-hover:tw-text-orange-400">{{ $frontDetail->address }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="tw-flex tw-space-x-4 tw-mt-8">
                        @if (!empty($frontDetail->twitter))
                            <a href="{{ $frontDetail->twitter }}"
                                class="social-icon tw-w-12 tw-h-12 tw-bg-orange-400 tw-rounded-full tw-flex tw-items-center tw-justify-center hover:tw-bg-[#0c195e] hover:tw-text-white tw-transition-all tw-text-white"
                                target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                        @endif
                        @if (!empty($frontDetail->linkedin))
                            <a href="{{ $frontDetail->linkedin }}"
                                class="social-icon tw-w-12 tw-h-12 tw-bg-orange-400 tw-rounded-full tw-flex tw-items-center tw-justify-center hover:tw-bg-[#0c195e] hover:tw-text-white tw-transition-all tw-text-white"
                                target="_blank">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        @endif
                        @if (!empty($frontDetail->github))
                            <a href="{{ $frontDetail->github }}"
                                class="social-icon tw-w-12 tw-h-12 tw-bg-orange-400 tw-rounded-full tw-flex tw-items-center tw-justify-center hover:tw-bg-[#0c195e] hover:tw-text-white tw-transition-all tw-text-white"
                                target="_blank">
                                <i class="fab fa-github"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="slide-in-right">
                    <form method="POST" id="contactUs" class="tw-space-y-6">
                        @csrf
                        <div id="alert"></div>
                        <div class="form-group">
                            <input type="text" name="name" id="name" placeholder="@lang('modules.profile.yourName')"
                                class="form-input tw-w-full tw-px-4 tw-py-3 tw-bg-[#f8fafc] tw-text-[#0c195e] tw-rounded-lg tw-border tw-border-orange-400 focus:tw-border-[#0c195e] focus:tw-outline-none tw-transition-all tw-duration-300 hover:tw-shadow-lg">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="email" placeholder="@lang('modules.profile.yourEmail')"
                                class="form-input tw-w-full tw-px-4 tw-py-3 tw-bg-[#f8fafc] tw-text-[#0c195e] tw-rounded-lg tw-border tw-border-orange-400 focus:tw-border-[#0c195e] focus:tw-outline-none tw-transition-all tw-duration-300 hover:tw-shadow-lg">
                        </div>
                        <div class="form-group">
                            <textarea rows="5" name="message" id="message" placeholder="@lang('modules.messages.message')"
                                class="form-input tw-w-full tw-px-4 tw-py-3 tw-bg-[#f8fafc] tw-text-[#0c195e] tw-rounded-lg tw-border tw-border-orange-400 focus:tw-border-[#0c195e] focus:tw-outline-none tw-transition-all tw-duration-300 tw-resize-none hover:tw-shadow-lg"></textarea>
                        </div>
                        @if ($global->google_recaptcha_status == 'active' && $global->google_recaptcha_v2_status == 'active')
                            <div class="form-group" id="captcha_container"></div>
                            <input type="hidden" id="g_recaptcha" name="g_recaptcha">
                        @endif
                        @if ($global->google_recaptcha_status == 'active' && $global->google_recaptcha_v3_status == 'active')
                            <div class="form-group">
                                <input type="hidden" id="g_recaptcha" name="g_recaptcha">
                            </div>
                        @endif
                        <button type="button" id="contact-submit"
                            class="animated-button tw-w-full tw-bg-gradient-to-r tw-from-orange-400 tw-to-[#0c195e] tw-py-3 tw-rounded-lg tw-font-semibold hover:tw-shadow-lg tw-text-white tw-transition-all tw-duration-300 hover:tw-scale-105">
                            {{ $frontMenu->contact_submit }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- END Contact Section -->
@endsection
@push('footer-script')
    <script>
        $('#contact-submit').click(function() {

            $.easyAjax({
                url: "{{ route('front.contact-us') }}",
                container: '#contactUs',
                blockUI: true,
                type: "POST",
                data: $('#contactUs').serialize(),
                messagePosition: "inline",
                success: function(response) {
                    if (response.status === 'success') {
                        $('#contactUsBox').remove();
                    }
                }
            })
        });
    </script>

    @if ($global->google_recaptcha_status == 'active' && $global->google_recaptcha_v2_status == 'active')
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
        <script>
            var gcv3;
            var onloadCallback = function() {
                // Renders the HTML element with id 'captcha_container' as a reCAPTCHA widget.
                // The id of the reCAPTCHA widget is assigned to 'gcv3'.
                gcv3 = grecaptcha.render('captcha_container', {
                    'sitekey': '{{ $global->google_recaptcha_v2_site_key }}',
                    'theme': 'light',
                    'callback': function(response) {
                        if (response) {
                            $('#g_recaptcha').val(response);
                        }
                    },
                });
            };
        </script>
    @endif
    @if ($global->google_recaptcha_status == 'active' && $global->google_recaptcha_v3_status == 'active')
        <script src="https://www.google.com/recaptcha/api.js?render={{ $global->google_recaptcha_v3_site_key }}"></script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ $global->google_recaptcha_v3_site_key }}').then(function(token) {
                    // Add your logic to submit to your backend server here.
                    $('#g_recaptcha').val(token);
                });
            });
        </script>
    @endif

@endpush
