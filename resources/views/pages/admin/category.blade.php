@extends('layouts.admin')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row justify-content-center flex-grow mb-5 mt-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">  Create categories
                                <a class="btn btn-link float-right" data-toggle="collapse" href="#form_collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a></h4>
                            <div class="" id="form_collapse">
                                <div class="row">
                                <div class="col-sm-6 p-4">
                                <form id="category_form">
                                    @csrf
                                    <div class="row form-group">
                                            <label for="name">{{ __('Category name') }}</label>
                                            <input type="text" id="name" class="form-control" name="name" required>
                                        <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                        <button class="btn custom_button_color btn-warning btn-lg font-weight-medium add_category_btn mt-2" type="submit">
                                            <i class="fas fa-spinner fa-spin off process_indicator"></i>
                                            <span>{{ __('Create') }}</span>
                                        </button>
                                        </div>
                                </form>


                                    <form id="sub_category_form">
                                        @csrf
                                        <div class="row form-group">
                                            <label for="category_id">{{ __('Categories') }}</label>
                                            <select class="form-control" name="category_id" id="category_id">
                                                @foreach($categories as $category)
                                                    <option value="{{$category->taxonomy_id}}">{{$category->taxonomy_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                        </div>

                                        <div class="row form-group">
                                            <label for="sub_category">{{ __('Sub category') }}</label>
                                            <input type="text" id="sub_category" class="form-control" name="sub_category"  required>
                                            <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                        </div>
                                        <div class="mt-1">
                                            <button class="btn float-right custom_button_color btn-warning btn-lg font-weight-medium add_sub_category_btn" type="submit">
                                                <i class="fas fa-spinner fa-spin off process_indicator"></i>
                                                <span>{{ __('Create') }}</span>
                                            </button>
                                        </div>
                                    </form>
                            </div>

                                    <div class="col-sm-6 p-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title mb-4">Categories</h5>
                                                <div class="table-responsive">
                                                    <table class="table table-hover " id="categories-table">
                                                        <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Sub categories</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($categories as $category)
                                                            <tr>
                                                                <td>
                                                                    {{$category->taxonomy_name}}
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        @foreach($category->taxons as $subcategory)
                                                                        <div class="col-12 pb-1">
                                                                            <span>{{$subcategory['name']}} </span>
                                                                            <a class="btn btn-sm btn-link delete_subcategory" id="{{$subcategory['id']}}"><i class="fas fa-trash"></i></a>
                                                                            <a class="btn btn-sm btn-link edit_subcategory" id="{{$subcategory['id']}}"><i class="fas fa-edit"></i></a>
                                                                        </div>

                                                                            @endforeach
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-sm btn-link delete_category" id="{{$category->taxonomy_id}}"><i class="fas fa-trash"></i></a>
                                                                    <a class="btn btn-sm btn-link edit_category" id="{{$category->taxonomy_id}}"><i class="fas fa-edit"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

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
                editTaxon($(this).attr('id'))
            });

            $(".edit_category").on('click', function () {
                editTaxonomy($(this).attr('id'))
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
        function editTaxon (id) {
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
                    data: {value:val, id: id},
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