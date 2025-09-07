<!-- PAGE TITLE START -->
<div {{ $attributes->merge(['class' => 'page-title']) }}>
    <div class="tw-flex tw-items-center tw-justify-between tw-w-full  tw-px-6">
        <div class="tw-flex tw-items-center">
            <h2 class="tw-mb-0 tw-pr-4 tw-text-gray-900 tw-flex tw-items-center tw-text-xl tw-font-extrabold  tw-gap-2">
                <span class="tw-inline-block tw-truncate tw-max-w-md">{{ $pageTitle }}</span>
                <span class="tw-text-gray-500 tw-text-sm tw-font-semibold tw-ml-3 tw-max-w-md tw-truncate tw-flex tw-items-center tw-gap-1">
                    @if(user()?->is_superadmin)
                        <a href="{{ route('superadmin.super_admin_dashboard') }}" class=" hover:tw-underline">@lang('app.menu.home')</a>
                        <span class="tw-mx-1 tw-text-gray-300">&bull;</span>
                    @else
                        <a href="{{ route('dashboard') }}" class="hover:tw-underline">@lang('app.menu.home')</a>
                        <span class="tw-mx-1 tw-text-gray-300">&bull;</span>
                    @endif
                    @php
                        $link = '';
                    @endphp

                    @for ($i = 1; $i <= count(Request::segments()); $i++)
                        @if (($i < count(Request::segments())) && ($i > 0))
                            @php $link .= '/' . Request::segment($i); @endphp

                            @if (Request::segment($i) != 'account')
                                @php
                                    $langKey = 'app.'.str(Request::segment($i))->camel();

                                    if (!Lang::has($langKey)) {
                                        $langKey = str($langKey)->replace('app.', 'app.menu.')->__toString();
                                    }
                                    $segmentText = Lang::has($langKey) ? __($langKey) : ucwords(str_replace('-', ' ', Request::segment($i)));
                                    $segmentLink = str_contains(url()->current(), 'public') ? '/public' . $link : $link;
                                @endphp

                                @if (in_array(Request::segment($i), App\Enums\NonClickableSegments::getValues()))
                                    <span class="tw-text-gray-500">{{ $segmentText }}</span>
                                    <span class="tw-mx-1 tw-text-[#f7670092]">&bull;</span>
                                @else
                                    <a href="{{ $segmentLink }}" class="tw-text-[#f7670092] hover:tw-underline">
                                        {{ $segmentText }}
                                    </a>
                                    <span class="tw-mx-1 tw-text-[#f7670092]">&bull;</span>
                                @endif
                            @endif
                        @else
                            <span class="tw-text-[#f7670092] tw-font-extrabold">{{ $pageTitle }}</span>
                        @endif
                    @endfor
                </span>
            </h2>
        </div>
    </div>
</div>
<!-- PAGE TITLE END -->
