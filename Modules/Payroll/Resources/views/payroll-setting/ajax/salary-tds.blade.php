<div class="col-lg-12 col-md-12 ntfcn-tab-content-left w-100 p-4">
    <div class="table-responsive">
        <x-table class="table-bordered">
            <x-slot name="thead">
                <th>@lang('payroll::modules.payroll.salaryFrom')</th>
                <th>@lang('payroll::modules.payroll.salaryTo')</th>
                <th>@lang('payroll::modules.payroll.salaryPercent')</th>
                <th class="text-right">@lang('app.action')</th>
            </x-slot>

            @forelse($salaryTds as $key=>$tds)
                <tr id="type-{{ $tds->id }}">
                    <td> {{ currency_format($tds->salary_from, $payrollCurrency) }}</td>
                    <td> {{ currency_format($tds->salary_to, $payrollCurrency) }}</td>
                    <td> {{ $tds->salary_percent }}</td>
                    <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">
                        <div class="task_view-quentin">
                            <a href="javascript:;" data-salary-tds-id="{{ $tds->id }}"
                               class="edit-salary-tds task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin">
                                <i class="fa fa-edit icons mr-2"></i> @lang('app.edit')
                            </a>
                        </div>
                        <div class="task_view-quentin">
                            <a href="javascript:;" data-salary-tds-id="{{ $tds->id }}"
                               class="delete-salary-tds task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin">
                                <i class="fa fa-trash icons mr-2"></i> @lang('app.delete')
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        <x-cards.no-record icon="list" :message="__('payroll::messages.noSalaryTdsAdded')"/>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>
</div>

