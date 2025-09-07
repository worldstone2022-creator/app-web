<div id="notice-detail-section">
    <div class="row">
        <div class="col-sm-12">
            <div class= "card-quentin  bg-white ">
                <div class="card-header bg-white  border-bottom-grey text-capitalize justify-content-between p-20">
                    <div class="row">
                        <div class="col-lg-10 col-10">
                            <h3 class="heading-h1 mb-3">@lang('modules.knowledgeBase.knowledgeDetails')</h3>
                        </div>
                        <div class="col-lg-2 col-2 text-right">
                            @if (user()->is_superadmin)
                            <div class="dropdown">
                                <button
                                    class="btn btn-lg f-14 px-2 py-1 text-dark-grey text-capitalize rounded  dropdown-toggle"
                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h"></i>
                                </button>

                                <div class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0"
                                    aria-labelledby="dropdownMenuLink" tabindex="0">

                                    <a class="dropdown-item openRightModal"
                                        href="{{ route('superadmin.faqs.edit', $knowledge->id) }}">@lang('app.edit')</a>

                                    <a class="dropdown-item delete-notice">@lang('app.delete')</a>

                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <x-cards.data-row :label="__('modules.knowledgeBase.knowledgeHeading')" :value="$knowledge->title" />
                    <x-cards.data-row :label="__('app.createdAt')" :value="$knowledge->created_at->format(global_setting()->date_format)" />

                    <x-cards.data-row :label="__('app.description')" :value="!empty($knowledge->description) ? $knowledge->description : '--'" html="true" />

                    <x-cards.data-row :label="__('app.file')" :value="''" />

                    <div class="col-md-12 d-flex flex-wrap mt-3" id="knowledgebase-file-list">
                        @forelse($knowledge->files as $file)
                            <x-file-card :fileName="$file->filename" :dateAdded="$file->created_at->diffForHumans()">
                                @if ($file->icon == 'images')
                                    <img src="{{ $file->file_url }}">
                                @else
                                    <i class="fa {{ $file->icon }} text-lightest"></i>
                                @endif
                                <x-slot name="action">
                                    <div class="dropdown ml-auto file-action">
                                        <button
                                            class="btn btn-lg f-14 p-0 text-lightest text-capitalize rounded  dropdown-toggle"
                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0"
                                            aria-labelledby="dropdownMenuLink" tabindex="0">
                                            <a class="cursor-pointer d-block text-dark-grey f-13 pt-3 px-3 "
                                                target="_blank" href="{{ $file->file_url }}">@lang('app.view')</a>

                                            <a class="cursor-pointer d-block text-dark-grey f-13 py-3 px-3 "
                                                href="{{ route('superadmin.faqs.download', md5($file->id)) }}">@lang('app.download')</a>
                                            @if (user()->is_superadmin)
                                            <a class="cursor-pointer d-block text-dark-grey f-13 pb-3 px-3 delete-file"
                                                data-row-id="{{ $file->id }}"
                                                href="javascript:;">@lang('app.delete')</a>
                                            @endif

                                        </div>
                                    </div>
                                </x-slot>
                            </x-file-card>
                        @empty
                            <div class="align-items-center d-flex flex-column text-lightest p-20 w-100">
                                <i class="fa fa-file-excel f-21 w-100"></i>

                                <div class="f-15 mt-4">
                                    - @lang('messages.noFileUploaded') -
                                </div>
                            </div>
                        @endforelse
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('body').on('click', '.delete-notice', function() {
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
                var url = "{{ route('knowledgebase.destroy', $knowledge->id) }}";

                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'POST',
                    url: url,
                    data: {
                        '_token': token,
                        '_method': 'DELETE'
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            window.location.href = response.redirectUrl;
                        }
                    }
                });
            }
        });
    });

    @if (user()->is_superadmin)
    $('body').on('click', '.delete-file', function() {
        var id = $(this).data('row-id');
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
                var url = "{{ route('superadmin.faqs.file-destroy', ':id') }}";
                url = url.replace(':id', id);

                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'POST',
                    url: url,
                    data: {
                        '_token': token
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            $('#knowledgebase-file-list').html(response.view);
                        }
                    }
                });
            }
        });
    });
    @endif

    $('#close-settings').click(function() {
        closeTaskDetail()
    });

</script>
