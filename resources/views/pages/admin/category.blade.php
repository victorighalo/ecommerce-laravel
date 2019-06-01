@extends('layouts.admin')
@section('content')
    @include('partials.category_modal')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row justify-content-center flex-grow mb-5 mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">  Create categories
                                <a class="btn btn-link float-right" data-toggle="collapse" href="#form_collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a></h4>
                            <div class="" id="form_collapse">
                                <div class="row">
                                    <div class="col-sm-4 p-4">
                                    @include('pages.admin.category._create_category')
                                    </div>
                                    <div class="col-sm-8 p-4">
                                    @include('pages.admin.category._view_categories')
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
    <script>
        var taxonomy_id, taxon_id;
        $(document).ready(function () {
            $("form#category_form").on('submit', function (e) {
                e.preventDefault();
                $(".add_category_btn").prop('disabled', true)
                $(".add_category_btn > .process_indicator").removeClass('off');
                $("span.errorshow").html("")
                $.ajax({
                    type: "POST",
                    url: "{!! route('create_category') !!}",
                    data: $(this).serialize()
                }).done(function (data) {
                    $(".add_category_btn").prop('disabled', false)
                    $(".add_category_btn > .process_indicator").addClass('off');
                    new PNotify({
                        title: 'Success!',
                        text: 'Category created.',
                        addclass: 'custom_notification',
                        type: 'success'
                    });
                    $("select[name='category_id']").prop('disabled', true);
                    $.get("{!! route('load_categories') !!}")
                        .done(function(data) {
                            $("select[name='category_id']").empty();
                            $("select[name='category_id']").prop('disabled', false);
                            $.each(data, function (key, value) {
                                $("select[name='category_id']").append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        })
                }).fail(function (response) {
                    $(".add_category_btn").prop('disabled', false)
                    $(".add_category_btn > .process_indicator").addClass('off');
                    if (response.status == 500) {
                        new PNotify({
                            title: 'Oops!',
                            text: 'An Error Occurred. Please try again.',
                            addclass: 'custom_notification',
                            type: 'error'
                        });
                    }
                    if (response.status == 400) {
                        $.each(response.responseJSON.message, function (key, item) {
                            $("input[name="+key+"] + span.errorshow").html(item[0])
                            $("input[name="+key+"] + span.errorshow").slideDown("slow")
                        });
                        new PNotify({
                            title: 'Oops!',
                            text: 'Form validation error.',
                            type: 'error'
                        });
                    }
                    else {
                        new PNotify({
                            title: 'Oops!',
                            text: 'An Error Occurred. Please try again.',
                            type: 'error'
                        });
                    }
                })
            });

            $("form#sub_category_form").on('submit', function (e) {
                e.preventDefault();
                $(".add_sub_category_btn").prop('disabled', true)
                $(".add_sub_category_btn > .process_indicator").removeClass('off');
                $("span.errorshow").html("")
                $.ajax({
                    type: "POST",
                    url: "{!! route('create_sub_category') !!}",
                    data: $(this).serialize()
                }).done(function (data) {
                    $(".add_sub_category_btn").prop('disabled', false)
                    $(".add_sub_category_btn > .process_indicator").addClass('off');
                    new PNotify({
                        title: 'Success!',
                        text: 'Sub category created.',
                        addclass: 'custom_notification',
                        type: 'success'
                    });
                    location.reload()
                }).fail(function (response) {
                    $(".add_sub_category_btn").prop('disabled', false)
                    $(".add_sub_category_btn > .process_indicator").addClass('off');
                    if (response.status == 500) {
                        new PNotify({
                            title: 'Oops!',
                            text: 'An Error Occurred. Please try again.',
                            addclass: 'custom_notification',
                            type: 'error'
                        });
                    }
                    if (response.status == 400) {
                        $.each(response.responseJSON.message, function (key, item) {
                            $("input[name="+key+"] + span.errorshow").html(item[0])
                            $("input[name="+key+"] + span.errorshow").slideDown("slow")
                        });
                        new PNotify({
                            title: 'Oops!',
                            text: 'Form validation error.',
                            type: 'error'
                        });
                    }
                    else {
                        new PNotify({
                            title: 'Oops!',
                            text: 'An Error Occurred. Please try again.',
                            type: 'error'
                        });
                    }
                })
            });


            $(".delete_subcategory").on('click', function () {
                destroyTaxon($(this).attr('id'))
            });

            $(".delete_category").on('click', function () {
                destroyTaxonomy($(this).attr('id'))
            });

            $(".edit_subcategory").on('click', function () {
                editTaxon($(this).attr('id'), $(this).data('category_id'))
            });

            $(".edit_category").on('click', function () {
                editTaxonomy($(this).attr('id'))
            });

            $(".add_child_category").on('click', function () {
                var parent_category_details = $(this).data('taxonomy_name') + '-' + $(this).data('taxon_name');
                taxonomy_id = $(this).data('taxonomy_id');
                taxon_id = $(this).data('taxon_id');
                $('#parent_category_details').html(parent_category_details)
                $('#child_category_modal').modal('show')
            });

            $(".edit_subcategory_image").on('click', function () {
            $(this).prev().click();
            });

            // Upload Action
            $(document).on('change', '.upload_cat_image', function (event) {

                var uploaded_file = $(this).prop('files')[0];
                var category_id = $(this).data('category_id');
                var form_data = new FormData();

                form_data.append('uploaded_file', uploaded_file);
                form_data.append('category_id', category_id);

                $.blockUI({message: '<h5>Uploading...</h5>'});
                $.ajax({
                    url: "{!! route('upload_category_image') !!}",
                    data: form_data,
                    type: 'POST',
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                })
                    .done(function (data) {
                        $.unblockUI();

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

                    new PNotify({
                        title: 'Oops!',
                        text: 'An Error Occurred. Please try again.',
                        addclass: 'custom_notification',
                        type: 'error'
                    });
                });

            });

            $("#save_child_category").on('click', function () {
                $("#save_child_category").prop('disabled', true)
                $("#save_child_category > .process_indicator").removeClass('off');
                var input = $("input[name='child_category_input']").val()
                $.ajax({
                    type: "POST",
                    url: "{!! route('create_child_category') !!}",
                    data: {
                        taxonomy_id: taxonomy_id,
                        taxon_id: taxon_id,
                        input: input,
                    }
                }).done(function (data) {
                    $("#save_child_category").prop('disabled', false)
                    $("#save_child_category > .process_indicator").addClass('off');
                    new PNotify({
                        title: 'Success!',
                        text: 'Child Category created.',
                        addclass: 'custom_notification',
                        type: 'success'
                    });
                    location.reload()
                }).fail(function (response) {
                    $("#save_child_category").prop('disabled', false)
                    $("#save_child_category > .process_indicator").addClass('off');
                    if (response.responseJSON.status == 500) {
                        new PNotify({
                            title: 'Oops!',
                            text: 'An Error Occurred. Please try again.',
                            addclass: 'custom_notification',
                            type: 'error'
                        });
                    }
                    if (response.status == 400) {
                        new PNotify({
                            title: 'Oops!',
                            text: response.responseJSON.message,
                            type: 'error'
                        });
                    }
                    else {
                        new PNotify({
                            title: 'Oops!',
                            text: 'An Error Occurred. Please try again.',
                            type: 'error'
                        });
                    }
                })
            })

            $("#cancel_save_child_category").on('click', function () {
                $("#save_child_category").prop('disabled', false)
                $("#save_child_category > .process_indicator").addClass('off');
            });
        });

        function destroyTaxon (id) {
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
                        click: function(notice) {
                            $.ajax({
                                type: "GET",
                                url: "{!! route('destroy_subcategory') !!}"+"/"+id
                            }).done(function (data) {
                                notice.update({
                                    title: 'Deleted',
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
                                location.reload()
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
                            click: function(notice) {
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
        function destroyTaxonomy (id) {
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
                        click: function(notice) {
                            $.ajax({
                                type: "GET",
                                url: "{!! route('destroy_category') !!}"+"/"+id
                            }).done(function (data) {
                                notice.update({
                                    title: 'Deleted',
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
                                location.reload()
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
                            click: function(notice) {
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
        function editTaxon (id, category_id) {

            (new PNotify({
                title: 'Edit Subcategory',
                text: 'You are about a subcategory!',
                icon: 'glyphicon glyphicon-plus-sign',
                addclass: 'custom_notification',
                hide: false,
                confirm: {
                    prompt: true
                },
                buttons: {
                    closer: false,
                    sticker: false
                },
                history: {
                    history: false
                }

            })).get().on('pnotify.confirm', function (e, notice, val) {
                $.ajax({
                    type: "POST",
                    data: {value:val, id: id, category_id: category_id},
                    url: "{!! route('edit_subcategory') !!}",
                }).done(function (data) {
                    new PNotify({
                        title: 'Updated',
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
                    location.reload();
                }).fail(function (response) {
                    PNotify.removeAll();
                    if (response.status == 500) {
                        new PNotify({
                            title: 'Oops!',
                            text: 'Failed to update. Please try again.',
                            type: 'error'
                        });
                        return false
                    }
                    if (response.status == 400) {
                        new PNotify({
                            title: 'Oops!',
                            text: 'Failed to update. Please try again.',
                            type: 'error'
                        });
                        return false
                    }
                    else {
                        new PNotify({
                            title: 'Oops!',
                            text: 'Failed to update. Please try again.',
                            type: 'error'
                        });
                        return false
                    }
                })

            }).on('pnotify.cancel', function (e, notice) {
                notice.cancelRemove().update({
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
            });

        }
        function editTaxonomy (id) {
            (new PNotify({
                title: 'Edit Category',
                text: 'You are about a category!',
                icon: 'glyphicon glyphicon-plus-sign',
                addclass: 'custom_notification',
                hide: false,
                confirm: {
                    prompt: true
                },
                buttons: {
                    closer: false,
                    sticker: false
                },
                history: {
                    history: false
                }

            })).get().on('pnotify.confirm', function (e, notice, val) {
                $.ajax({
                    type: "POST",
                    data: {value:val, id: id},
                    url: "{!! route('edit_category') !!}",
                }).done(function (data) {
                    new PNotify({
                        title: 'Updated',
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
                    location.reload();
                }).fail(function (response) {
                    superagentstable.ajax.reload();
                    PNotify.removeAll();
                    if (response.status == 500) {
                        new PNotify({
                            title: 'Oops!',
                            text: 'Failed to update. Please try again.',
                            type: 'error'
                        });
                        return false
                    }
                    if (response.status == 400) {
                        new PNotify({
                            title: 'Oops!',
                            text: 'Failed to update. Please try again.',
                            type: 'error'
                        });
                        return false
                    }
                    else {
                        new PNotify({
                            title: 'Oops!',
                            text: 'Failed to update. Please try again.',
                            type: 'error'
                        });
                        return false
                    }
                })

            }).on('pnotify.cancel', function (e, notice) {
                notice.cancelRemove().update({
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
            });

        }

    </script>
    @endpush