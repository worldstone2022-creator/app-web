@section('other-section')
<ul class="nav tabs-vertical">
    <li class="tab">
        <a href="{{ route('super-admin.theme-settings') }}" class="text-danger"><i class="ti-arrow-left"></i> @lang('app.front') @lang('app.menu.settings')</a></li>
        <li class="tab @if(isset($type) && $type == 'image') active @endif">
        <a href="{{ route('super-admin.feature-settings.index') }}?type=image">@lang('app.homePageFeature')</a></li>

    <li class="tab">
        <a href="{{ route('super-admin.front-feature-settings.index') }}">@lang('app.featurePageFeature')</a></li>

</ul>

<script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    var screenWidth = $(window).width();
    if(screenWidth <= 768){

        $('.tabs-vertical').each(function() {
            var list = $(this), select = $(document.createElement('select')).insertBefore($(this).hide()).addClass('settings_dropdown form-control');

            $('>li a', this).each(function() {
                var target = $(this).attr('target'),
                    option = $(document.createElement('option'))
                        .appendTo(select)
                        .val(this.href)
                        .html($(this).html())
                        .click(function(){
                            if(target==='_blank') {
                                window.open($(this).val());
                            }
                            else {
                                window.location.href = $(this).val();
                            }
                        });

                if(window.location.href == option.val()){
                    option.attr('selected', 'selected');
                }
            });
            list.remove();
        });

        $('.settings_dropdown').change(function () {
            window.location.href = $(this).val();
        })

    }
</script>
@endsection