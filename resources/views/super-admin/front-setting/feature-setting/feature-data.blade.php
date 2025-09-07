<x-table class="table-sm-responsive table mb-0">
    <x-slot name="thead">
        <th>@lang('app.title')</th>
        @if($type !== 'apps')
            <th>@lang('app.description')</th>
        @endif
        <th>@lang('app.language')</th>
        @if($type != 'settings')
            <th>{{__('superadmin.types.'.$type)}}</th>
        @endif
        <th class="text-right">@lang('app.action')</th>
    </x-slot>

    @forelse($features as $feature)
        <tr class="row{{ $feature->id }}">
            <td>{{ $feature->title }}</td>
            @if($type !== 'apps')
                <td>{!! mb_strimwidth($feature->description, 0, 50, '...')  !!}</td>
            @endif
           <td>{{ $feature->language ? $feature->language->language_name : 'English' }}</td>
           @if($type != 'settings')
            <td @if($feature->type != 'image' && $feature->type != 'apps') style="font-size: 27px" @endif>
                    @if($feature->type == 'image' || $feature->type == 'apps')
                        <img style="max-height: 40px" src="{{ $feature->image_url }}" alt=""/>
                    @elseif ($feature->type == 'icon')
                        <i class="{{ $feature->icon }} f-14"></i>
                    @endif
                </td>
            @endif
            <td class="tw-flex tw-gap-2 tw-justify-end">

                <div class="">
                    <a class="tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md edit-feature"
                       data-id="{{$feature->id}}" data-type="{{$type}}">
                        <i class="fa fa-edit icons mr-1"></i> @lang('app.edit')
                    </a>
                </div>
                <div class="">
                    <a class="tw-border-none tw-bg-red-300 tw-text-start tw-p-2 tw-text-black tw-rounded-md delete-table-row"
                       href="javascript:;" data-id="{{ $feature->id }}" data-type="{{$type}}">
                        <i class="fa fa-trash icons mr-1"></i> @lang('app.delete')
                    </a>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4">
                <x-cards.no-record icon="list" :message="__('messages.noRecordFound')"/>
            </td>
        </tr>
    @endforelse

</x-table>
