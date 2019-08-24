@extends('layouts.admin')
@section('content')

    <!-- Modal -->
    <div class="modal fade" id="products_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="products_modal">Order Products</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Orders</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $item)
                                        <tr>
                                            <td>{{$item->order_id}}</td>
                                            <td>{{$item->created_at}}</td>
                                            <td>&#8358;{{number_format($item->price, 0, '.', ',')}} </td>
                                            <td>{{$item->firstname}}</td>
                                            <td>{{$item->lastname}}</td>
                                            <td>{{$item->state_name}}</td>
                                            <td>{{$item->city_name}}</td>
                                            <td>{{$item->address}}</td>
                                            <td>{{$item->status}}</td>
                                            <td><button class='btn btn-md btn-link view_products' data-order_id="{{$item->order_id}}">Products</button></td>
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
        $(document).ajaxStop($.unblockUI);
        $(document).ready(function () {

            {{--var table = $('#table').DataTable({--}}
            {{--    processing: true,--}}
            {{--    serverSide: true,--}}
            {{--    ajax: '{!! route('orders_data') !!}',--}}
            {{--    columns: [--}}
            {{--        {data: 'created_at', name: 'created_at'},--}}
            {{--        {data: 'amount', name: 'amount'},--}}
            {{--        {data: 'firstname', name: 'Firstname'},--}}
            {{--        {data: 'lastname', name: 'Lastname'},--}}
            {{--        {data: 'state_name', name: 'State'},--}}
            {{--        {data: 'city_name', name: 'City'},--}}
            {{--        {data: 'address', name: 'address'},--}}
            {{--        {data: 'status', name: 'status'},--}}
            {{--        {data: 'action', name: 'Action', oderable:false},--}}
            {{--    ]--}}
            {{--});--}}

            $("#table").on('click', '.view_products', function () {
                $.blockUI();
                var order_id = $(this).data('order_id');
                $.ajax({
                    url: "{!! route('order_products') !!}",
                    method: 'POST',
                    data: {order_id: order_id},
                }).done( function(data){

                    var tr = "<tr>";
                    $.each(data.data, function(index, item){
                    var price = new Intl.NumberFormat().format(item.price)
                    tr += "<td>"+item.name+"</td>";
                    tr += "<td>&#8358;"+price+"</td>";
                    tr += "</tr>";
                    });

                    $(".modal-body tbody").empty().append(tr)
                    $('#products_modal').modal('show');


                    $('#products_modal').on('shown.bs.modal', function () {
                        $('#products_modal').focus()
                    });

                }).fail( function (error) {

                })

            })
        })

    </script>
@endpush
