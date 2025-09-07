<x-table class="table-bordered">
    <x-slot name="thead">
        <th>#</th>
        <th>@lang('modules.knowledgeBase.knowledgeHeading')</th>
        <th>@lang('modules.knowledgeBase.knowledgeCategory')</th>
        @if (user()->is_superadmin)
        <th class="text-right">@lang('app.action')</th>
        @endif
    </x-slot>

    @forelse ($knowledgebases as $key => $item)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>
                <a href="{{ route('superadmin.faqs.show', $item->id) }}"
                    class="openRightModal text-darkest-grey d-block">{{ $item->title }}</a>
            </td>
            <td>{{ $item->category->name }}</td>
            @if (user()->is_superadmin)
                <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">
                    <div class="task_view-quentin">
                        <a href="{{ route('superadmin.faqs.edit', $item->id) }}"
                            class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin openRightModal">
                            <i class="fa fa-edit icons mr-2"></i> @lang('app.edit')
                        </a>
                    </div>
                    <div class="task_view-quentin ml-2">
                        <a href="javascript:;" data-article-id="{{ $item->id }}"
                            class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin delete-article">
                            <i class="fa fa-trash icons mr-2"></i> @lang('app.delete')
                        </a>
                    </div>
                </td>
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="4">
                <x-cards.no-record icon="list" :message="__('messages.noRecordFound')" />
            </td>
        </tr>
    @endforelse
</x-table>
