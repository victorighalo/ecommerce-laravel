@extends('layouts.admin')
@section('content')

    <!-- Modal -->
    <div class="modal fade" id="products_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="products_modal">Ordered Products</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
{{--                <table class="table table-bordered">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th>Name</th>--}}
{{--                        <th>Price</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}

{{--                    </tbody>--}}
{{--                </table>--}}
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
                                        <th>Phone</th>
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
                                            <td>{{$item->phone}}</td>
                                            <td>{{$item->address}}</td>
                                            <td>{{str_replace("_", " ",$item->status)}}</td>
                                            <td><button class='btn btn-md btn-link view_products'
                                                        data-order_id="{{$item->order_id}}"
                                                        data-state_id="{{$item->state_id}}"
                                                        data-city_id="{{$item->city_id}}"
                                                >Products</button></td>
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
        $(document).ajaxStop($.unblockUI);
        var mediaUrl = "";
        (function setMediaUrl() {
            if (photoDriver == 'local') {
                mediaUrl = "{{asset('')}}"
            }
            else if (photoDriver == 's3') {
                mediaUrl = s3Url;
            }
        })();
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
                var state_id = $(this).data('state_id');
                var city_id = $(this).data('city_id');
                $.ajax({
                    url: "{!! route('order_products') !!}",
                    method: 'POST',
                    data: {
                        order_id: order_id,
                        state_id: state_id,
                        city_id: city_id,
                    },
                }).done( function(data){

                    var rows = "<div class='row'>";
                    $.each(data.data, function(index, item){
                    var price = new Intl.NumberFormat().format(item.price);
                    var delivery_price = new Intl.NumberFormat().format(item.delivery_price);
                    var delivery_price_location = new Intl.NumberFormat().format(item.delivery_price_location);
                    var image = mediaUrl + item.images[0].link;
                        rows += "<div class='col-sm-12' style='background: url("+image+") #f5f5f5; background-repeat: no-repeat; background-position: center center;background-size: cover;height:300px'></div>";
                        rows += "<div class='col-sm-12 padding-20'>"
                        rows += "<h2>"+item.name+"</h2>";
                        rows += "<h4 class='m-1'>Description</h4>";
                        rows += "<p class='m-1 font-weight-bold'>"+item.description+"</p>";
                        rows += "<h4 class='m-1'>Cost</h4>";
                        rows += "<p class='m-1 font-weight-bold'>Price - &#8358;"+price+"</p>";
                        rows += "<p class='m-1 font-weight-bold'>Delivery - &#8358;"+delivery_price+"</p>";
                        // rows += "<p class='m-1 font-weight-bold'>Delivery(location) - &#8358;"+delivery_price_location+"</p>";
                        if(item.variants){
                        if(item.variants.length){
                            rows += "<h4 class='m-1'>Variants</h4>";
                            $.each(item.variants, function (index, item) {
                                rows += "<p class='m-1 font-weight-bold'>"+item.option_name+" - "+item.option_value_name+"</p>";
                            })
                        }
                        }
                        rows += "</div>";
                        rows += "</div>";
                    });

                    $(".modal-body").empty().append(rows)
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
