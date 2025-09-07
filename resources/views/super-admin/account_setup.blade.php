<x-auth>
    <form id="login-form" action="{{ route('setup_account') }}" class="ajax-form" method="POST">
        @include('sections.password-autocomplete-hide')

        {{ csrf_field() }}
        <input type="hidden" name="sendMail" value="no">

        <h3 class="text-capitalize mb-3 f-w-500">{{ config('app.name') }} @lang('app.accountSetup')</h3>
        <h6 class="mb-4 heading-h6 text-lightest">Setup your superadmin account. This can be changed later.
        </h6>

        <div class="form-group text-left">
            <label for="company_name"
                   class="f-w-500">Application name</label>
            <input type="text" name="company_name" class="form-control height-50 f-15 light_text"
                   autofocus placeholder="@lang('placeholders.company')" id="company_name">
        </div>

        <div class="form-group text-left">
            <label for="full_name" class="f-w-500">Your Full name</label>
            <input type="text" name="full_name" class="form-control height-50 f-15 light_text"
                   autofocus placeholder="@lang('placeholders.name')" id="full_name">
        </div>

        <div class="form-group text-left">
            <label for="email" class="f-w-500">@lang('app.email')</label>
            <input type="text" name="email" class="form-control height-50 f-15 light_text" autofocus
                   placeholder="@lang('placeholders.email')" id="email">
        </div>

        <div class="form-group text-left">
            <label for="password" class="f-w-500">@lang('app.password')</label>
            <div class='input-group'>
                <input type="password" name="password"
                       class="form-control height-50 f-15 light_text" placeholder="@lang('placeholders.password')"
                       id="password">

                <div class="input-group-append">
                    <button type="button" data-toggle="tooltip"
                            data-original-title="@lang('app.viewPassword')"
                            class="btn btn-outline-secondary border-grey toggle-password"><i
                            class="fa fa-eye"></i></button>
                </div>
            </div>
        </div>

        <button type="submit" id="submit-login"
                class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-w-full tw-px-6 tw-flex tw-items-center tw-justify-center tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 ">
            @lang('app.saveLogin') <i class="fa fa-arrow-right pl-1"></i>
        </button>
    </form>

    <x-slot name="scripts">

        <script>

            $('#submit-login').click(function() {

                var url = "{{ route('setup_account') }}";
                $.easyAjax({
                    url: url,
                    container: '#login-form',
                    disableButton: true,
                    buttonSelector: "#submit-login",
                    type: "POST",
                    data: $('#login-form').serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.href = "{{ route('superadmin.checklist') }}";
                        }
                    }
                })
            });
        </script>
    </x-slot>

</x-auth>
