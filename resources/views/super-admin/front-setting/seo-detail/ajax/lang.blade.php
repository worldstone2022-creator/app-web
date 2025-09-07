<div class="col-lg-12 col-md-12 ntfcn-tab-content-left w-100 p-0">

    <x-table class="table-sm-responsive table mb-0">
        <x-slot name="thead">
            <th>{{__('superadmin.ogImage')}}</th>
            <th>@lang('app.name')</th>
            <th>@lang("superadmin.frontCms.seo_title")</th>
            <th>@lang('superadmin.frontCms.seo_author')</th>
            <th>@lang('superadmin.frontCms.seo_description')</th>
            <th>@lang('superadmin.frontCms.seo_keywords')</th>
            <th class="text-right">@lang('app.action')</th>
        </x-slot>

        @forelse($seoDetails as $seoDetail)
            <tr>
                <td>
                    <img src="{{($seoDetail->og_image ? $seoDetail->masked_og_image_url : $seoDetail->og_image_url)}}" alt="" height="50px" width="50px">
                </td>
                <td>{{ $seoDetail->page_name }}

                </td>
                <td>{{ $seoDetail->seo_title }}</td>
                <td>{{ $seoDetail->seo_author }}</td>
                <td>{!! mb_strimwidth($seoDetail->seo_description, 0, 50, '...')  !!}</td>
                <td>{!! mb_strimwidth($seoDetail->seo_keywords, 0, 50, '...')  !!}</td>
                <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">
                    <div class="task_view-quentin">
                        <a class="task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin edit-seo "
                           data-id="{{ $seoDetail->id }}"
                           href="javascript:;">
                            <i class="fa fa-edit icons mr-2"></i> @lang('app.edit')
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <x-cards.no-record-found-list/>
        @endforelse

    </x-table>

</div>
