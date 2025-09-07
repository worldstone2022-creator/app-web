@forelse($faqs as $faq)
    <x-cards.data class="mb-3" :title="$faq->question">
        <x-slot name="action">
            <div class="tw-flex tw-gap-2">
                <div>
                    <a class="tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md"
                        href="javascript:;" data-id="{{ $faq->id }}">
                        <i class="fa fa-edit icons mr-2"></i> @lang('app.edit')
                    </a>
                </div>
                <div>
                    <a class="tw-border-none tw-bg-red-300 tw-text-start tw-p-2 tw-text-black tw-rounded-md"
                        href="javascript:;" data-id="{{ $faq->id }}">
                        <i class="fa fa-trash icons mr-2"></i> @lang('app.delete')
                    </a>
                </div>
            </div>
        </x-slot>

        <div class="ql-editor p-0">
            {!! $faq->answer !!}
        </div>

    </x-cards.data>
@empty
    <x-cards.no-record icon="list" :message="__('messages.noRecordFound')" />
@endforelse
