<div class="container">
        <input type="file" placeholder="Upload image" style="visibility: hidden;" class="upload_image" >
            <div class="row">
                @foreach($sliders as $slider)
                <div class="col-sm-12 card-header">
                <span>{{$slider->name}}</span>
                    @if($slider->status == 0)
                    <button class="btn btn-danger toggle_slider float-right ml-3" data-status="1" id="{{$slider->id}}">
                            <span>Turn On</span>
                    </button>
                            @else
                        <button class="btn btn-success toggle_slider float-right ml-3" data-status="0" id="{{$slider->id}}">
                        <span>Turn Off</span>
                        </button>
                            @endif

                    <button class="btn btn-primary edit_slider_image float-right" id="1">Add Image</button>
                </div>
                    @if($slider->photos)
                        @foreach($slider->photos as $image)
                <div class="col-sm-2 p-3">
                    <div class="card p-3 text-center" uk-lightbox="animation: fade" id="js-lightbox-animation">
                    <a href="{{asset($image->LocalImageUrl)}}">
                    <img class="img-responsive card-img-top p-3" src="{{asset($image->LocalThumbImageUrl)}}" style="width: 100px; height: 100px" alt="">
                    </a>
                    <div class="text-center">
                        <div class="btn-group" role="group" aria-label="...">
                            <a href="{{asset($image->LocalThumbImageUrl)}}" class="btn btn-primary">View</a>
                            <button class="btn btn-danger delete_slider_image" onclick="removeMedia(this)" id="{{$image->id}}">Delete</button>
                        </div>
                    </div>
                    </div>
                </div>
                @endforeach
                @endif
                    @endforeach
        </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        UIkit.lightbox('#js-lightbox-animation');

        $(document).ready(function () {
            $(".toggle_slider").on('click', function () {

                $.ajax({
                    url: "{!! url('office/slider/update') !!}/"+$(this).attr('id')+"/"+$(this).data('status'),
                    method:"POST"
                })
                    .done(function () {
                        new PNotify({
                            title: 'Success!',
                            text: 'Slider Updated.',
                            type: 'success'
                        });
                        location.reload()
                    })
                    .fail(function () {
                        new PNotify({
                            title: 'Oops!',
                            text: 'Failed to update Slider.',
                            type: 'error'
                        });
                    })
            })
        })
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
                                url: "{{route('photo_remove')}}",
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
                                item.parent().parent().parent().fadeOut();
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
