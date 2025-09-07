@php
$editTimelogPermission = user()->permission('edit_timelogs');
$deleteTimelogPermission = user()->permission('delete_timelogs');
$viewTimelogEarningPermission = user()->permission('view_timelog_earnings');
@endphp
<div class="row user-timelogs mt-3">
    <div class="col-md-12">
        <x-table class="table-bordered table-sm-responsive bg-white" headType="thead-light">
            <x-slot name="thead">
                <th>@lang('app.task')</th>
                <th>@lang('app.time')</th>
                <th>@lang('modules.timeLogs.totalHours')</th>
                @if($viewTimelogEarningPermission == 'all')
                    <th>@lang('app.earnings')</th>
                @endif
                <th class="text-right">@lang('app.action')</th>
            </x-slot>

            @forelse($timelogs as $item)
                <tr>
                    <td>
                        @if (!is_null($item->project_id) && !is_null($item->task_id))
                            <h5 class="f-13 text-darkest-grey"><a href="{{ route('tasks.show', $item->task_id) }}"
                                    class="openRightModal">{{ $item->task->heading }}</a></h5>
                            <div class="text-muted">{{ $item->project->project_name }}</div>
                        @elseif (!is_null($item->project_id))
                            <a href="{{ route('projects.show', $item->project_id) }}"
                                class="text-darkest-grey ">{{ $item->project->project_name }}</a>
                        @elseif (!is_null($item->task_id))
                            <a href="{{ route('tasks.show', $item->task_id) }}"
                                class="text-darkest-grey openRightModal">{{ $item->task->heading }}</a>
                        @endif
                    </td>
                    <td>
                        <p>{{ $item->start_time->timezone(company()->timezone)->translatedFormat(company()->date_format . ' ' . company()->time_format) }}
                        </p>
                        {{ $item->end_time->timezone(company()->timezone)->translatedFormat(company()->date_format . ' ' . company()->time_format) }}
                    </td>
                    <td>
                        {{ $item->hours }}
                    </td>
                    @if($viewTimelogEarningPermission == 'all')
                        <td>
                            {{ currency_format($item->earnings, company()->currency_id) }}
                            @if ($item->approved)
                                <i data-toggle="tooltip" data-original-title="{{ __('app.approved') }}"
                                    class="fa fa-check-circle text-primary"></i>
                            @endif
                        </td>
                    @endif
                    <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">
                        <div class="task_view-quentin">
                            <a href="{{ route('timelogs.show', $item->id) }}"
                                class="taskView openRightModal">@lang('app.view')</a>
                            <div class="dropdown">
                                <a class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin dropdown-toggle"
                                    type="link" id="dropdownMenuLink-{{ $item->id }}" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-options-vertical icons"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="dropdownMenuLink-{{ $item->id }}" tabindex="0">

                                    @if (!is_null($item->end_time))
                                        @if ($editTimelogPermission == 'all' || ($editTimelogPermission == 'added' && user()->id == $item->added_by))
                                            @if (!$item->approved)
                                                <a class="dropdown-item approve-timelog" href="javascript:;" data-time-id="{{ $item->id }}">
                                                    <i class="fa fa-check mr-2"></i>
                                                    @lang('app.approve')
                                                </a>
                                            @endif
                                        @endif

                                        @if ($editTimelogPermission == 'all' || ($editTimelogPermission == 'added' && user()->id == $item->added_by))
                                            <a class="dropdown-item openRightModal"
                                                href="{{ route('timelogs.edit', $item->id) }}">
                                                <i class="fa fa-edit mr-2"></i>
                                                @lang('app.edit')
                                            </a>
                                        @endif

                                        @if ($deleteTimelogPermission == 'all' || ($deleteTimelogPermission == 'added' && user()->id == $item->added_by))
                                            <a class="dropdown-item delete-table-row" href="javascript:;"
                                                data-time-id="{{ $item->id }}">
                                                <i class="fa fa-trash mr-2"></i>
                                                @lang('app.delete')
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">@lang('messages.noRecordFound')</td>
                </tr>
            @endforelse
        </x-table>


    </div>
</div>
