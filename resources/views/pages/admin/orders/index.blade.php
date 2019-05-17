@extends('layouts.admin')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Orders</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                        <th>State</th>
                                        <th>City</th>
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
    <script>
        $(document).ready(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('orders_data') !!}',
                columns: [
                    {data: 'created_at', name: 'date'},
                    {data: 'amount', name: 'amount'},
                    {data: 'firstname', name: 'Firstname'},
                    {data: 'lastname', name: 'Lastname'},
                    {data: 'state_name', name: 'State'},
                    {data: 'city_name', name: 'City'},
                    {data: 'action', name: 'Action', oderable:false},
                ]
            });
        })

    </script>
@endpush
