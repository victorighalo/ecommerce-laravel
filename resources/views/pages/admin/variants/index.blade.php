@extends('layouts.admin')

@push('style')

    @endpush
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row justify-content-center flex-grow mb-5 mt-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">  Create variants
                                <a class="btn btn-link float-right" data-toggle="collapse" href="#form_collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a></h4>
                            <div class="" id="form_collapse">
                                <div class="row">
                                    <div class="col-sm-12 p-4">
                                        @include('pages.admin.variants._create_variant')
                                    </div>
                                    <div class="col-sm-12 p-2">
                                        @include('pages.admin.variants._view_variants')
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
    <script src="{{asset('js/angular.min.js')}}"></script>
    <script src="{{asset('js/angular-resource.min.js')}}"></script>
    <script>
        var app = angular.module('create-properties', ['ngResource']);
        app.controller('propertiesController', function propertiesController($scope, $http) {
            $scope.properties = [];
            var getProperties = function () {
                $http.get('{!! url("office/variants.json") !!}')
                    .then(function (res) {
                        $scope.properties = res.data.data;
                    })
            }
            getProperties();

            var deleteItem = function(item) {
                var id  = item.value.id;
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
                                    url: "{!! route('destroy_variant_value') !!}"+"/"+id
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
                                    getProperties();
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
                                            text: 'Failed to delete Property.',
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

            var editItem = function (item) {

                var id  = item.value.id;

                (new PNotify({
                    title: 'Edit property value',
                    text: 'Enter the new value to edit!',
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
                        url: "{!! route('update_variant_value') !!}",
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
                        getProperties()
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

            $scope.deleteItem = deleteItem;
            $scope.editItem = editItem;
        });

        $(document).ready(function () {
            $("form#property_form").on('submit', function (e) {
                e.preventDefault();
                $(".add_category_btn").prop('disabled', true)
                $(".add_category_btn > .process_indicator").removeClass('off');
                $("span.errorshow").html("")
                $.ajax({
                    type: "POST",
                    url: "{!! route('create_variant') !!}",
                    data: $(this).serialize()
                }).done(function (data) {
                    $(".add_property_btn").prop('disabled', false)
                    $(".add_property_btn > .process_indicator").addClass('off');
                    new PNotify({
                        title: 'Success!',
                        text: 'Variant created.',
                        addclass: 'custom_notification',
                        type: 'success'
                    });
                    $("select[name='property_slug']").prop('disabled', true);
                    $.get("{!! route('load_properties') !!}")
                        .done(function(data) {
                            $("select[name='property_slug']").empty();
                            $("select[name='property_slug']").prop('disabled', false);
                            $.each(data, function (key, value) {
                                $("select[name='property_slug']").append('<option value="' + value.slug + '">' + value.name + '</option>');
                            });
                        })
                }).fail(function (response) {
                    $(".add_property_btn").prop('disabled', false)
                    $(".add_property_btn > .process_indicator").addClass('off');
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

            $("form#property_value_form").on('submit', function (e) {
                e.preventDefault();
                $(".add_property_value_btn").prop('disabled', true)
                $(".add_property_value_btn > .process_indicator").removeClass('off');
                $("span.errorshow").html("")
                $.ajax({
                    type: "POST",
                    url: "{!! route('create_variants_value') !!}",
                    data: $(this).serialize()
                }).done(function (data) {
                    $(".add_sub_category_btn").prop('disabled', false)
                    $(".add_sub_category_btn > .process_indicator").addClass('off');
                    new PNotify({
                        title: 'Success!',
                        text: 'Property value created.',
                        addclass: 'custom_notification',
                        type: 'success'
                    });
                    location.reload()
                }).fail(function (response) {
                    $(".add_property_value_btn").prop('disabled', false)
                    $(".add_property_value_btn > .process_indicator").addClass('off');
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

            $(".delete_property_value").on('click', function () {
                destroyPropertyValue($(this).attr('id'))
            });

            $(".delete_property").on('click', function () {
                destroyProperty($(this).attr('id'))
            });


            $(".edit_property_title").on('click', function () {
                editPropertyTitle($(this).attr('id'))
            });

            $(".edit_property").on('click', function () {
                editProperty($(this).attr('id'))
            });
        });

        function destroyProperty (id) {
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
                                url: "{!! route('destroy_property') !!}"+"/"+id
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
                                        text: 'Failed to delete Property value.',
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
        function destroyPropertyValue (id) {
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
                                url: "{!! route('destroy_property_value') !!}"+"/"+id
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
                                        text: 'Failed to delete Property.',
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
        function editProperty (item) {


            (new PNotify({
                title: 'Edit property',
                text: 'You are about a property!',
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
                    url: "{!! route('update_property') !!}",
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
        function editPropertyValue (item) {
            var id  = $(item).data('property_id');

            (new PNotify({
                title: 'Edit property value',
                text: 'Enter the new value to edit!',
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
                    url: "{!! route('update_variant_value') !!}",
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
                    getProperties()
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
        function editPropertyTitle (id) {
            (new PNotify({
                title: 'Edit property title',
                text: 'You are about a property title!',
                icon: 'glyphicon glyphicon-edit-sign',
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
                    url: "{!! route('update_property_title') !!}",
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

    </script>
@endpush
