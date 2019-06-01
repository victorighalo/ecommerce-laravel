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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Active</th>
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
