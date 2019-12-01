@extends('layouts.admin')
@section('content')
    @include('partials.image-modal')
{{--    @include('partials.property_edit_modal')--}}
    <div class="main-panel">
        <div class="content-wrapper">
            @include('pages.admin.products._create_product')
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('plugins/bootstrap-tagsinput.min.js')}}"></script>
{{--    <script src="{{asset('js/angular.min.js')}}"></script>--}}

    <script>
        var imageBag = [];
        var toolbarOptions = [
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
        ];
        var options = {
            placeholder: 'Product overview...',
            readOnly: false,
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        };
        var description_container = $('#editor').get(0);
        var quill = new Quill(description_container, options);

        var bsmodal = $('#images-modal');
        var mediaUrl = "{{asset('')}}/";
        var productId;
        var properties = {};
        var variants = [];

        (function () {
            if (photoDriver == 'local') {
                mediaUrl = "{{asset('')}}"
            }
            else if (photoDriver == 's3') {
                mediaUrl = s3Url;
            }
        })();


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

        $(document).ready(function () {

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
                        variants_props = [];
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
            })

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
                            var image = mediaUrl + value.file;
                            var id = value.id;
                            bsmodal.find('.image_load_status').html("")
                            bsmodal.find('.modal-body').find('form').append(
                                `<div style="display:inline-block ;" data-imageid="${id}">
                    <img src="${image}" width="100px" height="80px">
                    <input type='checkbox' name='gal_item' value="${id}" data-image_link="${image}" data-image_path="${value.file}" class="gallery_item_checkbox">
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

                $("form[name='add_images_form']").find('input:checkbox:checked').map(function (index, value) {
                    var img_path = $(value).data('image_path');

                    //Add image to imagebag array
                    // check if image exists before adding to the images array

                    if(imageBag.length) {//check if array is empty

                        if (imageBag.indexOf(img_path) === -1) {

                            imageBag.push(img_path)
                            $(".chosen_images").append(
                                `<div class="product_img_container">
                            <div class="product_img_container_delete">
                            <span style="cursor:pointer;" class="badge badge-danger" data-imgpath="${img_path}" onclick="popImage(this)">x</span>
                            </div>
                            <img src="${$(value).data('image_link')}" width="100px" height="80px">
                        </div>
                        `
                            )
                        }else{
                            // console.log('exists')
                        }

                    }else{
                        //if array is empty add the first image
                        imageBag.push(img_path)
                        $(".chosen_images").append(
                            `<div class="product_img_container">
                            <div class="product_img_container_delete">
                            <span style="cursor:pointer;" class="badge badge-danger" data-imgpath="${img_path}" onclick="popImage(this)">x</span>
                            </div>
                            <img src="${$(value).data('image_link')}" width="100px" height="80px">
                        </div>
                        `
                        )
                    }

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
                    url: uploadUrl,
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
                        }
                        else {
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

            //Create product
            $(".add_product_btn").on('click', function (e) {

                e.preventDefault();

                if (imageBag.length == 0) {
                    new PNotify({
                        title: 'Oops!',
                        text: 'No Image selected.',
                        addclass: 'custom_notification',
                        type: 'info'
                    });
                    return false;
                }

                $(".add_product_btn").prop('disabled', true)
                $(".add_product_btn > .process_indicator").removeClass('off');
                $("span.errorshow").html("")

                //Get product properties
                var properties = [];
                $.each($(".property_values select"), function (i, value) {
                    if ($(value).val() != "null") {
                        properties.push($(value).val())
                    }
                });

                //Validate variants
                // console.log($("input[name='is_variant']:checked").length)
                //
                // console.log( ($.isEmptyObject(variants) && Object.values(variants).length === variants.length))
                //
                //

                $.ajax({
                    type: "POST",
                    url: "{!! route('create_products') !!}",
                    data: {
                        form_data: $("form#product_form").serialize(),
                        images: imageBag,
                        description: $(description_container).find('.ql-editor').html(),
                        properties: properties,
                        variants: variants
                    }
                }).done(function (data) {
                    $(".add_product_btn").prop('disabled', false)
                    $(".add_product_btn > .process_indicator").addClass('off');
                    new PNotify({
                        title: 'Success!',
                        text: 'Product created.',
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
                    // if (response.status == 400) {
                    //     $.each(response.responseJSON.message, function (key, item) {
                    //         $("input[name=" + key + "] + span.errorshow").html(item[0]).slideDown("slow")
                    //         $("select[name=" + key + "] + span.errorshow").html(item[0]).slideDown("slow")
                    //     });
                    //     new PNotify({
                    //         title: 'Oops!',
                    //         text: "Form validation error. <br>" + response.responseJSON.error,
                    //         type: 'error'
                    //     });
                    // }
                    else {
                        new PNotify({
                            title: 'Oops!',
                            text: 'An Error Occurred. Please try again.',
                            type: 'error'
                        });
                    }
                })
            });


        });


        //Edit product properties
        $("#update_property_btn").on('click', function () {
            $("#update_property_btn").prop('disabled', true)
            $("#update_property_btn > .process_indicator").removeClass('off');
            updateProperties(productId)
        });

        $("#cancel_update_property_btn").on('click', function () {
            $("#update_property_btn").prop('disabled', false)
            $("#update_property_btn > .process_indicator").addClass('off');
        });

        function editProperty(id, name) {
            productId = id;
            $('#product_name').html($(name).data('product_name'))
            $('#property_edit_modal').modal('show')
        }

        function popImage(e) {
            $(e).parent().parent().fadeOut()
            imageBag = imageBag.filter(function (item) {
                return item != $(e).data('imgpath');
            })
        }

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
                                }
                                else {
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

    </script>
@endpush
