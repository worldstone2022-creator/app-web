<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $globalSetting->favicon_url }}">
    <link rel="manifest" href="{{ $globalSetting->favicon_url }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ $globalSetting->favicon_url }}">
    <meta name="theme-color" content="#ffffff">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/css/all.min.css') }}" defer="defer">

    <!-- Template CSS -->
    <link href="{{ asset('vendor/froiden-helper/helper.css') }}" rel="stylesheet" defer="defer">
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('css/main.css') }}">

    <title>{{ $globalSetting->global_app_name ?? $globalSetting->app_name }}</title>

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

    @stack('styles')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <style defer="defer">
        .login_header {
            background-color: {{ $globalSetting->logo_background_color }} !important;
        }
    </style>
    @include('sections.theme_css')
    @if (file_exists(public_path() . '/css/login-custom.css'))
        <link href="{{ asset('css/login-custom.css') }}" rel="stylesheet">
    @endif

    @if ($globalSetting->sidebar_logo_style == 'full')
        <style>
            .login_header img {
                max-width: unset;
            }
        </style>
    @endif

    @includeif('sections.custom_script')


</head>

<body
    class="{{ $globalSetting->auth_theme == 'dark' ? 'dark-theme' : '' }} {{ isRtl() ? (session('changedRtl') === false ? '' : 'rtl') : (session('changedRtl') == true ? 'rtl' : '') }}">

    <section class="login_section"
        @if ($globalSetting->login_background_url) style="background: url('{{ $globalSetting->login_background_url }}') center center/cover no-repeat;" @endif>
        <div>
            <div>
               <div class="tw-flex tw-h-screen tw-bg-gray-100 ">
                        <div class=" tw-flex tw-flex-1 tw-flex-col tw-justify-center tw-py-12 tw-px-4 tw-sm:tw-px-6 tw-lg:tw-flex-none tw-lg:tw-px-20 tw-xl:tw-px-2">
                            <div class="tw-mx-auto tw-w-full tw-max-w-sm tw-lg:w-96">
                                <div class="tw-mt-20">
                                    <div class="tw-flex tw-justify-center">
                                        <img class="mr-2 rounded tw-w-20" src="{{ $globalSetting->logo_url }}"
                                            alt="Logo" />
                                    </div>

                                    {{ $slot }}
                                </div>
                                {{ $outsideLoginBox ?? '' }}
                                @if ($languages->count() > 1)
                                    <div class="my-3 d-flex flex-column flex-grow-1">
                                        <div class="d-flex flex-wrap align-items-center justify-content-center">
                                            @foreach ($languages->take(4) as $index => $language)
                                                <span class="mx-3 my-10 f-12">
                                                    <a href="javascript:;"
                                                        class="text-dark-grey change-lang d-flex align-items-center"
                                                        data-lang="{{ $language->language_code }}">
                                                        <span
                                                            class="mr-2 flag-icon flag-icon-{{ $language->flag_code === 'en' ? 'gb' : $language->flag_code }} flag-icon-squared"></span>
                                                        {{ \App\Models\LanguageSetting::LANGUAGES_TRANS[$language->language_code] ?? $language->language_name }}
                                                    </a>
                                                </span>
                                            @endforeach

                                            @if ($languages->count() > 4)
                                                <div class="dropdown" style="z-index:10000">
                                                    <a class="btn btn-lg f-14 px-2 py-1 text-dark-grey  rounded dropdown-toggle"
                                                        type="button" id="languageDropdown" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-h"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0"
                                                        aria-labelledby="languageDropdown"
                                                        style="max-height: 600px; overflow-y: auto;">
                                                        @foreach ($languages->slice(4) as $language)
                                                            <a class="dropdown-item change-lang" href="javascript:;"
                                                                data-lang="{{ $language->language_code }}">
                                                                <span
                                                                    class="mr-2 flag-icon flag-icon-{{ $language->flag_code === 'en' ? 'gb' : $language->flag_code }} flag-icon-squared"></span>
                                                                {{ \App\Models\LanguageSetting::LANGUAGES_TRANS[$language->language_code] ?? $language->language_name }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class=" tw-hidden md:tw-block tw-h-full tw-w-1/2">
                           <img src="{{ asset('image.png') }}"  class=" tw-h-full tw-w-full tw-object-cover"   alt="logo">
                        </div>
                    </div>
            </div>

        </div>

    </section>

    <!-- Font Awesome -->
    <script src="{{ asset('vendor/jquery/all.min.js') }}" defer="defer"></script>

    <!-- Template JS -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        document.loading = '@lang('app.loading')';
        const MODAL_DEFAULT = '#myModalDefault';
        const MODAL_LG = '#myModal';
        const MODAL_XL = '#myModalXl';
        const MODAL_HEADING = '#modelHeading';
        const RIGHT_MODAL = '#task-detail-1';
        const RIGHT_MODAL_CONTENT = '#right-modal-content';
        const RIGHT_MODAL_TITLE = '#right-modal-title';

        const dropifyMessages = {
            default: "@lang('app.dragDrop')",
            replace: "@lang('app.dragDropReplace')",
            remove: "@lang('app.remove')",
            error: "@lang('messages.errorOccured')",
        };
        $('.change-lang').click(function(event) {
            const locale = $(this).data("lang");
            event.preventDefault();
            let url = "{{ route('front.changeLang', ':locale') }}";
            url = url.replace(':locale', locale);
            $.easyAjax({
                url: url,
                container: '#login-form',
                blockUI: true,
                type: "GET",
                success: function(response) {
                    if (response.status === 'success') {
                        window.location.reload();
                    }
                }
            })
        });
    </script>

    {{ $scripts }}

</body>

</html>
