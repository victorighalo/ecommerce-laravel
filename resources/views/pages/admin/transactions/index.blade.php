@extends('layouts.admin')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Transactions</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table">
                                    <thead>
                                    <tr>
                                        <th>Created At</th>
                                        <th>Order ID</th>
                                        <th>Ref ID</th>
                                        <th>Cost</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>

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
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [
                { extend: 'excel', className: 'btn btn-sm btn-primary' }
            ],
            ajax: '{!! route('transactions_json') !!}',
            columns: [
                {data: 'created_at', name: 'created_at'},
                {data: 'order_id', name: 'order_id'},
                {data: 'reference', name: 'reference'},
                {data: 'amount', name: 'amount'},
                {data: 'firstname', name: 'firstname'},
                {data: 'lastname', name: 'lastname'},
                {data: 'user_email', name: 'user_email'},
                {data: 'status', name: 'status'},
                // { data: 'image', name: 'image' },
                // {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

    </script>
@endpush
