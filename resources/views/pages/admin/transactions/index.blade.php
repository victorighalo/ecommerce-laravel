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
                                <table class="table table-bordered">
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
                                    @foreach($data as $item)
                                        <tr>
                                            <td>{{$item->created_at}}</td>
                                            <td>{{$item->order_id}}</td>
                                            <td>{{$item->reference}}</td>
                                            <td>&#8358;{{number_format($item->amount, 0, '.', ',')}} </td>
                                            <td>{{$item->firstname}}</td>
                                            <td>{{$item->lastname}}</td>
                                            <td>{{$item->user_email}}</td>
                                            <td>{{$item->status}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    {{ $data->links() }}
                                    </tfoot>
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


    </script>
@endpush
