<div class="table-responsive p-20">
    <x-table class="table-bordered">
        <x-slot name="thead">
            <th>#</th>
            <th width="35%">@lang('modules.projectCategory.categoryName')</th>
            <th>&nbsp;</th>
            <th class="text-right">@lang('app.action')</th>
        </x-slot>

         @forelse($leadCategories as $key => $category)
            <tr class="row{{ $category->id }}">
                <td>{{ ($key+1) }}</td>
                <td>{{ $category->category_name }}</td>
                <td>
                    <x-forms.radio fieldId="category_{{ $category->id }}" class="is_default"
                        data-category-id="{{ $category->id }}" :fieldLabel="__('app.default')" fieldName="is_default"
                        fieldValue="{{ $category->is_default }}" :checked="$category->is_default == 1 ? 'checked' : ''">
                    </x-forms.radio>
                </td>
                <td class="quentin-table tw-flex tw-justify-end tw-gap-2 quentin-table">
                    <div class="task_view-quentin">
                        <a href="javascript:;" data-category-id="{{ $category->id }}" class="edit-category task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin" > <i class="fa fa-edit icons mr-2"></i>  @lang('app.edit')
                        </a>
                    </div>
                    <div class="task_view-quentin">
                        <a href="javascript:;" class="delete-category task_view-quentin_more quentin tw-border-none tw-bg-[#838383] tw-text-start tw-p-2 tw-text-white tw-rounded-md quentin" data-category-id="{{ $category->id }}">
                            <i class="fa fa-trash icons mr-2"></i> @lang('app.delete')
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <x-cards.no-record-found-list colspan="4"/>
        @endforelse
    </x-table>
</div>
<script>
    $('body').on('click', '.is_default', function() {
        var categoryId = $(this).data('category-id');
        var token = "{{ csrf_token() }}";
        console.log(categoryId);

        $.easyAjax({
            url: "{{ route('category.updateDefault') }}",
            type: "POST",
            data: {
                categoryId: categoryId,
                _token: token
            },
            blockUI: true,
            container: '#editSettings',
            success: function(response) {
                if (response.status == "success") {
                    window.location.reload();
                }
            }
        });
    });
</script>
