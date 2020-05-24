export const updatePropertyTitle  = (id,defaultValue,refresh)=> {
    (new PNotify({
        title: 'Edit property title',
        text: 'You are about a property title!',
        icon: 'glyphicon glyphicon-edit-sign',
        addclass: 'custom_notification',
        hide: false,
        confirm: {
            prompt: true,
            prompt_default:defaultValue,
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
            url: "/office/properties/updatetitle",
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
             refresh()
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

export function updatePropertyValue (id,defaultValue,refresh) {
    (new PNotify({
        title: 'Edit property value',
        text: 'You are about a property value!',
        icon: 'glyphicon glyphicon-plus-sign',
        addclass: 'custom_notification',
        hide: false,
        confirm: {
            prompt: true,
            prompt_default:defaultValue,
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
            url: "/office/properties/updatevalue",
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
            refresh()
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

export function updateProperty (id,defaultValue,refresh) {

    (new PNotify({
        title: 'Edit property',
        text: 'You are about a property!',
        icon: 'glyphicon glyphicon-plus-sign',
        addclass: 'custom_notification',
        hide: false,
        confirm: {
            prompt: true,
            prompt_default:defaultValue,
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
            url: "/office/properties/update",
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
            refresh()
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

export function destroyProperty (id,defaultValue,refresh) {
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
                        type: "DELETE",
                        url: "/office/properties/destroy/"+id
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
                        refresh()
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

export function destroyPropertyValue (id,defaultValue,refresh) {
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
                        type: "DELETE",
                        url: "/office/properties/value/destroy/"+id
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
                        refresh()
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
