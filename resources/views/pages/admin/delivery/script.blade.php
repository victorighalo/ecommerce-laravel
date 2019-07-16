<script>
    var table = null;
    $(document).ready(function () {
        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('delivery_data') !!}',
                data: {'type': 1},
                type: "GET",
            },
            columns: [
                {data: 'state_name', name: 'state_name'},
                {data: 'city_name', name: 'city_name'},
                {data: 'cost', name: 'cost'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        //Create user
        $("form#delivery_form").on('submit', function (e) {
            e.preventDefault();
            $(".add_user_btn").prop('disabled', true)
            $(".add_user_btn > .process_indicator").removeClass('off');
            $.ajax({
                type: "POST",
                url: "{!! route('delivery.store') !!}",
                data:  $(this).serializeArray(),
            }).done(function (data) {
                $(".add_user_btn").prop('disabled', false)
                $(".add_user_btn > .process_indicator").addClass('off');
                new PNotify({
                    title: 'Success!',
                    text: 'Delivery cost added.',
                    addclass: 'custom_notification',
                    type: 'success'
                });
                table.ajax.reload();
            }).fail(function (response) {

                $(".add_user_btn").prop('disabled', false)
                $(".add_user_btn > .process_indicator").addClass('off');
                if (response.status == 500) {
                    new PNotify({
                        title: 'Oops!',
                        text: 'An Error Occurred. Please try again.',
                        addclass: 'custom_notification',
                        type: 'error'
                    });
                }
                if (response.status == 422) {
                    $.each(response.responseJSON.errors, function (key, item) {
                        $("input[name=" + key + "] + span.errorshow").html(item[0])
                        $("input[name=" + key + "] + span.errorshow").slideDown("slow")
                        $("select[name=" + key + "] + span.errorshow").html(item[0])
                        $("select[name=" + key + "] + span.errorshow").slideDown("slow")
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

        $("form#update_user").on('submit', function (e) {
            e.preventDefault();
            disableItem($(".updateformbtn"), true)
            $(".updateformbtn > .process_indicator").removeClass('off');
            $("span.errorshow").html("")
            $.ajax({
                type: "PUT",
                url: "{!! route('update_user') !!}",
                data: $(this).serializeArray()
            }).done(function (data) {
                table.ajax.reload();
                disableItem($(".updateformbtn"), false)
                $(".updateformbtn > .process_indicator").addClass('off');
                new PNotify({
                    title: 'Success!',
                    text: 'User data updated.',
                    type: 'success'
                });
            }).fail(function (response) {
                disableItem($(".updateformbtn"), false)
                $(".updateformbtn > .process_indicator").addClass('off');
                if (response.status == 500) {
                    new PNotify({
                        title: 'Oops!',
                        text: 'An Error Occurred. Please try again.',
                        type: 'error'
                    });
                    return false
                }
                if (response.status == 422) {
                    $.each(response.responseJSON.errors, function (key, item) {
                        $("input[name=" + key + "] + span.errorshow").html(item[0])
                        $("input[name=" + key + "] + span.errorshow").slideDown("slow")
                        $("select[name=" + key + "] + span.errorshow").html(item[0])
                        $("select[name=" + key + "] + span.errorshow").slideDown("slow")
                    });
                    new PNotify({
                        title: 'Oops!',
                        text: 'Form validation error.',
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
        });

        $("form#update_user_password").on('submit', function (e) {
            e.preventDefault();
            disableItem($(".updateformbtn"), true)
            $(".updateformbtn > .process_indicator").removeClass('off');
            $("span.errorshow").html("")
            $.ajax({
                type: "PUT",
                url: "{!! route('update_user_password') !!}",
                data: $(this).serializeArray()
            }).done(function (data) {
                disableItem($(".updateformbtn"), false)
                $(".updateformbtn > .process_indicator").addClass('off');
                new PNotify({
                    title: 'Success!',
                    text: 'User data updated.',
                    type: 'success'
                });
            }).fail(function (response) {
                disableItem($(".updateformbtn"), false)
                $(".updateformbtn > .process_indicator").addClass('off');
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
                        text: 'Form validation error.',
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
        });


        $("select[name='state_id']").on('change', function () {
            stateid = $(this).val();
            $("select[name='city_id']").empty();
            $("select[name='city_id']").append('<option>Loading...</option>');
            $("select[name='city_id']").prop('disabled', true);
            $.post("{!! url('load_cities') !!}",{id: stateid})
                .done(function(msg) {
                    $("select[name='city_id']").empty();
                    $("select[name='city_id']").prop('disabled', false);
                    $.each(msg, function (key, value) {
                        $("select[name='city_id']").append('<option value="' + value.city_id + '">' + value.city_name + '</option>');
                    });
                })
        });

    })



    function edit (id) {

        (new PNotify({
            title: 'Edit cost',
            text: 'You are about delivery cost!',
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
                url: "{!! route('delivery_update') !!}",
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
                table.ajax.reload();
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

    function destroy (id) {
        (new PNotify({
            title: 'Confirm Delete',
            text: 'Are you sure?',
            icon: 'glyphicon glyphicon-question-sign',
            hide: false,
            confirm: {
                confirm: true,
                buttons: [{
                    text: 'Delete',
                    addClass: 'btn-primary',
                    click: function(notice) {
                        $.ajax({
                            type: "DELETE",
                            url: '{!! url('office/delivery') !!}/'+id,
                            data: $(this).serialize()
                        }).done(function (data) {
                            table.ajax.reload();
                            notice.update({
                                title: 'Sucess',
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
                            }
                            if (response.status == 400) {
                                new PNotify({
                                    title: 'Oops!',
                                    text: 'Failed to delete User.',
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
</script>