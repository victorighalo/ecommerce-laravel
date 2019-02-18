<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-cube text-danger icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="card-text text-right">Wallet balance</p>
                        <div class="fluid-container">
                            <h3 class="card-title font-weight-bold text-right mb-0">
                                @if(isset($balance))
                                @if($balance)
                                        {{number_format( $balance, 0, '.', ',')}}
                                    @else
                                    0
                                    @endif
                                    @endif
                            </h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3">
                    <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> 65% lower growth
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-receipt text-warning icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="card-text text-right">Total withdrawals</p>
                        <div class="fluid-container">
                            <h3 class="card-title font-weight-bold text-right mb-0">3455</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3">
                    <i class="mdi mdi-bookmark-outline mr-1" aria-hidden="true"></i> Product-wise sales
                </p>
            </div>
        </div>
    </div>
    <div class="row flex-grow">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Fund your wallet</h4>
                    <p class="card-description">
                        Enter the amount
                    </p>
                    <div class="form-group">
                        <form action="{{route('initialize_payment')}}" method="post">
                            @csrf
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">N</span>
                            </div>
                            <input type="text" name="amount" class="form-control" aria-label="Amount">
                            {{--<div class="input-group-append">--}}
                                {{--<span class="input-group-text">.00</span>--}}
                            {{--</div>--}}
                            <span class="input-group-append">
                          <button class="file-upload-browse btn btn-info custom_button_color" type="submit">Pay</button>
                        </span>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>