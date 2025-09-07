@if(\Illuminate\Support\Facades\Route::currentRouteName() != 'front.home' && \Illuminate\Support\Facades\Route::currentRouteName() != 'front.get-email-verification')
   <section class="breadcrumb-section tw-py-16 tw-pt-32 tw-bg-gradient-to-r tw-from-blue-900 tw-to-orange-400">
        <div class="tw-container tw-mx-auto tw-px-4">
            <div class="tw-flex tw-justify-center">
                <div class="tw-w-full tw-text-center">
                    <h2 class="tw-text-white tw-uppercase tw-mb-4 tw-text-3xl tw-font-bold">{{ $pageTitle }}</h2>
                    <ul class="tw-flex tw-mb-0 tw-justify-center tw-items-center tw-space-x-2">
                        <li class="tw-text-white">
                            <a href="/" class="tw-text-white hover:tw-text-orange-400 tw-transition-colors">@lang('app.menu.home')</a>
                        </li>
                        <li class="tw-text-white tw-mx-2">/</li>
                        <li class="tw-text-orange-400 tw-font-semibold">{{ $pageTitle }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endif
