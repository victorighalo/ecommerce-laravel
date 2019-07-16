@extends('layouts.admin')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            @include('pages.admin.delivery._create')
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Delivery cost</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table">
                                    <thead>
                                    <tr>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Cost</th>
                                        <th>Action</th>
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
    @include('pages.admin.delivery.script')
@endpush
