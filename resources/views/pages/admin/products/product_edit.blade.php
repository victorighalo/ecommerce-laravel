@extends('layouts.admin')
@section('content')
    @include('partials.image-modal')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row justify-content-center flex-grow mb-5 mt-1">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div style="border-bottom: #8c8c8c 1px solid; padding-bottom: 20px">
                                <button
                                    class="btn float-right btn-primary btn-lg font-weight-medium add_product_btn update_product"
                                    type="submit">
                                    <i class="fas fa-spinner fa-spin off process_indicator"></i>
                                    <span><i class="fas fa-save"></i> {{ __('Update') }}</span>
                                </button>
                            <h5 class="card-title"> EDIT PRODUCT - {{$product->title}}
                            </h5>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-sm-12 p-4">
                                        <form id="product_form">
                                            @csrf
                                            <div class="row justify-content-center">
                                                <div class="col-sm-6">
                                                    <div class="row form-group">
                                                        <div class="uipanel">
                                                            <div class="col-sm-12">
                                                                <input type="hidden" name="id" value="{{$product->id}}">
                                                                <label for="name">{{ __('Product name') }}</label>
                                                            <input type="text" id="name" class="form-control"
                                                                   name="name" value="{{$product->title}}" required>
                                                            <span class="invalid-feedback errorshow" role="alert">
                                                            </span>
                                                        </div>
                                                            <div class="col-sm-12 pt-4">
                                                                <div class="text-left">
                                                                    <label
                                                                        for="description">{{ __('Product Description') }}</label>
                                                                    <textarea class="form-control" name="meta_description" id=""
                                                                              cols="30"
                                                                              rows="5">{{$product->meta_description}}</textarea>
                                                                    <span class="invalid-feedback errorshow" role="alert">
                                                            </span>
                                                                </div>
                                                                </div>
                                                            <div class="col-sm-12 pt-4">
                                                                <div class="text-left">
                                                                    <label
                                                                        for="overview">{{ __('Product Overview') }}</label>

                                                                    <div id="editor">
                                                                        {!! $product->description !!}
                                                                    </div>
                                                                    <span class="invalid-feedback errorshow" role="alert">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 pt-4">
                                                            <div class="row">
                                                                <div class="col-sm-12 uipanel">
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                <label
                                                                    for="category_id">{{ __('Product Category') }}</label>
                                                                            <select class="form-control" name="taxon_slug"
                                                                                    id="category_id">
                                                                                @foreach($categories as $category)
                                                                                    @if(count($product->taxons))
                                                                                        {{--@if(!count($category->children))--}}
                                                                                        @if($product->taxons->first()->slug == $category->slug)
                                                                                            <option value="{{$category->slug}}"
                                                                                                    selected>{{$category->taxonomy->name}} {{$category->parent ? ' - ' . $category->parent->name : '' }}
                                                                                                - {{$category->name}}</option>
                                                                                        @else
                                                                                            <option
                                                                                                value="{{$category->slug}}">{{$category->taxonomy->name}} {{$category->parent ? ' - ' .$category->parent->name : '' }}
                                                                                                - {{$category->name}}</option>
                                                                                        @endif
                                                                                    @else
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                            <span class="invalid-feedback errorshow"
                                                                                  role="alert">
                                                                        </span>
                                                                        </div>

                                                                        <div class="col-sm-6">
                                                                            <label for="name">{{ __('Product Tags') }}</label>
                                                                            <input type="text" id="tags" class="form-control"
                                                                                   name="tags" data-role="tagsinput"
                                                                                   value="{{$product->meta_keywords}}" required>
                                                                            <span class="invalid-feedback errorshow"
                                                                                  role="alert">
                                                                    </span>
                                                                        </div>


                                                            </div>
                                                            </div>

                                                                <div class="col-sm-12 pt-3 pb-3 mt-3 uipanel">
                                                                    <h4>Images</h4>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <label>File upload</label>
                                                                            <input type="file" name="img[]"
                                                                                   class="file-upload-default">
                                                                            <div class="input-group col-xs-12">
                                                                                <input type="file"
                                                                                       class="form-control file-upload-info"
                                                                                       id="files_upload"
                                                                                       placeholder="Upload Image">
                                                                                <span class="input-group-append">
                                                        <button class="file-upload-browse btn custom_button_color"
                                                                type="button" id="upload_btn"><i
                                                                class="fas fa-upload"></i> Upload</button>
                                                        </span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-12 mt-5">
                                                                            <label>Select images for the product</label><br>
                                                                            <a href="#" class="btn custom_button_color"
                                                                               id="load_images_btn"><i class="fas fa-image"></i>
                                                                                Choose images</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="chosen_images mt-3">
                                                                        @if($product->hasPhoto())
                                                                            @foreach($product->photos as $image)
                                                                                <div class="product_img_container">
                                                                                    <div class="product_img_container_delete">
                                                                                <span style="cursor:pointer;"
                                                                                      class="badge badge-danger"
                                                                                      data-imageid="{{$image->id}}"
                                                                                      data-productslug="{{$product->slug}}"
                                                                                      onclick="removeProductMedia(this)">x</span>
                                                                                    </div>
                                                                                    @if(config('app.PHOTO_DRIVER') == 'local')
                                                                                        <img
                                                                                            src="{{asset('thumbnail/'.$image->link)}}"
                                                                                            value="{{$image->id}}"
                                                                                            style="width:100px; height:100px">
                                                                                    @elseif(config('app.PHOTO_DRIVER') == 's3')
                                                                                        <img
                                                                                            src="https://s3.{{env('AWS_DEFAULT_REGION') }}.amazonaws.com/{{env('AWS_BUCKET')}}/images/thumbnail/{{$image->link}}"
                                                                                            value="{{$image->id}}"
                                                                                            style="width:100px; height:100px">
                                                                                    @endif
                                                                                    {{--<span style="cursor:pointer;" class="badge badge-danger" onclick="removeSpatieMedia({{$image->id}})">x</span>--}}
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="uipanel row mb-4">
                                                        <div class="col-sm-6">
                                                            <label for="price">{{ __('Price') }} </label>
                                                            <input type="number" name="price" class="form-control"
                                                                   value="{{$product->price}}" required>
                                                            <span class="invalid-feedback errorshow" role="alert">
                                                            </span>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <label
                                                                for="delivery_price">{{ __('Delivery Price') }}</label>
                                                            <input type="number" name="delivery_price"
                                                                   value="{{$product->delivery_price ? $product->delivery_price->amount : 0}}"
                                                                   class="form-control" required>
                                                            <span class="invalid-feedback errorshow" role="alert">
                                                    </span>

                                                    </div>
                                                    </div>

{{--                                                        <div class="col-sm-12">--}}
{{--                                                            <label for="price">{{ __('Properties') }} </label><br>--}}
{{--                                                            @if(isset($product->propertyValues))--}}
{{--                                                                @foreach($product->propertyValues as $propertyValue)--}}
{{--                                                                    {{ $propertyValue->property->name }}: <span--}}
{{--                                                                        class="font-weight-bold text-white"--}}
{{--                                                                        style="color: #000 !important;padding-right: 10px;font-size: 14px">{{ ucfirst($propertyValue->value) }} {{$propertyValue->title ? ucfirst($propertyValue->title) : ''}} | </span>--}}
{{--                                                                @endforeach--}}
{{--                                                            @endif--}}
{{--                                                        </div>--}}


                                                            <div class="row form-group uipanel">
                                                                <div class="col-sm-12">
                                                                    <div class="container">
                                                                        <h5>{{ __('Add Variants') }}</h5>
                                                                        <div class="d-flex justify-content-around" id="variant-properties">
                                                                            @foreach($variants as $index => $property)
                                                                                <div class="variant-item">
                                                                                    <label for="">
                                                                                        {{$property->name}}
                                                                                        <select
                                                                                            class="form-control variant-property"
                                                                                            data-prop_id="{{$property->id}}"
                                                                                            data-prop_name="{{$property->name}}"
                                                                                        >
                                                                                            <option value="">None</option>
                                                                                            @foreach($property->values() as $value)
                                                                                                <option value="{{$value->value}}" data-valueid="{{$value->id}}">{{$value->value}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        {{--                                                                <input type="text"--}}
                                                                                        {{--                                                                       class="form-control variant-property"--}}
                                                                                        {{--                                                                       data-prop_id="{{$property->id}}"--}}
                                                                                        {{--                                                                       data-prop_name="{{$property->name}}"--}}
                                                                                        {{--                                                                >--}}
                                                                                    </label>
                                                                                </div>
                                                                            @endforeach
                                                                            <div class="variant-item">
                                                                                <label for="">
                                                                                    Price
                                                                                    <input value="0" type="number" min="0" class="form-control" id="variant-property-price">
                                                                                </label>
                                                                            </div>
                                                                            <div class="variant-item-button">
                                                                                <button class="btn btn-primary btn-sm add-variant" type="button">Add</button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12 pt-4">
                                                                            <h5>Variants</h5>
                                                                            <div class="row variants_raw_preview">

                                                                            </div>

                                                                            <div class="row variants_preview">

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                <div class="mt-5">
                                                    <button
                                                        class="btn float-right btn-primary btn-lg font-weight-medium add_product_btn update_product"
                                                        type="submit">
                                                        <i class="fas fa-spinner fa-spin off process_indicator"></i>
                                                        <span><i class="fas fa-save"></i> {{ __('Update') }}</span>
                                                    </button>
                                                </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('plugins/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{ asset('assets/js/lodash.min.js')}}"></script>
    <script>
        var bsmodal = $('#images-modal'),
        imageBag = [],
        mediaUrl = "{{asset('')}}/",

        toolbarOptions = [
            ['link', 'image'],
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            ['blockquote', 'code-block'],
            [{'list': 'ordered'}, {'list': 'bullet'}],
            [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
            [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent

            [{'header': [1, 2, 3, 4, 5, 6, false]}],

            [{'color': []}, {'background': []}],          // dropdown with defaults from theme
            [{'font': []}],
            [{'align': []}],

            ['clean']
        ],
        options = {
            readOnly: false,
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        },
        description_container = $('#editor').get(0),
        quill = new Quill(description_container, options),
        variants = [],
        variants_raw = [];

        $(document).ajaxStop($.unblockUI);

        (function setMediaUrl() {
            if (photoDriver == 'local') {
                mediaUrl = "{{asset('')}}"
            } else if (photoDriver == 's3') {
                mediaUrl = s3Url;
            }
        })();

        //raw variant
        function displayRawVariants(variants, index){
            var row = "<div class='col-sm-12 mb-3 variant-container'>";
            row += "<div class='variant-box d-flex justify-content-around'>";
            row += "<div class='variant-desc text-center'>";
            row += "<div style='padding: 8px;'><strong>"+getVariantString(variants.variant_properties)+"</strong></div>";
            row += "</div>"
            row += "<div class='variant-price text-center'>";
            row += "<div><input class='form-control variants-price-input-value' data-variant_id='"+variants.variant_id+"' data-prop-id='"+index+"' type='number' value='"+variants.variant_price+"'></div>"
            row += "</div>"
            row += "<div class='variant-desc text-center'>";
            row += "<i title='Remove' class=\"fas fa-times variant-icon\" onclick='removeRawVariant(this)' data-prop-id='"+index+"' data-variant_id='"+variants.variant_id+"' ></i>"
            row += "</div>";

            row += "</div></div>";
            $(".variants_raw_preview").append(row)
        }


        function isDuplicate(item) {
            var status = 0;
            $.map(variants, function (val, index) {
                item
            })
        }
        function getVariantString(variant) {
            var variant_combo = "";
            $.map(variant, function (val, index) {
                if(index > 0){
                    variant_combo += "/"  + val.property_value
                }else{
                    variant_combo += val.property_value
                }
            })
            return variant_combo;
        }
        function displayVariants(variants, index){
            var row = "<div class='col-sm-12 mb-3 variant-container'>";
            row += "<div class='variant-box d-flex justify-content-around'>";
            row += "<div class='variant-desc text-center'>";
            row += "<div style='padding: 8px;'><strong>"+getVariantString(variants.variant_properties)+"</strong></div>";
            row += "</div>"
            row += "<div class='variant-price text-center'>";
            row += "<div><input class='form-control variants-price-input-value' data-prop-id='"+index+"' type='number' value='"+variants.variant_price+"'></div>"
            row += "</div>"
            row += "<div class='variant-desc text-center'>";
            row += "<i title='Remove' class=\"fas fa-times variant-icon\" onclick='removeVariant(this)' data-prop-id='"+index+"'></i>"
            row += "</div>";

            row += "</div></div>";
            $(".variants_preview").append(row)
        }

        function updateVariant(element){
            variants[$(element).data('prop-id')].variant_price = $(element).val();
        }

        function removeVariant(element){
            //remove item from variants array
            $(element).parent().parent().parent().fadeOut()
            delete variants[$(element).data('prop-id')]
        }

        function removeVariantRaw(element){
            //remove item from variants array
            $(element).parent().parent().parent().fadeOut()
            delete variants_raw[$(element).data('prop-id')]
        }


        $(document).ready(function () {
            {{--console.log({!! $product->variantOptions !!})--}}

                //Load product variants
            (function(){

            var product_options = {!! $product->variants() !!}
            var product_variants_raw = {!! $variants_raw !!}

            if({!! $product->is_variant !!}){
                $.each(product_variants_raw, function (index, option) {
                    var variant_props = [];
                    //Get properties
                    var temp_variant_item = {};
                    $.each(option.options, function (index, item) {
                        if (item) {
                            var variants_props = [];
                            temp_variant_item = {
                                property_id: item.product_option_id,
                                property_name: item.product_option_name,
                                property_value: item.product_option_value,
                                property_value_id: item.product_option_value_id
                            };
                            variant_props.push(temp_variant_item)
                        } else {

                        }

                    });

                    variants_raw.push({
                        variant_properties: variant_props,
                        variant_price: option.price,
                        variant_id: option.variant_id,
                    })

                    displayRawVariants(variants_raw[variants_raw.length - 1], variants_raw.length - 1)
                });
            }
            })()


            $(".add-variant").on('click', function () {
                var variant_props = [],
                    empty = true;

                //validate price
                if(!$("#variant-property-price").val()){
                    new PNotify({
                        title: 'Oops!',
                        text: 'You must add a price value for the variant',
                        addclass: 'custom_notification',
                        type: 'error'
                    });
                    return false;
                }

                //Get properties
                var temp_variant_item = {};
                $.each($("#variant-properties select.variant-property"), function (index, item) {
                    if($(item).val() !== ""){
                        empty = false;
                        var variants_props = [];
                        temp_variant_item = {
                            property_id: $(item).data('prop_id'),
                            property_name: $(item).data('prop_name'),
                            property_value: $(item).val(),
                            property_value_id: $(item).find(':selected').data('valueid')
                        };
                        variant_props.push(temp_variant_item)
                    }else{

                    }

                });

                if(empty){
                    new PNotify({
                        title: 'Oops!',
                        text: 'You must add at least one variant',
                        addclass: 'custom_notification',
                        type: 'error'
                    });
                    return false;
                }

                variants.push({
                    variant_properties: variant_props,
                    variant_price:$("#variant-property-price").val()
                })

                displayVariants(variants[variants.length - 1], variants.length - 1)

            });

            $(".variants_preview").on('change','.variants-price-input-value', function () {
                updateVariant($(this))
            });

            $(".variants_raw_preview").on('change','.variants-price-input-value',
                _.debounce(function () {
                    updateRawVariant($(this))
                }, 1000)
            )

            $(".show_variants_toggle").on("click", function (e) {
                if($(this).is(":checked")){
                    $(".show_variants").toggle()
                }else{
                    $(".show_variants").toggle()
                }
            })


            //load images to modal
            $("#load_images_btn").click(function () {
                $('#images-modal').modal('show')
                $('.modal-content').block({
                    message: '<h5>Loading...</h5>',
                    css: {border: '1px solid #fff'}
                });
                $.ajax({
                    url: "{{route('load_images')}}",
                    type: 'GET',
                })
                    .done(function (data) {
                        $('.modal-content').unblock();
                        bsmodal.find('.modal-body').find('form').empty();
                        $(data).map(function (index, value) {
                                {{--var image = "{!! asset('') !!}" + value.file;--}}
                            var thumb = mediaUrl + value.file;
                            var id = value.id;
                            bsmodal.find('.image_load_status').html("")
                            bsmodal.find('.modal-body').find('form').append(
                                `<div style="display:inline-block ;" data-imageid="${id}">
                    <img src="${thumb}" width="100px" height="80px">
                    <input type='checkbox' name='gal_item' value="${id}" data-image_link="${thumb}" data-image_path="${value.file}" class="gallery_item_checkbox">
                    <span style="cursor:pointer;" class="badge badge-danger" id="${id}" onclick="removeMedia(this)">x</span>
                    </div>
                    `
                            )
                        })
                    }).fail(function (error) {
                    bsmodal.find('.image_load_status').html("Failed to load images. Please Try again.")
                    $('.modal-content').unblock();
                });
            });

            // Add Images to product
            $("#add_images").click(function () {
                imageBag = [];
                $("form[name='add_images_form']").find('input:checkbox:checked').map(function (index, value) {
                    var img_path = $(value).data('image_path');
                    imageBag.push(img_path)
                    $(".chosen_images").append(
                        `<div class="product_img_container">
                            <div class="product_img_container_delete">
                            <span style="cursor:pointer;" class="badge badge-danger" data-imgpath="${img_path}" onclick="popImage(this)">x</span>
                            </div>
                            <img src="${$(value).data('image_link')}" style='width:100px; height:100px'>
                        </div>
                        `
                    )
                })
                $('#images-modal').modal('hide')

            });

            // Upload Action
            $("#upload_btn").click(function (event) {
                event.preventDefault();
                $(".upload_btn").prop('disabled', true)
                $(".upload_btn > .process_indicator").removeClass('off');
                if ($("#files_upload").prop('files').length === 0) {
                    new PNotify({
                        title: 'Oops!',
                        text: "No Content to upload",
                        type: 'error'
                    });
                    return false;
                }

                var uploaded_file = $("#files_upload").prop('files')[0];
                var form_data = new FormData();
                form_data.append('uploaded_file', uploaded_file);
                $.blockUI({message: '<h5>Uploading...</h5>'});
                $.ajax({
                    url: uploadUrl, // point to server-side PHP script
                    data: form_data,
                    type: 'POST',
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                })
                    .done(function (data) {
                        $.unblockUI();
                        $("#upload_btn").prop('disabled', false)
                        $("#upload_btn > .process_indicator").removeClass('on');
                        if (data.status == 0) {
                            new PNotify({
                                title: 'Oops!',
                                text: 'An Error Occurred. Please try again.',
                                addclass: 'custom_notification',
                                type: 'error'
                            });
                        } else {
                            new PNotify({
                                title: 'Success!',
                                text: data.message,
                                addclass: 'custom_notification',
                                type: 'success'
                            });
                        }
                    }).fail(function (error) {
                    $.unblockUI();
                    $("#upload_btn").prop('disabled', false)
                    $("#upload_btn > .process_indicator").removeClass('on');
                    new PNotify({
                        title: 'Oops!',
                        text: 'An Error Occurred. Please try again.',
                        addclass: 'custom_notification',
                        type: 'error'
                    });
                });

            });

            //Update product
            $(".update_product").on('click', function (e) {
                e.preventDefault();
                $(".add_product_btn").prop('disabled', true)
                $(".add_product_btn > .process_indicator").removeClass('off');
                $("span.errorshow").html("")

                var form_data = new FormData();
                // form_data.append('form_data', $(this).serialize());
                form_data.append('images', imageBag);
                $.ajax({
                    type: "POST",
                    url: "{!! route('update_product') !!}",
                    data: {
                        form_data: $("form#product_form").serialize(),
                        images: imageBag,
                        description: $(description_container).find('.ql-editor').html(),
                        variants: variants
                    }
                }).done(function (data) {
                    $(".add_product_btn").prop('disabled', false)
                    $(".add_product_btn > .process_indicator").addClass('off');
                    new PNotify({
                        title: 'Success!',
                        text: 'Product updated.',
                        addclass: 'custom_notification',
                        type: 'success'
                    });
                }).fail(function (response) {
                    $(".add_product_btn").prop('disabled', false)
                    $(".add_product_btn > .process_indicator").addClass('off');
                    if (response.status == 500) {
                        new PNotify({
                            title: 'Oops!',
                            text: 'An Error Occurred. Please try again.',
                            addclass: 'custom_notification',
                            type: 'error'
                        });
                    }
                    if (response.status == 400) {
                        // $.each(response.responseJSON.message, function (key, item) {
                        //     $("input[name="+key+"] + span.errorshow").html(item[0])
                        //     $("input[name="+key+"] + span.errorshow").slideDown("slow")
                        // });
                        new PNotify({
                            title: 'Oops!',
                            text: 'Form validation error.',
                            type: 'error'
                        });
                    } else {
                        new PNotify({
                            title: 'Oops!',
                            text: 'An Error Occurred. Please try again.',
                            type: 'error'
                        });
                    }
                })
            });

        });

        function popImage(e) {
            $(e).parent().parent().fadeOut()
            imageBag = imageBag.filter(function (item) {
                return item != $(e).data('imgpath');
            })
        }

        function removeRawVariant(variant) {
            var item = $(variant);
            PNotify.removeAll();
            new PNotify({
                title: 'Confirm Removal',
                text: 'Are you sure?',
                icon: 'glyphicon glyphicon-question-sign',
                addclass: 'custom_notification',
                hide: false,
                confirm: {
                    confirm: true,
                    buttons: [{
                        text: 'Delete',
                        addClass: 'btn-primary',
                        click: function (notice) {
                            $.ajax({
                                url: "{{route('variant_remove')}}",
                                type: 'POST',
                                data: {id: item.data('variant_id')}
                            }).done(function (data) {
                                notice.update({
                                    title: 'Success',
                                    text: 'Removal successful.',
                                    icon: true,
                                    type: 'success',
                                    hide: true,
                                    confirm: {
                                        confirm: false
                                    },
                                    buttons: {
                                        closer: true,
                                        sticker: true
                                    }
                                });
                                removeVariantRaw(item)
                            }).fail(function (response) {
                                PNotify.removeAll();
                                if (response.status == 500) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'An Error Occurred. Please try again.',
                                        type: 'error'
                                    });
                                    return false
                                }
                                if (response.status == 400) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'Failed to delete variant.',
                                        type: 'error'
                                    });
                                    return false
                                } else {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'An Error Occurred. Please try again.',
                                        type: 'error'
                                    });
                                    return false
                                }
                            })
                        }
                    },
                        {
                            text: 'Cancel',
                            addClass: 'btn-primary',
                            click: function (notice) {
                                notice.update({
                                    title: 'Action Cancelled',
                                    text: 'That was close...',
                                    icon: true,
                                    type: 'danger',
                                    hide: true,
                                    confirm: {
                                        confirm: false
                                    },
                                    buttons: {
                                        closer: true,
                                        sticker: true
                                    }
                                });
                            }
                        }]
                },
                buttons: {
                    closer: true,
                    sticker: true
                },
                history: {
                    history: false
                }
            })
        };

        function updateRawVariant(variant) {
            var item = $(variant);

            PNotify.removeAll();
            new PNotify({
                title: 'Confirm Update',
                text: 'Are you sure?',
                icon: 'glyphicon glyphicon-question-sign',
                addclass: 'custom_notification',
                hide: false,
                confirm: {
                    confirm: true,
                    buttons: [{
                        text: 'Update',
                        addClass: 'btn-primary',
                        click: function (notice) {
                            $.ajax({
                                url: "{{route('variant_update')}}",
                                type: 'POST',
                                data: {id: item.data('variant_id'), price:$(item).val()}
                            }).done(function (data) {
                                notice.update({
                                    title: 'Success',
                                    text: 'Update successful.',
                                    icon: true,
                                    type: 'success',
                                    hide: true,
                                    confirm: {
                                        confirm: false
                                    },
                                    buttons: {
                                        closer: true,
                                        sticker: true
                                    }
                                });
                                variants_raw[$(item).data('prop-id')].variant_price = $(item).val();
                            }).fail(function (response) {
                                PNotify.removeAll();
                                if (response.status == 500) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'An Error Occurred. Please try again.',
                                        type: 'error'
                                    });
                                    return false
                                }
                                if (response.status == 400) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'Failed to update variant.',
                                        type: 'error'
                                    });
                                    return false
                                } else {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'An Error Occurred. Please try again.',
                                        type: 'error'
                                    });
                                    return false
                                }
                            })
                        }
                    },
                        {
                            text: 'Cancel',
                            addClass: 'btn-primary',
                            click: function (notice) {
                                notice.update({
                                    title: 'Action Cancelled',
                                    text: 'That was close...',
                                    icon: true,
                                    type: 'danger',
                                    hide: true,
                                    confirm: {
                                        confirm: false
                                    },
                                    buttons: {
                                        closer: true,
                                        sticker: true
                                    }
                                });
                            }
                        }]
                },
                buttons: {
                    closer: true,
                    sticker: true
                },
                history: {
                    history: false
                }
            })
        };

        function removeMedia(media) {
            var item = $(media);
            PNotify.removeAll();
            new PNotify({
                title: 'Confirm Removal',
                text: 'Are you sure?',
                icon: 'glyphicon glyphicon-question-sign',
                addclass: 'custom_notification',
                hide: false,
                confirm: {
                    confirm: true,
                    buttons: [{
                        text: 'Delete',
                        addClass: 'btn-primary',
                        click: function (notice) {
                            $.ajax({
                                url: "{{route('media_remove')}}",
                                type: 'POST',
                                data: {mediaId: item.attr('id')}
                            }).done(function (data) {
                                notice.update({
                                    title: 'Success',
                                    text: 'Removal successful.',
                                    icon: true,
                                    type: 'success',
                                    hide: true,
                                    confirm: {
                                        confirm: false
                                    },
                                    buttons: {
                                        closer: true,
                                        sticker: true
                                    }
                                });
                                item.parent().fadeOut();
                            }).fail(function (response) {
                                PNotify.removeAll();
                                if (response.status == 500) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'An Error Occurred. Please try again.',
                                        type: 'error'
                                    });
                                    return false
                                }
                                if (response.status == 400) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'Failed to delete image.',
                                        type: 'error'
                                    });
                                    return false
                                } else {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'An Error Occurred. Please try again.',
                                        type: 'error'
                                    });
                                    return false
                                }
                            })
                        }
                    },
                        {
                            text: 'Cancel',
                            addClass: 'btn-primary',
                            click: function (notice) {
                                notice.update({
                                    title: 'Action Cancelled',
                                    text: 'That was close...',
                                    icon: true,
                                    type: 'danger',
                                    hide: true,
                                    confirm: {
                                        confirm: false
                                    },
                                    buttons: {
                                        closer: true,
                                        sticker: true
                                    }
                                });
                            }
                        }]
                },
                buttons: {
                    closer: true,
                    sticker: true
                },
                history: {
                    history: false
                }
            })
        };

        function removeProductMedia(e) {
            var imageid = $(e).data('imageid');
            // var productslug = $(e).data('productslug');
            $.blockUI(
                {
                    message: '<h5>Deleting...</h5>',
                    css: {border: '1px solid #fff'}
                }
            );
            $.ajax({
                url: "{{route('remove_product_media')}}",
                type: 'POST',
                data: {imageid: imageid}
            })
                .done(function (data) {
                    $.unblockUI();
                    $(e).parent().parent().fadeOut();
                    new PNotify({
                        title: 'Success!',
                        text: data.message,
                        type: 'success'
                    });
                }).fail(function (error) {
                $.unblockUI();
                new PNotify({
                    title: 'Oops!',
                    text: 'Failed to delete image.',
                    type: 'error'
                });
            });

        };
    </script>
@endpush
