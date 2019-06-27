<script>
    var table = null;
    $(document).ready(function () {
        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('get_users') !!}',
                data: {'type': 1},
                type: "POST",
            },
            columns: [
                {data: 'firstname', name: 'firstname'},
                {data: 'lastname', name: 'lastname'},
                {data: 'email', name: 'email'},
                {data: 'is_active', name: 'is_active'},
                {data: 'role', name: 'role'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                // { data: 'image', name: 'image' },
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        //Create user
        $("form#user_form").on('submit', function (e) {
            e.preventDefault();
            $(".add_user_btn").prop('disabled', true)
            $(".add_user_btn > .process_indicator").removeClass('off');
            $.ajax({
                type: "POST",
                url: "{!! route('users.store') !!}",
                data:  $(this).serializeArray(),
            }).done(function (data) {
                $(".add_user_btn").prop('disabled', false)
                $(".add_user_btn > .process_indicator").addClass('off');
                new PNotify({
                    title: 'Success!',
                    text: 'User created.',
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
        
        $("#toggle_password").on('click', function () {
            var input = $("form[id='update_user_password']").find("input[name='password']");
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        })
    })

    function changepassword(id) {
        $("#edit_password_modal").modal('show');
        $("form[id='edit_password_modal']").find("input[name='user_id']").val(id)
    }

    function edit(id) {
        $("#edit_modal").modal('show');
        $(".loader_container").show();
        $("form[id='update_user']").find("input[name='user_id']").val(id)
        $.ajax({
            type: "GET",
            url: "{!! url('office/users/edit') !!}/"+id,
        }).done(function (data) {
            $(".loader_container").hide();
            $("form[id='update_user']").find("input[name='firstname']").val(data.data.user.firstname).html(data.data.user.firstname)
            $("form[id='update_user']").find("input[name='lastname']").val(data.data.user.lastname).html(data.data.user.lastname)
            // $("form[id='update_user']").find("input[name='email']").val(data.data.user.email).html(data.data.user.email)
            var options = "";
            $.each(data.data.roles, function (index, item) {
                if(item.name == data.data.role){
                    options += "<option value="+item.name+" selected>"+item.name+"</option>" ;
                }else{
                    options += "<option value="+item.name+">"+item.name+"</option>" ;
                }

            });

            $("form[id='update_user']").find("select[name='role']").empty();
            $("form[id='update_user']").find("select[name='role']").append(options);

        }).fail(function (response) {
            $(".loader_container").hide();
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
                    text: 'Failed to load user data.',
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

    function deactivate (id) {
        PNotify.removeAll();

        new PNotify({
            title: 'Confirm Deactivation',
            text: 'Are you sure?',
            icon: 'glyphicon glyphicon-question-sign',
            hide: false,
            confirm: {
                confirm: true,
                buttons: [{
                    text: 'Deactivate',
                    addClass: 'btn-primary',
                    click: function(notice) {
                        $.ajax({
                            type: "PUT",
                            url: "{!! url('office/users/deactivate') !!}/"+id,
                        }).done(function (data) {
                            notice.update({
                                title: 'User banned',
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
                            table.ajax.reload();
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
                                    text: 'Failed to deactivate User.',
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
        })
    };

    function activate (id) {
        (new PNotify({
            title: 'Confirm Activation',
            text: 'Are you sure?',
            icon: 'glyphicon glyphicon-question-sign',
            hide: false,
            confirm: {
                confirm: true,
                buttons: [{
                    text: 'Activate',
                    addClass: 'btn-primary',
                    click: function(notice) {
                        $.ajax({
                            type: "PUT",
                            url: "{!! url('office/users/activate') !!}/"+id,
                        }).done(function (data) {
                            table.ajax.reload();
                            notice.update({
                                title: 'User Activated',
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
                        }).fail(function (response) {
                            superagentstable.ajax.reload();
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
                                    text: 'Failed to activate User.',
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
                            type: "PUT",
                            url: '{!! url('office/users/destroy') !!}/'+id,
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