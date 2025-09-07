<div class="table-responsive p-20">
    <x-table class="table-bordered">
        <x-slot name="thead">
            <th>@lang('app.name')</th>
            <th class="text-right">@lang('app.action')</th>
        </x-slot>

        @forelse($groups as $group)
            <tr class="row{{ $group->id }}">
                <td>
                    {{ $group->group_name }}
                </td>

                <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">
                    <div class="task_view-quentin">
                        <a href="javascript:;" data-group-id="{{ $group->id }}"
                            class="edit-group task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin dropdown-toggle">
                            <i class="fa fa-edit icons mr-2"></i> @lang('app.edit')
                        </a>
                    </div>
                    <div class="task_view-quentin">
                        <a href="javascript:;" data-group-id="{{ $group->id }}"
                            class="delete-group task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin dropdown-toggle">
                            <i class="fa fa-trash icons mr-2"></i> @lang('app.delete')
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">
                    <x-cards.no-record icon="user" :message="__('messages.noAgentAdded')" />
                </td>
            </tr>
        @endforelse
    </x-table>
</div>
