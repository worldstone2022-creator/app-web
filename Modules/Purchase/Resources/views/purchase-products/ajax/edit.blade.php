@php
$addProductCategoryPermission = user()->permission('manage_product_category');
$addProductSubCategoryPermission = user()->permission('manage_product_sub_category');
@endphp

<link rel="stylesheet" href="{{ asset('vendor/css/dropzone.min.css') }}">
<style>
    .product_type{
        margin-top: 0px !important;
    }
    .track_inventory_label {
        margin-left: 30px !important;
    }

    #purchase_price_div {
        margin-top: 30px !important;
    }

    .purchase-info {
        margin-top: 13px !important;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <x-form id="save-product-data-form" method="PUT">
            <div class="add-client bg-white rounded">
                <h4 class="mb-0 p-20 f-21 font-weight-normal  border-bottom-grey">
                    @lang('app.menu.editProducts') </h4>
                <div class="row p-20">
                    <div class="col-lg-12">
                        <div class="row">

                            <input type="hidden" id="hiddenProductId" value="{{ $product->id }}">

                            <div class="col-md-4">
                                <x-forms.label class="my-3" fieldId=""
                                            :fieldLabel="__('purchase::modules.product.type')">
                                </x-forms.label><sup class="text-red f-14 mr-1">*</sup>
                                <div class="form-group">
                                    <div class="d-flex">
                                        <x-forms.radio fieldId="goods_type" class="product_type"
                                            :fieldLabel="__('purchase::modules.product.goods')" fieldName="type"
                                            fieldValue="goods" checked="true" :checked="$product->type == 'goods'">
                                        </x-forms.radio>
                                            <x-forms.radio class="product_type" fieldId="service_type" :fieldLabel="__('purchase::modules.product.service')"
                                            fieldValue="service" fieldName="type" :checked="$product->type == 'service'"></x-forms.radio>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <x-forms.text fieldId="name" :fieldLabel="__('app.name')" fieldName="name"
                                    fieldRequired="true" :fieldPlaceholder="__('placeholders.productName')"
                                    :fieldValue="$product->name">
                                </x-forms.text>
                            </div>

                            <div class="col-md-4" id="sku_id">
                                <x-forms.text fieldId="sku" :fieldLabel="__('purchase::app.sku')" fieldName="sku"
                                            :fieldPlaceholder="__('placeholders.hsnSac')" :fieldValue="$product->sku">
                                </x-forms.text>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <x-forms.label class="my-3" fieldId="" :fieldLabel="__('modules.unitType.unitType')">
                                </x-forms.label>
                                <x-forms.input-group>
                                    <select class="form-control select-picker" name="unit_type" id="unit_type_id"
                                            data-live-search="true">
                                        @foreach ($unit_types as $unit_type)
                                            <option value="{{ $unit_type->id }}" @if ($unit_type->id == $product->unit_id) selected @endif>{{ $unit_type->unit_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </x-forms.input-group>
                            </div>

                            <div class="col-md-4">
                                <x-forms.label class="my-3" fieldId="category_id"
                                    :fieldLabel="__('modules.productCategory.productCategory')">
                                </x-forms.label>
                                <x-forms.input-group>
                                    <select class="form-control select-picker height-35" name="category_id"
                                        id="product_category_id" data-live-search="true">
                                        <option value="">--</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @if ($category->id == $product->category_id) selected @endif>{{ mb_ucwords($category->category_name) }}</option>
                                        @endforeach
                                    </select>

                                    @if ($addProductCategoryPermission == 'all' || $addProductCategoryPermission == 'added')
                                        <x-slot name="append">
                                            <button id="add-category" type="button"
                                                class="btn btn-outline-secondary border-grey height-35">@lang('app.add')</button>
                                        </x-slot>
                                    @endif
                                </x-forms.input-group>
                            </div>

                            <div class="col-md-4">
                                <x-forms.label class="my-3" fieldId=""
                                    :fieldLabel="__('modules.productCategory.productSubCategory')">
                                </x-forms.label>
                                <x-forms.input-group>
                                    <select class="form-control select-picker" name="sub_category_id"
                                        id="sub_category_id" data-live-search="true">
                                        <option value="">@lang('messages.noProductSubCategoryAdded')</option>
                                        @if ($product->category_id)
                                            @foreach ($product->category->subCategories as $category)
                                                <option value="{{ $category->id }}" @if ($category->id == $product->sub_category_id) selected @endif>{{ mb_ucwords($category->category_name) }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                    @if ($addProductSubCategoryPermission == 'all' || $addProductSubCategoryPermission == 'added')
                                        <x-slot name="append">
                                            <button id="add-sub-category" type="button"
                                                class="btn btn-outline-secondary border-grey"
                                                data-toggle="tooltip" data-original-title="{{ __('app.add').' '.__('modules.productCategory.productSubCategory') }}">@lang('app.add')</button>
                                        </x-slot>
                                    @endif
                                </x-forms.input-group>
                            </div>

                            <div class="col-lg-6 col-md-6 mt-4 mb-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <x-forms.label class="my-3" fieldId="sales_information"
                                                    :fieldLabel="__('purchase::app.salesInformation')">
                                        </x-forms.label>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group mb-lg-0 mb-md-0 mb-4">
                                            <label class="f-14 text-dark-grey mb-12 "
                                                for="selling_price">@lang('purchase::app.sellingPrice')<sup class="text-red f-14 mr-1">*</sup></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend  height-35">
                                                    <span class="input-group-text border-grey f-15 bg-additional-grey px-3 text-dark"
                                                        id="basic-addon1">{{ company()->currency->currency_code }}</span>
                                                </div>
                                                <input type="number" name="selling_price" id="selling_price"
                                                    class="form-control height-35 f-15 readonly-background" value="{{ $product->price ? $product->price : 0 }}" aria-label="0019" aria-describedby="basic-addon1" min="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 mt-4 mb-4">
                                <div class="row">
                                    <div class="col-md-12 purchase-info">
                                        <x-forms.checkbox class="mr-0 mr-lg-2 mr-md-2" :checked="$product->purchase_information == 1" :fieldLabel="__('purchase::app.purchaseInformation')"
                                            fieldName="purchase_information" fieldId="purchase_information" :fieldValue="1"
                                            fieldRequired="true" :popover="__('purchase::app.purchaseInformation')"/>
                                    </div>
                                </div>

                                <div class="row purchase_information @if($product->purchase_information == 0) d-none @endif" id="purchase_price_div">
                                    <div class="col-md-12">
                                        <div class="form-group mb-lg-0 mb-md-0 mb-4">
                                            <label class="f-14 text-dark-grey mb-12 "
                                                for="purchase_price">@lang('purchase::app.costPrice')<sup class="text-red f-14 mr-1">*</sup></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend  height-35 ">
                                                    <span class="input-group-text border-grey f-15 bg-additional-grey px-3 text-dark"
                                                        id="basic-addon1">{{ company()->currency->currency_code }}</span>
                                                </div>
                                                <input type="number" name="purchase_price" id="purchase_price"
                                                    class="form-control height-35 f-15 readonly-background" value="{{ $product->purchase_price ? $product->purchase_price : 0 }}" aria-label="0019" aria-describedby="basic-addon1" min="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 my-3">
                                <x-forms.label fieldId="multiselect" :fieldLabel="__('modules.invoices.tax')">
                                </x-forms.label>
                                <x-forms.input-group>
                                    <select class="form-control select-picker" name="tax[]" id="multiselect"
                                        data-live-search="true" multiple="true">
                                        @foreach ($taxes as $tax)
                                            <option value="{{ $tax->id }}" @if (isset($product->taxes) && array_search($tax->id, json_decode($product->taxes)) !== false) selected @endif>
                                                {{ strtoupper($tax->tax_name) }}: {{ $tax->rate_percent }}%
                                            </option>
                                        @endforeach
                                    </select>

                                    @if (user()->permission('manage_tax') == 'all')
                                        <x-slot name="append">
                                            <button id="add-tax" type="button"
                                                class="btn btn-outline-secondary border-grey"
                                                data-toggle="tooltip"
                                            data-original-title="{{ __('app.add').' '.__('modules.invoices.tax') }}">@lang('app.add')</button>
                                        </x-slot>
                                    @endif
                                </x-forms.input-group>
                            </div>

                            <div class="col-md-4">
                                <x-forms.text fieldId="hsn_sac_code" :fieldLabel="__('app.hsnSac')"
                                    fieldName="hsn_sac_code" :fieldPlaceholder="__('placeholders.hsnSac')"
                                    :fieldValue="$product->hsn_sac_code">
                                </x-forms.text>
                            </div>

                            <div class="col-lg-2 col-md-3 mt-5">
                                <x-forms.checkbox class="mr-0 mr-lg-2 mr-md-2" :fieldLabel="__('app.purchaseAllow')"
                                    fieldName="purchase_allow" fieldId="purchase_allow" fieldValue="no"
                                    fieldRequired="true" :checked="$product->allow_purchase == 1" />
                            </div>

                            <div class="col-lg-2 col-md-3 mt-5">
                                <x-forms.checkbox class="mr-0 mr-lg-2 mr-md-2" :fieldLabel="__('app.downloadable')"
                                    fieldName="downloadable" fieldId="downloadable" fieldValue="true"
                                    fieldRequired="true" :popover="__('messages.downloadable')" :checked="$product->downloadable == 1" />
                            </div>

                            <div class="col-lg-12 col-xl-12  mt-2 downloadable {{$product->downloadable ? '' : 'd-none'}}">
                                <x-forms.file class="mr-0 mr-lg-2 mr-md-2" :fieldLabel="__('app.downloadableFile')"
                                    fieldName="downloadable_file" fieldId="downloadable_file" fieldRequired="true" :fieldValue="$product->download_file_url" />
                            </div>

                            <div class="col-md-12 mt-4 {{ ($product && $product->type == 'service') ? 'd-none' : '' }} track_inventory_div">
                                @if($product->track_inventory == 1 && isset($trackInventory) && $trackInventory == 'disable')
                                    <x-forms.checkbox class="mr-0 mr-lg-2 mr-md-2" :fieldLabel="__('purchase::app.trackInventory')" fieldName="track_inventory" fieldId="track_inventory" :fieldValue="1"
                                        fieldRequired="true" :checked="$product->track_inventory == 1" disabled/>
                                @else
                                    <x-forms.checkbox class="mr-0 mr-lg-2 mr-md-2" :fieldLabel="__('purchase::app.trackInventory')" fieldName="track_inventory" fieldId="track_inventory" :fieldValue="1"
                                    fieldRequired="true" :checked="$product->track_inventory == 1"/>
                                @endif
                                <label for="" class="track_inventory_label text-dark-grey f-13" id="track_inventory_label">@lang('purchase::messages.trackInventoryMsg')</label>
                            </div>

                            <div class="col-md-12 mt-3 track_inventory {{ ($product && ($product->type == 'service' || $product->track_inventory == 0)) ? 'd-none' : '' }} {{ $product->track_inventory ? '' : 'd-none'}}">
                                <div class="row">
                                    <div class="col-md-6">
                                        @if($product->track_inventory == 1)
                                            <x-forms.text fieldId="opening_stock" fieldRequired="true" fieldReadOnly="true" :fieldLabel="__('purchase::app.openingStock')" fieldName="opening_stock" :fieldPlaceholder="__('purchase::placeholders.openingStock')" fieldValue="{{ $product->quantityInventory->net_quantity }}"
                                                :popover="__('purchase::app.availableStock')">
                                            </x-forms.text>
                                        @else
                                            <x-forms.text fieldId="opening_stock" fieldRequired="true" :fieldLabel="__('purchase::app.openingStock')" fieldName="opening_stock" :fieldPlaceholder="__('purchase::placeholders.openingStock')" fieldValue="{{ $product->opening_stock }}"
                                                :popover="__('purchase::app.availableStock')">
                                            </x-forms.text>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <x-forms.label class="my-3" fieldId="description-text"
                                        :fieldLabel="__('app.description')">
                                    </x-forms.label>
                                    <textarea name="description" id="description-text" rows="4" class="form-control f-14 w-100">{{ $product->description }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <x-forms.file-multiple class="mr-0 mr-lg-2 mr-md-2" :fieldLabel="__('purchase::modules.product.addImages')"
                                    fieldName="file" fieldId="file-upload-dropzone" />
                            </div>

                        </div>
                    </div>

                </div>

                <x-forms.custom-field :fields="$fields" :model="$productData"></x-forms.custom-field>

                <x-form-actions>
                    <x-forms.button-primary id="save-product-form" class="mr-3" icon="check">@lang('app.save')
                    </x-forms.button-primary>
                    <x-forms.button-cancel :link="route('purchase-products.index')" class="border-0">@lang('app.cancel')
                    </x-forms.button-cancel>
                </x-form-actions>
            </div>
        </x-form>

    </div>
</div>

<script>
    $(document).ready(function() {

        let lastIndex = 0;
        let defaultImage = '';
        var mockFile = {!! $images !!};

        Dropzone.autoDiscover = false;

        // Dropzone class
        productDropzone = new Dropzone("div#file-upload-dropzone", {
            dictDefaultMessage: "{{ __('app.dragDrop') }}",
            url: "{{ route('product-files.update_images') }}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            paramName: "file",
            maxFilesize: DROPZONE_MAX_FILESIZE,
            maxFiles: DROPZONE_MAX_FILES,
            autoProcessQueue: false,
            uploadMultiple: true,
            addRemoveLinks: true,
            parallelUploads: DROPZONE_MAX_FILES,
            acceptedFiles: 'image/*',
            init: function() {
                productDropzone = this;
            },
            removedfile: function (file) {
                var index = mockFile.findIndex(x => x.name == file.name);
                mockFile.splice(index, 1);

                if(typeof(file.id) != 'undefined') {
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
                            var token = "{{ csrf_token() }}";

                            var url = "{{ route('product-files.destroy', ':id') }}";
                            url = url.replace(':id', file.id);

                            $.easyAjax({
                                type: 'POST',
                                url: url,
                                data: {
                                    '_token': token,
                                    '_method': 'DELETE'
                                },
                                success: function(response) {
                                    //This will manually removed the file
                                    file.previewElement.remove();

                                    if ('{{ $product->default_image }}' == file.hashname) {
                                        let $radio = $('.custom-control-input');
                                        $radio[1].checked = true;
                                    }
                                }
                            });
                        }
                    });

                    return false;
                }

                //This will manually removed the file
                file.previewElement.remove();
            }
        });


        productDropzone.on('sending', function (file, xhr, formData) {
            // const productID = $('#hiddenProductId').val();
            var productID = '{{ $product->id }}';
            formData.append('product_id', productID);
            formData.append('default_image', defaultImage);

            if (mockFile.length > 0) {
                formData.append('uploaded_files', JSON.stringify(mockFile));
            }


            $.easyBlockUI();
        });
        productDropzone.on('uploadprogress', function () {
            $.easyBlockUI();
        });
        productDropzone.on('completemultiple', function () {
            window.location.href = '{{ route("purchase-products.index") }}';
        });

        productDropzone.on('removedfile', function () {
            var grp = $('div#file-upload-dropzone').closest(".form-group");
            var label = $('div#file-upload-box').siblings("label");
            $(grp).removeClass("has-error");
            $(label).removeClass("is-invalid");
        });

        productDropzone.on('error', function (file, message) {
            productDropzone.removeFile(file);
            var grp = $('div#file-upload-dropzone').closest(".form-group");
            var label = $('div#file-upload-box').siblings("label");
            $(grp).find(".help-block").remove();
            var helpBlockContainer = $(grp);

            if (helpBlockContainer.length == 0) {
                helpBlockContainer = $(grp);
            }

            helpBlockContainer.append('<div class="help-block invalid-feedback">' + message + '</div>');
            $(grp).addClass("has-error");
            $(label).addClass("is-invalid");

        });


        productDropzone.on('addedfile', function(file) {
            lastIndex++;

            var div = document.createElement('div');
            div.className = 'form-check-inline custom-control custom-radio mt-2';

            var input = document.createElement('input');
            input.className = 'custom-control-input';
            input.type = 'radio';
            input.name = 'default_image';
            input.id = 'default-image-'+lastIndex;
            input.value = file.hashname != undefined ? file.hashname : file.name;
            if (lastIndex == 1) {
                input.checked = true;
            }
            if ('{{ $product->default_image }}' == file.hashname) {
                input.checked = true;
            }
            div.appendChild(input);

            var label = document.createElement('label');
            label.className = 'custom-control-label pt-1 cursor-pointer';
            label.innerHTML = "@lang('modules.makeDefaultImage')";
            label.htmlFor = 'default-image-'+lastIndex;
            div.appendChild(label);

            file.previewTemplate.appendChild(div);
        });

            mockFile.forEach(file => {
            productDropzone.emit('addedfile', file);
            productDropzone.emit('thumbnail', file, file.file_url);
            productDropzone.files.push(file);
            productDropzone.emit("complete", file);
        });

        productDropzone.options.maxFiles = productDropzone.options.maxFiles - mockFile.length;

        $('#service_type').on('click', function(){
            $('#sku_id').addClass('d-none');
        });

        $('#goods_type').on('click', function(){
            $('#sku_id').removeClass('d-none');
        });

        $('input[type=radio][name=type]').change(function() {
            if (this.value == 'service') {
                $('#track_inventory').prop('checked', true);
                $('#track_inventory').prop('checked', false);

                $('#opening_stock, #rate_per_unit').val('');
                $('.track_inventory').addClass('d-none');
                $('.track_inventory_div').addClass('d-none');
            }
            else if (this.value == 'goods') {
                $('#opening_stock, #rate_per_unit').val('');
                $('.track_inventory').addClass('d-none');
                $('.track_inventory_div').removeClass('d-none');
            }
        });

        $('#save-product-form').click(function() {
            const url = "{{ route('purchase-products.update', [$product->id]) }}";

            $.easyAjax({
                url: url,
                container: '#save-product-data-form',
                type: "POST",
                disableButton: true,
                blockUI: true,
                buttonSelector: "#save-product-form",
                file: true,
                data: $('#save-product-data-form').serialize(),
                success: function(response) {
                    if (productDropzone.getQueuedFiles().length > 0) {
                        productID = response.productID
                        defaultImage = response.defaultImage;
                        $('#hiddenProductId').val(productID);
                        productDropzone.processQueue();
                    }
                    else{
                        if ($(MODAL_XL).hasClass('show')) {
                            $(MODAL_XL).modal('hide');
                            window.location.reload();
                        } else {
                            window.location.href = response.redirectUrl;
                        }
                    }
                }
            });
        });

        $('#product_category_id').change(function(e) {
            let categoryId = $(this).val();

            var url = "{{ route('get_product_sub_categories', ':id') }}";
            url = url.replace(':id', categoryId);

            $.easyAjax({
                url: url,
                type: "GET",
                success: function(response) {
                    if (response.status == 'success') {
                        var options = [];
                        var rData = [];
                        rData = response.data;
                        $.each(rData, function(index, value) {
                            var selectData = '';
                            selectData = '<option value="' + value.id + '">' + value
                                .category_name + '</option>';
                            options.push(selectData);
                        });

                        $('#sub_category_id').html('<option value="">--</option>' + options);
                        $('#sub_category_id').selectpicker('refresh');
                    }
                }
            })
        });

        $('#add-category').click(function() {
            const url = "{{ route('productCategory.create') }}";
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        })

        $('#add-sub-category').click(function() {
            const url = "{{ route('productSubCategory.create') }}";
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });

        $('#add-tax').click(function() {
            const url = "{{ route('taxes.create') }}";
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });

        $('#downloadable').change(function() {
            if ($(this).is(':checked')) {
                $('.downloadable').removeClass('d-none');
            } else {
                $('.downloadable').addClass('d-none');
            }
        });

        $('#sales_information').change(function () {
            if ($(this).is(':checked')) {
                $('.sales_information').removeClass('d-none');
            } else {
                $('.sales_information').addClass('d-none');
            }
        });

        $('#purchase_information').change(function () {
            if ($(this).is(':checked')) {
                $('.purchase_information').removeClass('d-none');
            } else {
                $('.purchase_information').addClass('d-none');
            }
        });

        $('#track_inventory').change(function () {
            if ($(this).is(':checked')) {
                $('.track_inventory').removeClass('d-none');
            } else {
                $('.track_inventory').addClass('d-none');
            }
        });

        <x-forms.custom-field-filejs/>

        init(RIGHT_MODAL);

        $('#downloadable').change(function() {
            if ($(this).is(':checked')) {
                $('.downloadable').removeClass('d-none');
            } else {
                $('.downloadable').addClass('d-none');
            }
        });
    });

</script>
