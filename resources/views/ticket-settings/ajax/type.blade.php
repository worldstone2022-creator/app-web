<div class="table-responsive p-20">
    <x-table class="table-bordered">
        <x-slot name="thead">
            <th>@lang('app.name')</th>
            <th class="text-right">@lang('app.action')</th>
        </x-slot>

        @forelse($ticketTypes as $key => $ticketType)
            <tr class="row{{ $ticketType->id }}">
                <td>{{ $ticketType->type }}</td>
                <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">
                    <div class="task_view-quentin">
                        <a href="javascript:;" data-type-id="{{ $ticketType->id }}" class="edit-type task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin" > <i class="fa fa-edit icons mr-2"></i>  @lang('app.edit')
                        </a>
                    </div>
                    <div class="task_view-quentin mt-1 mt-lg-0 mt-md-0">
                        <a href="javascript:;" class="delete-table-row delete-type task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin" data-type-id="{{ $ticketType->id }}">
                            <i class="fa fa-trash icons mr-2"></i> @lang('app.delete')
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">
                    <x-cards.no-record icon="list" :message="__('messages.noTicketTypeAdded')" />
                </td>
            </tr>
        @endforelse
    </x-table>
</div>
