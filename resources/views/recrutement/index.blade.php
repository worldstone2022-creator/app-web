@extends('layouts.app')

@push('datatable-styles')
    @include('sections.datatable_css')
@endpush

@section('filter-section')

    

@endsection



@section('content')
    <!-- CONTENT WRAPPER START -->
    <div class="tw-p-2 quentin-9-08_2025">
        <div class="flex justify-center items-center">
            <h4>
                En cours de developpement...
            </h4>
        </div>
    </div>
    <!-- CONTENT WRAPPER END -->

@endsection

@push('scripts')
    @include('sections.datatable_js')

    {{-- <script>

        $(window).on('load', function() {
            @if($cartProductCount == 0)
              $('#emptyCartBox').hide();
            @endif
        });

        var subCategories = @json($subCategories);

        $('#category_id').change(function(e) {
            // get projects of selected users
            var opts = '';

            var subCategory = subCategories.filter(function(item) {
                return item.category_id == e.target.value
            });

            subCategory.forEach(project => {
                opts += `<option value='${project.id}'>${project.category_name}</option>`
            })

            $('#sub_category').html('<option value="all">@lang("app.all")</option>' + opts)
            $("#sub_category").selectpicker("refresh");
        });

        $('#products-table').on('preXhr.dt', function(e, settings, data) {
            var categoryID = $('#category_id').val();
            var subCategoryID = $('#sub_category').val();
            var searchText = $('#search-text-field').val();
            var unitTypeID  = $('#unit_type_id').val();

            data['category_id'] = categoryID;
            data['sub_category_id'] = subCategoryID;
            data['searchText'] = searchText;
            data['unit_type_id'] = unitTypeID;
        });
        const showTable = () => {
            window.LaravelDataTables["products-table"].draw(true);
        }

        $('#category_id, #sub_category, #unit_type_id').on('change keyup', function() {
            if ($('#category_id').val() != "") {
                $('#reset-filters').removeClass('d-none');
                showTable();
            } else if ($('#sub_category').val() != "") {
                $('#reset-filters').removeClass('d-none');
                showTable();
            } else if ($('#unit_type_id').val() != "") {
                $('#reset-filters').removeClass('d-none');
                showTable();
            }else{
                $('#reset-filters').addClass('d-none');
                showTable();
            }
        });

        $('#search-text-field').on('keyup', function() {
            if ($('#search-text-field').val() != "") {
                $('#reset-filters').removeClass('d-none');
                showTable();
            }
        });

        $('#reset-filters').click(function() {
            $('#filter-form')[0].reset();

            $('#category_id').val('all');
            $('.select-picker').val('all');

            $('#sub_category').html('<option value="all">@lang("app.all")</option>');

            $('#unit_type_id').val('all');

            $('.select-picker').selectpicker("refresh");

            $('#reset-filters').addClass('d-none');

            showTable();
        });

        $('#quick-action-type').change(function() {
            const actionValue = $(this).val();
            if (actionValue != '') {
                $('#quick-action-apply').removeAttr('disabled');

                if (actionValue == 'change-purchase') {
                    $('.quick-action-field').addClass('d-none');
                    $('#change-status-action').removeClass('d-none');
                } else {
                    $('.quick-action-field').addClass('d-none');
                }
            } else {
                $('#quick-action-apply').attr('disabled', true);
                $('.quick-action-field').addClass('d-none');
            }
        });

        $('#quick-action-apply').click(function() {
            const actionValue = $('#quick-action-type').val();
            if (actionValue == 'delete') {
                Swal.fire({
                    title: "@lang('messages.sweetAlertTitle')",
                    text: "@lang('messages.recoverRecord')",
                    icon: 'warning',
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText: "@lang('messages.confirmDelete')",
                    cancelButtonText: "@lang('app.cancel')",
                    customClass: {
                        confirmButton: 'btn btn-primary mr-3',
                        cancelButton: 'btn btn-secondary'
                    },
                    showClass: {
                        popup: 'swal2-noanimation',
                        backdrop: 'swal2-noanimation'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        applyQuickAction();
                    }
                });

            } else {
                applyQuickAction();
            }
        });

        const applyQuickAction = () => {
            var rowdIds = $("#products-table input:checkbox:checked").map(function() {
                return $(this).val();
            }).get();

            var url = "{{ route('products.apply_quick_action') }}?row_ids=" + rowdIds;

            $.easyAjax({
                url: url,
                container: '#quick-action-form',
                type: "POST",
                disableButton: true,
                buttonSelector: "#quick-action-apply",
                data: $('#quick-action-form').serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        showTable();
                        resetActionButtons();
                        deSelectAll();
                        $('#quick-action-form').hide();
                    }
                }
            })
        };

        $('body').on('click', '.productView', function() {
            let id = $(this).data('product-id');

            var url = "{{ route('products.show', ':id') }}";
            url = url.replace(':id', id);

            $(MODAL_DEFAULT + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_DEFAULT, url);
        });

        $('body').on('click', '.delete-table-row', function() {
            var id = $(this).data('product-id');
            Swal.fire({
                title: "@lang('messages.sweetAlertTitle')",
                text: "@lang('messages.recoverRecord')",
                icon: 'warning',
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: "@lang('messages.confirmDelete')",
                cancelButtonText: "@lang('app.cancel')",
                customClass: {
                    confirmButton: 'btn btn-primary mr-3',
                    cancelButton: 'btn btn-secondary'
                },
                showClass: {
                    popup: 'swal2-noanimation',
                    backdrop: 'swal2-noanimation'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('products.destroy', ':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {
                            '_token': token,
                            '_method': 'DELETE'
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                showTable();
                            }
                        }
                    });
                }
            });
        });

        $('body').on('click', '.add-product', function() {
            let cartItems = [];
            var productId = $(this).data('product-id');
            let url = "{{ route('products.add_cart_item') }}";

            $.easyAjax({
                url: url,
                container: '.tw-p-2 quentin-9-08_2025',
                type: "POST",
                data: {
                    'productID': productId,
                    '_token': "{{ csrf_token() }}"
                },
                success: function(response) {
                         $('#emptyCartBox').show();
                        cartItems = response.cartProduct;
                        $('.productCounter').html(cartItems);

                }
            })

        });

        $('body').on('click', '.empty-cart', function() {
            let id = $(this).data('user-id');

            var url = "{{ route('products.remove_cart_item', ':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                container: '#saveInvoiceForm',
                type: "POST",
                blockUI: true,
                data: {
                    _token: "{{ csrf_token() }}",
                    type: "all_data",
                },
                success: function(response) {
                    cartItems = response.productItems;
                    $('.productCounter').html(cartItems);
                    $('#emptyCartBox').hide();

                }
            });
        });

    </script> --}}
@endpush
