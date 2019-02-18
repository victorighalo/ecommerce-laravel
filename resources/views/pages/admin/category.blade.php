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
                            <div class="collapse" id="form_collapse">
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
                            </div>

                                    <div class="col-sm-6 p-4">
                                        <form id="sub_category_form">
                                            @csrf
                                            <div class="row form-group">
                                                    <label for="name">{{ __('Category name') }}</label>
                                                    <input type="text" id="name" class="form-control" name="name" required>
                                                <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                                </div>

                                            <div class="row form-group">
                                                    <label for="sub-category">{{ __('Sub-category') }}</label>
                                                    <input type="text" id="sub-category" class="form-control" name="sub-category"  required>
                                                <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                            </div>
                                            <div class="mt-1">
                                                <button class="btn float-right custom_button_color btn-warning btn-lg font-weight-medium submitformbtn" type="submit">
                                                    <i class="fas fa-spinner fa-spin off process_indicator"></i>
                                                    <span>{{ __('Create') }}</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Agents</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="users-table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Active</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Setting</th>
                                    </tr>
                                    </thead>
                                </table>
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
                    superagentstable.ajax.reload();
                    $(".add_category_btn").prop('disabled', false)
                    $(".add_category_btn > .process_indicator").addClass('off');
                    new PNotify({
                        title: 'Success!',
                        text: 'Category created.',
                        addclass: 'custom_notification',
                        type: 'success'
                    });
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

            $("select[name='state']").on('change', function () {
                stateid = $(this).val();
                $("select[name='city']").empty();
                $("select[name='city']").append('<option>Loading...</option>');
                $("select[name='city']").prop('disabled', true);
                $.get(baseurl+"common/load_cites/"+stateid)
                    .done(function(data) {
                        $("select[name='city']").empty();
                        $("select[name='city']").prop('disabled', false);
                        $.each(data, function (key, value) {
                            $("select[name='city']").append('<option value="' + value.local_id + '">' + value.local_name + '</option>');
                        });
                    })
            });


        });
    </script>
    @endpush