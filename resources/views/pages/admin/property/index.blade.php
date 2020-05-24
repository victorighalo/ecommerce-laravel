@extends('layouts.admin')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row justify-content-center flex-grow mb-5 mt-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body product_properties_container">
                            <h4 class="card-title">Product Properties</h4>
                                <div class="row">
                                        <div class="col-sm-6 p-2">
                                            @include('pages.admin.property._create_property')
                                        </div>
                                    <div class="col-sm-12 p-2">
                                        <div class="card" id="product_properties">

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
            $("form#property_form").on('submit', function (e) {
                e.preventDefault();
                $(".add_category_btn").prop('disabled', true)
                $(".add_category_btn > .process_indicator").removeClass('off');
                $("span.errorshow").html("")
                $.ajax({
                    type: "POST",
                    url: "{!! route('create_property') !!}",
                    data: $(this).serialize()
                }).done(function (data) {
                    $(".add_property_btn").prop('disabled', false)
                    $(".add_property_btn > .process_indicator").addClass('off');
                    new PNotify({
                        title: 'Success!',
                        text: 'Property created.',
                        addclass: 'custom_notification',
                        type: 'success'
                    });
                    $("select[name='property_slug']").prop('disabled', true);
                    location.reload()
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

        });




    </script>
@endpush
