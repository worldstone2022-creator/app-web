<x-table class="table-bordered">
    <x-slot name="thead">
        <th>#</th>
        <th>@lang('modules.knowledgeBase.knowledgeHeading')</th>
        <th>@lang('modules.knowledgeBase.knowledgeCategory')</th>
        <th>@lang('app.to')</th>
        <th class="text-right">@lang('app.action')</th>
    </x-slot>

    @forelse ($knowledgebases as $key => $item)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>
                <a href="{{ route('knowledgebase.show', $item->id) }}"
                    class="openRightModal text-darkest-grey d-block">{{ $item->heading }}</a>
            </td>
            <td>{{ $item->knowledgebasecategory->name }}</td>
            <td>{{ $item->to }}</td>
            <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">
                @if ($editKnowledgebasePermission == 'all' || ($editKnowledgebasePermission == 'added' && $item->added_by == user()->id))
                    <div class="task_view-quentin">
                        <a href="{{ route('knowledgebase.edit', $item->id) }}"
                            class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin openRightModal">
                            <i class="fa fa-edit icons mr-2"></i> @lang('app.edit')
                        </a>
                    </div>
                @endif
                @if ($deleteKnowledgebasePermission == 'all' || ($deleteKnowledgebasePermission == 'added' && $item->added_by == user()->id))
                    <div class="task_view-quentin ml-2">
                        <a href="javascript:;" data-article-id="{{ $item->id }}"
                            class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin delete-article">
                            <i class="fa fa-trash icons mr-2"></i> @lang('app.delete')
                        </a>
                    </div>
                @endif
            </td>
        </tr>
    @empty
        <x-cards.no-record-found-list colspan="4"/>
    @endforelse
</x-table>
