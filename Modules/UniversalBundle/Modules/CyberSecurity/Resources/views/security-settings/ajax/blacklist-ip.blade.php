<div class="col-lg-12 col-md-12 ntfcn-tab-content-left w-100 p-4">

    <div class="table-responsive">
        <x-table class="table-bordered">
            <x-slot name="thead">
                <th>#</th>
                <th width="35%">@lang('cybersecurity::app.blacklistIp')</th>
                <th class="text-right">@lang('app.action')</th>
            </x-slot>

            @forelse($blacklistIps as $key => $ip)
                <tr id="ip-{{ $ip->id }}">
                    <td>
                        {{ $key + 1 }}
                    </td>
                    <td> {{ $ip->ip_address }} </td>
                    <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">
                        <div class="task_view-quentin">
                            <a href="javascript:;" data-ip-id="{{ $ip->id }}"
                               class="editBlacklistIp task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin">
                                <i class="fa fa-edit icons mr-1"></i> @lang('app.edit')
                            </a>
                        </div>
                        <div class="task_view-quentin mt-1 mt-lg-0 mt-md-0 ml-1">
                            <a href="javascript:;" data-ip-id="{{ $ip->id }}"
                               class="delete-blacklist-ip task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin">
                                <i class="fa fa-trash icons mr-1"></i> @lang('app.delete')
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        <x-cards.no-record icon="list" :message="__('messages.noRecordFound')"/>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>

</div>

<script>

    $('#add-blacklistIp').click(function () {
        var url = "{{ route('cybersecurity.blacklist-ip.create') }}";
        console.log(url);
        $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
        $.ajaxModal(MODAL_LG, url);
    });

    $('.editBlacklistIp').click(function () {

        var id = $(this).data('ip-id');

        var url = "{{ route('cybersecurity.blacklist-ip.edit', ':id') }}";
        url = url.replace(':id', id);

        $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
        $.ajaxModal(MODAL_LG, url);
    });

    $('body').on('click', '.delete-blacklist-ip', function () {

        var id = $(this).data('ip-id');

        Swal.fire({
            title: "@lang('messages.sweetAlertTitle')",
            text: "@lang('messages.recoverRecord')",
            icon: 'warning',
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: "@lang('messages.confirmDelete')",
            cancelButtonText: "@lang('app.cancel')",
            customClass: {
                confirmButton: 'btn btn-primary mr-3',
                cancelButton: 'btn btn-secondary'
            },
            showClass: {
                popup: 'swal2-noanimation',
                backdrop: 'swal2-noanimation'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {

                var url = "{{ route('cybersecurity.blacklist-ip.destroy', ':id') }}";
                url = url.replace(':id', id);

                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'POST',
                    url: url,
                    blockUI: true,
                    data: {
                        '_token': token,
                        '_method': 'DELETE'
                    },
                    success: function (response) {
                        if (response.status == "success") {
                            $('#ip-' + id).fadeOut();
                        }
                    }
                });
            }
        });
    });

</script>
