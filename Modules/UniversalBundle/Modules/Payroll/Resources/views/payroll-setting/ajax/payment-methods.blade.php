<div class="col-lg-12 col-md-12 ntfcn-tab-content-left w-100 p-4">
    <div class="table-responsive">
        <x-table class="table-bordered">
            <x-slot name="thead">
                <th>@lang('app.name')</th>
                <th class="text-right">@lang('app.action')</th>
            </x-slot>

            @forelse($paymentMethods as $key=>$method)
                <tr id="type-{{ $method->id }}">
                    <td> {{ $method->payment_method }}</td>
                    <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">
                        <div class="task_view-quentin">
                            <a href="javascript:;" data-payment-method-id="{{ $method->id }}"
                               class="edit-payment-method task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin">
                                <i class="fa fa-edit icons mr-2"></i> @lang('app.edit')
                            </a>
                        </div>
                        <div class="task_view-quentin">
                            <a href="javascript:;" data-payment-method-id="{{ $method->id }}"
                               class="delete-payment-method task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin">
                                <i class="fa fa-trash icons mr-2"></i> @lang('app.delete')
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        <x-cards.no-record icon="list" :message="__('payroll::messages.noPaymentMethodAdded')"/>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>
</div>
