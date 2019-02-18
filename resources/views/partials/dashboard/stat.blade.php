<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-cube text-danger icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="card-text text-right">Units balance</p>
                        <div class="fluid-container">
                            <h3 class="card-title font-weight-bold text-right mb-0">{{number_format($balance, 0,",",".")}}</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3">
                    <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> Total unit in account
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-cube-outline text-warning icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="card-text text-right">Units purchased</p>
                        <div class="fluid-container">
                            <h3 class="card-title font-weight-bold text-right mb-0">3455</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3">
                    <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> Total unit purchased
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="fas fa-users-cog text-teal icon-md"></i>
                    </div>
                    <div class="float-right">
                        <p class="card-text text-right">Agents</p>
                        <div class="fluid-container">
                            <h3 class="card-title font-weight-bold text-right mb-0">{{number_format($agents, 0,",",".")}}</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3">
                    <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> Total agents registered
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="fas fa-users text-info icon-md"></i>
                    </div>
                    <div class="float-right">
                        <p class="card-text text-right">Customers</p>
                        <div class="fluid-container">
                            <h3 class="card-title font-weight-bold text-right mb-0">{{number_format($customers, 0,",",".")}}</h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3">
                    <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> Total customers registered
                </p>
            </div>
        </div>
    </div>
</div>