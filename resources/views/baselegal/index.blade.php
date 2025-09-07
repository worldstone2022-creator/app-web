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
            <div class="space-y-6">
                <!-- Statistiques principales -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Documents actifs</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $stats['totalDocuments'] }}
                        </dd>
                    </div>

                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Thématiques</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $stats['totalThematiques'] }}
                        </dd>
                    </div>

                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Sources</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $stats['totalSources'] }}
                        </dd>
                    </div>

                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Documents inactifs</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-red-600">
                            {{ $stats['documentsInactifs'] }}</dd>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Actions rapides -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Actions rapides</h3>
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <a href="{{ route('base-legal.documents.create') }}"
                                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    Nouveau document
                                </a>

                                <a href="{{ route('base-legal.thematiques.create') }}"
                                    class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Nouvelle thématique
                                </a>

                                <a href="{{ route('base-legal.sources.create') }}"
                                    class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Nouvelle source
                                </a>

                                <a href="{{ route('base-legal.consultation') }}"
                                    class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Voir la consultation
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques par type de source -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Répartition par type de source</h3>
                            <div class="space-y-3">
                                @foreach ($sourceStats as $type => $data)
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-600 capitalize">
                                            {{ str_replace('_', ' ', $type) }}
                                        </span>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm text-gray-500">{{ $data['count'] }} source(s)</span>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $data['documents'] }} doc(s)
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents récents et Top thématiques -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Documents récents -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Documents récents</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Les 5 derniers documents ajoutés</p>
                        </div>
                        <ul role="list" class="divide-y divide-gray-200">
                            @forelse($recentDocuments as $document)
                                <li>
                                    <a href="{{ route('base-legal.documents.show', $document) }}"
                                        class="block hover:bg-gray-50">
                                        <div class="px-4 py-4 sm:px-6">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-600 truncate">
                                                        {{ $document->titre }}</p>
                                                    <p class="text-sm text-gray-500">{{ $document->source->type_libelle }}
                                                        - {{ $document->source->nom }}</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <span
                                                        class="text-xs text-gray-400">{{ $document->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="px-4 py-4 sm:px-6 text-center text-gray-500">
                                    Aucun document pour le moment
                                </li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Top thématiques -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Thématiques les plus utilisées</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Top 5 des thématiques</p>
                        </div>
                        <ul role="list" class="divide-y divide-gray-200">
                            @forelse($topThematiques as $thematique)
                                <li>
                                    <a href="{{ route('base-legal.thematiques.show', $thematique) }}"
                                        class="block hover:bg-gray-50">
                                        <div class="px-4 py-4 sm:px-6">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900">{{ $thematique->nom }}</p>
                                                    @if ($thematique->description)
                                                        <p class="text-sm text-gray-500 truncate">
                                                            {{ $thematique->description }}</p>
                                                    @endif
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ $thematique->documents_count }} doc(s)
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="px-4 py-4 sm:px-6 text-center text-gray-500">
                                    Aucune thématique pour le moment
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT WRAPPER END -->
@endsection

@push('scripts')
    @include('sections.datatable_js')

    {{-- <script>

        $(window).on('load', function() {
            @if ($cartProductCount == 0)
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
