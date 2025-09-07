<div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-4 tw-gap-8">
    @foreach ($packages as $item)
        @php
            $isPro = $item->is_recommended == 1;
            $isEnterprise = $item->name === 'Enterprise';
            $isStarter = $item->name === 'Starter';
            $monthlyPrice = $item->monthly_price;
            $annualPrice = $item->annual_price;
            $currencyMonthly = $item->currency_id ? global_currency_format($monthlyPrice, $item->currency_id) : $monthlyPrice;
            $currencyAnnual = $item->currency_id ? global_currency_format($annualPrice, $item->currency_id) : $annualPrice;
            $features = [];
            $notAvailable = [];
            // Build features list
            $features[] = $item->max_employees == -1 ? __('superadmin.unlimited') . ' ' . __('app.menu.employees') : $item->max_employees . ' ' . __('app.menu.employees');
            $features[] = ($item->max_storage_size == -1 ? __('superadmin.unlimited') : $item->max_storage_size . ($item->storage_unit == 'mb' ? 'MB' : 'GB')) . ' ' . __('superadmin.fileStorage');
            $packageModules = (array) json_decode($item->module_in_package);
            foreach ($packageFeatures as $packageFeature) {
                if (in_array($packageFeature, $activeModule)) {
                    if (in_array($packageFeature, $packageModules)) {
                        $features[] = __('modules.module.' . $packageFeature);
                    } else {
                        $notAvailable[] = __('modules.module.' . $packageFeature);
                    }
                }
            }
        @endphp
        <div class="pricing-card tw-rounded-2xl tw-p-8 tw-text-center
            @if($isPro) tw-transform tw-scale-105 tw-border-2 tw-border-orange-400 @endif">
            @if($isPro)
                <div class="tw-bg-orange-400 tw-text-white tw-px-4 tw-py-1 tw-rounded-full tw-inline-block tw-mb-4 tw-text-sm tw-font-semibold">
                    @lang('superadmin.popular')
                </div>
            @endif
            <div class="tw-mb-6">
                <h4 class="tw-text-2xl tw-font-bold tw-text-gray-800 tw-mb-2">{{ $item->name }}</h4>
                <div class="tw-text-4xl tw-font-bold tw-text-orange-400 tw-mb-2">
                    @if($item->is_free)
                        @lang('superadmin.packages.free')
                    @else
                        @if($monthlyPlan > 0)
                            {!! $currencyMonthly !!}
                            <span class="tw-text-base tw-text-gray-500">/@lang('app.month')</span>
                        @elseif($annualPlan > 0)
                            {!! $currencyAnnual !!}
                            <span class="tw-text-base tw-text-gray-500">/@lang('app.year')</span>
                        @endif
                    @endif
                </div>
                @if(!$item->is_free)
                    <div class="tw-text-sm tw-text-gray-500">
                        <span>
                            @lang('Mois'):
                            <strong>{!! $currencyMonthly !!}</strong>
                        </span>
                        <span class="tw-mx-2">|</span>
                        <span>
                            @lang('année'):
                            <strong>{!! $currencyAnnual !!}</strong>
                        </span>
                    </div>
                @endif
                <span class="tw-text-gray-500">
                    @if($item->default == 'lifetime')
                        @lang('superadmin.packages.lifeTimepackgeInfo')
                    @endif
                </span>
            </div>
            <ul class="tw-space-y-3 tw-mb-8 tw-text-left">
                @foreach($features as $feature)
                    <li class="tw-flex tw-items-center">
                        <i class="fas fa-check tw-text-green-500 tw-mr-3"></i>
                        <span>{{ $feature }}</span>
                    </li>
                @endforeach
                @foreach($notAvailable as $feature)
                    <li class="tw-flex tw-items-center tw-opacity-50">
                        <i class="fas fa-times tw-text-red-400 tw-mr-3"></i>
                        <span>{{ $feature }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>