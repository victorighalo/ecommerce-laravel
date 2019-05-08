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
                                        <th>Name</th>
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
                    {data: 'name', name: 'name'},
                ]
            });
        })

    </script>
@endpush
