@forelse ($contacts as $count => $contact)
    <tr class="tableRow{{$contact->id}}">
        <td>{{ $contact->name }}</td>
        <td>{{ $contact->email }}</td>
        <td>{{ $contact->mobile }}</td>
        <td>{{ $contact->relation }}</td>
        <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">

            <div class="task_view-quentin">

                <div class="dropdown">
                    <a class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin dropdown-toggle" type="link"
                        id="dropdownMenuLink-' . $contact->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-options-vertical icons"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-' . $contact->id . '" tabindex="0">
                        <a href="javascript:;" class="dropdown-item show-contact" data-contact-id="{{ $contact->id }}"><i class="fa fa-eye mr-2"></i>@lang('app.view')</a>
                        <a class="dropdown-item edit-contact" href="javascript:;" data-contact-id="{{ $contact->id }}">
                            <i class="fa fa-edit mr-2"></i>
                            @lang('app.edit')
                        </a>
                        <a class="dropdown-item delete-table-row" href="javascript:;" data-row-id="{{ $contact->id }}">
                            <i class="fa fa-trash mr-2"></i>
                            @lang('app.delete')
                        </a>
                    </div>
                </div>
            </div>
        </td>
    </tr>
@empty
    <x-cards.no-record-found-list colspan="5"/>
@endforelse
