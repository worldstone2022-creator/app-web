
<div class="table-responsive p-20">
    <x-table class="table-bordered">
        <x-slot name="thead">
            <th>@lang('app.name')</th>
            <th>@lang('app.comment')</th>
            <th>@lang('app.language')</th>
            <th>@lang('app.rating')</th>
            <th class="text-right">@lang('app.action')</th>
        </x-slot>

        @forelse($testimonials as $testimonial)
            <tr class="row{{ $testimonial->id }}">
                <td>{{ $testimonial->name }}</td>
                <td>{!! nl2br($testimonial->comment)  !!}</td>
                <td>{{ $testimonial->language ? $testimonial->language->language_name : 'English' }}</td>
                <td>{{ $testimonial->rating }}</td>
                <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">
                    <div class="task_view-quentin">
                        <a class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin edit-testimonial" data-testimonial-id="{{ $testimonial->id }}" href="javascript:;" >
                            <i class="fa fa-edit icons mr-2"></i>  @lang('app.edit')
                        </a>
                    </div>
                    <div class="task_view-quentin mt-1 mt-lg-0 mt-md-0">
                        <a class="task_view-quentin_more quentin-deleted-btn tw-border-none tw-bg-red-300 tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin-deleted-btn delete-table-row delete-testimonial" href="javascript:;" data-testimonial-id="{{ $testimonial->id }}">
                            <i class="fa fa-trash icons mr-2"></i> @lang('app.delete')
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
