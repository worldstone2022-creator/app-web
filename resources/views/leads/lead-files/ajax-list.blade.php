@php
    $deleteLeadFilePermission = user()->permission('delete_lead_files');
    $viewLeadFilePermission = user()->permission('view_lead_files');
@endphp
<x-table class="table-hover bg-white rounded">
    <x-slot name="thead">
        <th>@lang('modules.projects.fileName')</th>
        <th>@lang('app.date')</th>
        <th class="text-right">@lang('app.action')</th>
    </x-slot>
    @forelse($deal->files as $file)
        <tr>
            <td>{{ $file->filename }}</td>
            <td>{{ $file->created_at->diffForHumans() }}</td>
            <td class="text-right pr-20">
                @if ($viewLeadFilePermission == 'all' || ($viewLeadFilePermission == 'added' && $file->added_by == user()->id))
                    <div class="task_view-quentin">

                        <x-file-view-button :file="$file"></x-file-view-button>

                        <div class="dropdown">
                            <a href="{{ route('deal-files.download', $file->id) }}"
                                class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin dropdown-toggle"
                                type="link" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-options-vertical icons"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('deal-files.download', $file->id) }}">
                                    <i class="fa fa-download mr-2"></i>
                                    @lang('app.download')
                                </a>
                                @if ($deleteLeadFilePermission == 'all' || ($deleteLeadFilePermission == 'added' && $file->added_by == user()->id))
                                    <a class="dropdown-item delete-lead-file" href="javascript:;"
                                        data-file-id="{{ $file->id }}">
                                        <i class="fa fa-trash mr-2"></i>
                                        @lang('app.delete')
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="shadow-none">
                <x-cards.no-record icon="file-excel" :message="__('messages.noFileUploaded')" />
            </td>
        </tr>
    @endforelse
</x-table>
