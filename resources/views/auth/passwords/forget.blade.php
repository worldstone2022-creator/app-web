@push('styles')
    @foreach ($frontWidgets as $item)
    @if(!is_null($item->header_script))
        {!! $item->header_script !!}
    @endif

    @endforeach
@endpush
<x-auth>
    <form id="forgot-password-form" action="{{ route('password.email') }}" class="ajax-form" method="POST">
        {{ csrf_field() }}
        <h3 class=" mb-4 f-w-500">@lang('app.recoverPassword')</h3>

        <div class="alert alert-success m-t-10 d-none" id="success-msg"></div>
        <div class="group">
            <div class="form-group text-left">
                <label for="email" class="f-w-500">@lang('auth.email')</label>
                <input type="email" name="email" class="form-control height-50 f-15 light_text"
                       autofocus placeholder="@lang('placeholders.email')" id="email">
            </div>

            <button
                type="button"
                id="submit-login"
                class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-w-full tw-px-6 tw-flex tw-items-center tw-justify-center tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 ">
                @lang('app.sendPasswordLink') <i class="fa fa-arrow-right pl-1"></i>
            </button>
        </div>
        <div class="forgot_pswd mt-3">
            <a href="{{ route('login') }}" class="justify-content-center">@lang('app.login')</a>
        </div>
        <input type="hidden" name="locale" value="{{ session()->has('locale') ? session('locale') : global_setting()->locale }}">
    </form>

    <x-slot name="scripts">
        <script>

            $('#submit-login').click(function () {

                const url = "{{ route('password.email') }}";
                $.easyAjax({
                    url: url,
                    container: '#forgot-password-form',
                    disableButton: true,
                    blockUI: true,
                    buttonSelector: "#submit-login",
                    type: "POST",
                    data: $('#forgot-password-form').serialize(),
                    success: function (response) {
                        $('#success-msg').removeClass('d-none');
                        $('#success-msg').html(response.message);
                        $('.group').remove();
                    }
                })
            });

        </script>

        @foreach ($frontWidgets as $item)
        @if(!is_null($item->footer_script))
            {!! $item->footer_script !!}
        @endif

        @endforeach
    </x-slot>

</x-auth>
