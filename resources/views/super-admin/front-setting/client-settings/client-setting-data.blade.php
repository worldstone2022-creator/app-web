<x-table class="table-sm-responsive table mb-0">

    <x-slot name="thead">
        <th>@lang('app.name')</th>
        <th>@lang('app.language')</th>
        <th>@lang('superadmin.types.image')</th>
        <th class="text-right">@lang('app.action')</th>
    </x-slot>

    @forelse($clients as $client)
        <tr class="row{{ $client->id }}">
            <td>{{ $client->title }}</td>
            <td>{{ $client->language ? $client->language->language_name : 'English' }}</td>
            <td>
                <img height="40" width="120" src="{{ $client->image_url }}" alt=""/>
            </td>
            <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">
                {{-- <div class="task_view-quentin">
                    <a class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin edit-client" href="javascript:;" data-id="{{$client->id}}">
                        <i class="fa fa-edit icons mr-2"></i>  @lang('app.edit')
                    </a>
                </div> --}}
                <div class="task_view-quentin mt-1 mt-lg-0 mt-md-0">
                    <a class="task_view-quentin_more quentin-deleted-btn tw-border-none tw-bg-red-300 tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin-deleted-btn delete-table-row" href="javascript:;" data-id="{{ $client->id }}">
                        <i class="fa fa-trash icons mr-2"></i> @lang('app.delete')
                    </a>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4">
                <x-cards.no-record icon="list" :message="__('messages.noRecordFound')" />
            </td>
        </tr>
    @endforelse
</x-table>
