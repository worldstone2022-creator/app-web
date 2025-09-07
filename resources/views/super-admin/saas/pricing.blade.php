@extends('super-admin.layouts.saas-app')
@section('header-section')
    @include('super-admin.saas.section.breadcrumb')



@endsection


@push('head-script')
<style>

       .gradient-text {
            background: linear-gradient(135deg, #fb923c 0%, #0c195e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
</style>
    @if (count($packages) > 0)
        <style>
            .package-column {
                max-width: 25%;
                flex: 0 0 25%
            }

            .package-contact-btn {
                font-size: 12px;
            }

            .rate p {
                font-size: 12px;
            }

            span.font-weight-bolder {
                font-size: 20px !important;
            }
        </style>
    @endif
    <link type="text/css" rel="stylesheet" media="all" href="{{ asset('saas/css/quill.snow.css') }}">
@endpush

@section('content')
    <section class="pricing-section pricing-bg tw-py-20">
        <div class="tw-container tw-mx-auto tw-px-4 tw-max-w-7xl">
            <div class="tw-flex tw-justify-center tw-mb-16">
                    <div class="tw-w-full tw-text-center fade-in">
                        <div class="tw-mb-8">
                            <h3 class="tw-text-4xl md:tw-text-5xl tw-font-bold tw-mb-4 gradient-text">{{ $trFrontDetail->price_title }}</h3>
                            <div class="tw-text-xl tw-text-gray-600 tw-max-w-3xl tw-mx-auto tw-leading-relaxed">
                                {!! $trFrontDetail->price_description !!}
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Pricing Plans -->
            <div id="price-plan" class="fade-in">
                @include('super-admin.saas.pricing-plan')
            </div>
        </div>
    </section>
@endsection
@push('footer-script')
    <script>
        @if ($monthlyPlan <= 0)
            $('.annual_package').removeClass('inactive').addClass('active');
            $('#yearly').removeClass('inactive').addClass('active');
        @else
            $('#monthly').removeClass('inactive').addClass('active');
        @endif
        // #currency on change request and load price plan on that currency
        $('body').on('change', '#currency', function() {
            let currencyId = $(this).val();
            let url = '{{ route('front.pricing') }}';
            $.easyAjax({
                url: url,
                type: "GET",
                data: {
                    'currencyId': currencyId
                },
                success: function(response) {
                    $('#price-plan').html(response.view);
                }
            })

        });
    </script>
@endpush
