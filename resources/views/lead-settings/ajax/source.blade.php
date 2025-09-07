<div class="table-responsive p-20">
    <x-table class="table-bordered">
        <x-slot name="thead">
            <th>#</th>
            <th>@lang('app.name')</th>
            <th class="text-right">@lang('app.action')</th>
        </x-slot>

        @forelse($leadSources as $key => $source)
            <tr class="row{{ $source->id }}">
                <td>{{ ($key+1) }}</td>
                <td>{{ $source->type }}</td>
                <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">
                    <div class="task_view-quentin">
                        <a href="javascript:;" data-source-id="{{ $source->id }}"
                            class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin dropdown-toggle edit-source">
                            <i class="fa fa-edit icons mr-2"></i> @lang('app.edit')
                        </a>
                    </div>
                    <div class="task_view-quentin mt-1 mt-lg-0 mt-md-0">
                        <a href="javascript:;" data-source-id="{{ $source->id }}"
                            class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin dropdown-toggle delete-source">
                            <i class="fa fa-trash icons mr-2"></i> @lang('app.delete')
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">
                    <x-cards.no-record icon="list" :message="__('messages.noLeadSourceAdded')" />
                </td>
            </tr>
        @endforelse
    </x-table>
</div>
