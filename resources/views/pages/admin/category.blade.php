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
                                                    <label for="category_id">{{ __('Category name') }}</label>
                                                <select class="form-control" name="category_id" id="category_id">
                                                    @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                        @endforeach
                                                </select>
                                                <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                                </div>

                                            <div class="row form-group">
                                                    <label for="sub_category">{{ __('Sub category name') }}</label>
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
                            <h5 class="card-title mb-4">Categories</h5>
                            <div class="table-responsive">
                                <table class="table table-striped " id="categories-table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Slug</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>
                                                {{$category->name}}
                                            </td>
                                            <td>
                                                {{$category->slug}}
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
                        text: 'Category created.',
                        addclass: 'custom_notification',
                        type: 'success'
                    });
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