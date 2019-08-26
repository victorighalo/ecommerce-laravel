@extends('layouts.admin')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            @include('partials.dashboard.stat')
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Transactions</h5>
                            <div class="table-responsive">
                            <table class="table table-bordered" id="users-table">
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
            $.when(
                $.post( "{{route('get_store_stats') }}")
            ).then(function (res) {
                $("#total_products_stat").prev().addClass("off");
                $("#total_products_stat").html(res.total_products)

                $("#total_sales").prev().addClass("off");
                $("#total_sales").html(res.total_transactions)
            })
        })

    </script>
    @endpush
