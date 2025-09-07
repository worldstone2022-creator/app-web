<div class="col-xl-12 col-lg-12 col-md-12 ntfcn-tab-content-left w-100 p-20">
    <div class="row">
        <div class="table-responsive">

            <x-table class="table-bordered">
                <x-slot name="thead">
                    <th>#</th>
{{--                    <th width="20%">@lang('app.qrCode')</th>--}}
                    <th width="20%">@lang('app.menu.method')</th>
                    <th width="30%">@lang('app.description')</th>
                    <th>@lang('app.status')</th>
                    <th class="text-right">@lang('app.action')</th>
                </x-slot>

                @forelse($offlineMethods as $method)
                    <tr class="row{{ $method->id }}">
                        <td>{{ $loop->iteration }}</td>
{{--                        <td>@if($method->image) <img src="{{$method->image_url}}" height="100px" width="100px">@else - @endif</td>--}}
                        <td>{{ $method->name }}</td>
                        <td class="text-break">{!! nl2br($method->description) !!} </td>
                        <td>{!! ($method->status == 'yes') ? \App\Helper\Common::active(): \App\Helper\Common::inactive() !!}</td>

                        <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">
                            <div class="task_view-quentin">
                                <a href="javascript:;" data-type-id="{{ $method->id }}"
                                   class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin edit-type"
                                   {{-- data-toggle="tooltip" --}}
                                   data-original-title="@lang('app.edit')">
                                    <i class="fa fa-edit icons"></i>
                                </a>
                            </div>
                            <div class="task_view-quentin">
                                <a href="javascript:;" data-type-id="{{ $method->id }}"
                                   class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin delete-type"
                                   {{-- data-toggle="tooltip" --}}
                                   data-original-title="@lang('app.delete')">
                                    <i class="fa fa-trash icons"></i>
                                </a>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <x-cards.no-record-found-list colspan="5"/>
                    </tr>
                @endforelse
            </x-table>

        </div>
    </div>
</div>
