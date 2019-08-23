@extends('layouts.admin')
@section('content')
    @include('partials.image-modal')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row justify-content-center flex-grow mb-5 mt-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <span uk-icon="settings"></span> Settings
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general">
                                        <span uk-icon="user"></span> General
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="slider-tab" data-toggle="tab" href="#slider">
                                        <span uk-icon="image"></span> Slider
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" role="tabpanel" id="general" role="tabpanel">
                                @include('pages.admin.settings.general')
                            </div>
                            <div class="tab-pane fade" role="tabpanel" id="slider" role="tabpanel">
                            @include('pages.admin.settings.slider')
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
    <script>
        var selected_category_id;
        $(".edit_slider_image").on('click', function () {
        $("input[class='upload_image']").trigger('click');
        selected_category_id = $(this).attr('id')
        });

        // Upload Action
        $(document).on('input', 'input:file', function (event) {

            var uploaded_file = $(this).prop('files')[0];
            var form_data = new FormData();

            form_data.append('uploaded_file', uploaded_file);
            form_data.append('category_id', selected_category_id);

            $.blockUI({message: '<h5>Uploading...</h5>'});
            $.ajax({
                url: "{!! route('upload_slider_image') !!}",
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
                        setTimeout(function () {
                            location.reload();
                        }, 2000)
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
    </script>
@endpush
