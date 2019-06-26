@extends('layouts.admin')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            @include('pages.admin.users._edit_modal')
            @include('pages.admin.users._password_edit_modal')
            @include('pages.admin.users._create_user')
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Users</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table">
                                    <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Active</th>
                                        <th>Role</th>
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
  @include('pages.admin.users.script')
@endpush
