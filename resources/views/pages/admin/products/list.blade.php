@extends('layouts.admin')
@section('content')
    @include('partials.image-modal')
    @include('partials.property_edit_modal')
    <div class="main-panel">
        <div class="content-wrapper">
            @include('pages.admin._view_products')
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('plugins/bootstrap-tagsinput.min.js')}}"></script>
    <script>
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
        var imageBag = [];
        var productId;
        var productstable = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('get_products') !!}',
            columns: [
                {data: 'name', name: 'name'},
                {data: 'meta_description', name: 'meta_description'},
                {data: 'state', name: 'state'},
                {data: 'price', name: 'price'},
                {data: 'delivery_price', name: 'delivery_price'},
                {data: 'taxons', name: 'meta_keywords'},
                {data: 'meta_keywords', name: 'taxons'},
                {data: 'created_at', name: 'created_at'},
                // { data: 'image', name: 'image' },
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        (function setMediaUrl() {
            if (photoDriver == 'local') {
                mediaUrl = "{{asset('')}}"
            }
            else if (photoDriver == 's3') {
                mediaUrl = s3Url;
            }
        })();


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

        function deactivate(id) {
            PNotify.removeAll();

            new PNotify({
                title: 'Confirm Deactivation',
                text: 'Are you sure?',
                icon: 'glyphicon glyphicon-question-sign',
                addclass: 'custom_notification',
                hide: false,
                confirm: {
                    confirm: true,
                    buttons: [{
                        text: 'Deactivate',
                        addClass: 'btn-primary',
                        click: function (notice) {
                            $.ajax({
                                type: "GET",
                                url: "{!! route('deactivate_product') !!}" + "/" + id
                            }).done(function (data) {
                                notice.update({
                                    title: 'Product deactivated',
                                    text: 'Deactivation successful.',
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
                                productstable.ajax.reload();
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
                                        text: 'Failed to deactivate Product.',
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

        function updateProperties() {
            PNotify.removeAll();
            //Get product properties
            var properties = [];
            $.each($(".edit_property_values select"), function (i, value) {
                if ($(value).val() != "null") {
                    properties.push($(value).val())
                }
            });

            $.ajax({
                type: "POST",
                url: "{!! route('update_product_properties') !!}" + "/" + productId,
                data: {properties: properties, product_id: productId},
                dataType: "json",
            }).done(function (data) {
                new PNotify({
                    title: 'Success!',
                    text: data.message,
                    addclass: 'custom_notification',
                    type: 'success'
                });
                $("#update_property_btn").prop('disabled', false)
                $("#update_property_btn > .process_indicator").addClass('off');
                $('#property_edit_modal').modal('hide')
                productstable.ajax.reload();
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
                        text: 'Failed to deactivate Product.',
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
        };

        function activate(id) {
            PNotify.removeAll();

            new PNotify({
                title: 'Confirm Activation',
                text: 'Are you sure?',
                icon: 'glyphicon glyphicon-question-sign',
                addclass: 'custom_notification',
                hide: false,
                confirm: {
                    confirm: true,
                    buttons: [{
                        text: 'Activate',
                        addClass: 'btn-primary',
                        click: function (notice) {
                            $.ajax({
                                type: "GET",
                                url: "{!! route('activate_product') !!}" + "/" + id
                            }).done(function (data) {
                                notice.update({
                                    title: 'Product activated',
                                    text: 'Activation successful.',
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
                                productstable.ajax.reload();
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
                                        text: 'Failed to Activate Product.',
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

        function destroy(id, catid) {
            if (!catid) {
                catid = 0;
            }
            (new PNotify({
                title: 'Confirm Delete',
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
                                type: "GET",
                                url: "{!! route('destroy_product') !!}" + "/" + id + "/" + catid
                            }).done(function (data) {
                                productstable.ajax.reload();
                                notice.update({
                                    title: 'Product Deleted',
                                    text: data.message,
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
                            }).fail(function (response) {
                                if (response.status == 500) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'An Error Occurred. Please try again.',
                                        type: 'error'
                                    });
                                    return false;
                                }
                                if (response.status == 400) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'Failed to delete Product.',
                                        type: 'error'
                                    });
                                    return false;
                                }
                                else {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'An Error Occurred. Please try again.',
                                        type: 'error'
                                    });
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
            }))
        };

        //Pull products at intervals
        // setInterval(function () {
        //     productstable.ajax.reload();
        // },2000)
    </script>
@endpush
