<!-- Footer -->
<footer class="tw-bg-white tw-py-12">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-4 tw-gap-8">
            <!-- About / Logo / Socials -->
            <div>
                <a href="./" class="hover-logo tw-inline-block tw-mb-4">
                    <img src="{{ $setting->logo_front_url }}" class="logo" style="max-height:35px">
                </a>
                <p class="tw-text-[#0c195e] tw-mb-4">
                    {{ $frontDetail->footer_about ?? __('Révolutionnez votre expérience technologique avec nos solutions innovantes.') }}
                </p>
                <div class="tw-flex tw-space-x-4">
                    @if ($frontDetail->social_links)
                        @foreach (json_decode($frontDetail->social_links, true) as $link)
                            @if (strlen($link['link']) > 0)
                                <a href="{{ $link['link'] }}" class="tw-text-[#0c195e] hover:tw-text-orange-400 tw-transition-colors" target="_blank">
                                    <i class="zmdi zmdi-{{$link['name']}} tw-text-xl"></i>
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            <!-- Main Links -->
            <div>
                <h4 class="tw-text-lg tw-font-semibold tw-mb-4 tw-text-orange-400">{{ __('superadmin.main') }}</h4>
                <ul class="tw-space-y-2">
                    @if ($setting->enable_register == true)
                        <li>
                            <a class="tw-text-[#0c195e] hover:tw-text-orange-400 tw-transition-colors"
                               href="{{ route('front.signup.index') }}">{{ $frontMenu->get_start }}</a>
                        </li>
                    @endif
                    <li>
                        <a class="tw-text-[#0c195e] hover:tw-text-orange-400 tw-transition-colors"
                           href="{{ route('front.feature') }}">Fonctionnalités</a>
                    </li>
                    <li>
                        <a class="tw-text-[#0c195e] hover:tw-text-orange-400 tw-transition-colors"
                           href="{{ route('front.pricing') }}">Tarification</a>
                    </li>
                    <li>
                        @if (module_enabled('Subdomain'))
                            <a href="{{ route('front.workspace') }}"
                               class="tw-text-[#0c195e] hover:tw-text-orange-400 tw-transition-colors">{{ $frontMenu->login }}</a>
                        @else
                            <a href="{{ route('login') }}"
                               class="tw-text-[#0c195e] hover:tw-text-orange-400 tw-transition-colors">{{ $frontMenu->login }}</a>
                        @endif
                    </li>
                </ul>
            </div>
            <!-- Other Links -->
            <div>
                <h4 class="tw-text-lg tw-font-semibold tw-mb-4 tw-text-orange-400">{{ __('app.others') }}</h4>
                <ul class="tw-space-y-2">
                    @foreach ($footerSettings as $footerSetting)
                        @if ($footerSetting->type != 'header')
                            <li>
                                <a class="tw-text-[#0c195e] hover:tw-text-orange-400 tw-transition-colors"
                                   href="@if (!is_null($footerSetting->external_link)) {{ $footerSetting->external_link }} @else {{ route('front.page', $footerSetting->slug) }} @endif">{{ $footerSetting->name }}</a>
                            </li>
                        @endif
                    @endforeach
                    <li>
                        <a class="tw-text-[#0c195e] hover:tw-text-orange-400 tw-transition-colors"
                           href="{{ route('front.contact') }}">{{ $frontMenu->contact }}</a>
                    </li>
                </ul>
            </div>
            <!-- Contact -->
            <div>
                <h4 class="tw-text-lg tw-font-semibold tw-mb-4 tw-text-orange-400">{{ $frontMenu->contact }}</h4>
                <div class="tw-space-y-4">
                    <div class="tw-flex tw-items-center tw-space-x-2">
                        <i class="flaticon-email tw-text-orange-400"></i>
                        <span class="tw-text-[#0c195e]">{{ $frontDetail->email }}</span>
                    </div>
                    @if ($frontDetail->phone)
                        <div class="tw-flex tw-items-center tw-space-x-2">
                            <i class="flaticon-call tw-text-orange-400"></i>
                            <span class="tw-text-[#0c195e]">{{ $frontDetail->phone }}</span>
                        </div>
                    @endif
                    <div class="tw-flex tw-items-center tw-space-x-2">
                        <i class="flaticon-placeholder tw-text-orange-400"></i>
                        <span class="tw-text-[#0c195e]">{{ $frontDetail->address }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="tw-border-t tw-border-orange-400 tw-mt-8 tw-pt-8 tw-text-center">
            <span class="tw-text-[#0c195e] tw-mr-3">
                {{ $trFrontDetail->footer_copyright_text ?? "" }}
            </span>
            @if (count($languages) > 1)
                <div class="tw-inline-flex tw-items-center tw-bg-[#0c195e] tw-rounded tw-px-2 tw-py-1 tw-ml-2">
                    <i class="zmdi zmdi-globe-alt tw-text-orange-400 tw-mr-1"></i>
                    <select class="tw-bg-transparent tw-text-white tw-outline-none" onchange="location = this.value;">
                        @foreach ($languages as $language)
                            <option value="{{ route('front.language.lang', $language->language_code) }}"
                                @if ($locale == $language->language_code) selected @endif>
                                {{ $language->language_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>
    </div>
</footer>