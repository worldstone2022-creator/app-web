
<div class="table-responsive p-20">
    <x-table class="table-bordered">
        <x-slot name="thead">
            <th>@lang('app.title')</th>
            <th>@lang('app.language')</th>
            <th class="text-right">@lang('app.action')</th>
        </x-slot>

        @forelse($titles as $title)
            <tr class="row{{ $title->id }}">
                <td>{{ $title->testimonial_title }}</td>
                <td>{{ $title->language ? $title->language->language_name : 'English' }}</td>
                <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">
                    <div class="task_view-quentin">
                        <a class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin edit-testimonial-title" data-title-id="{{ $title->id }}" href="javascript:;" >
                            <i class="fa fa-edit icons mr-2"></i>  @lang('app.edit')
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <x-cards.no-record icon="list" :message="__('messages.noRecordFound')" />
                </td>
            </tr>
        @endforelse
    </x-table>
</div>
