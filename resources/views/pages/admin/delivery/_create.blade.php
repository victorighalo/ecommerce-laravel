<div class="row justify-content-center flex-grow mb-5 mt-1">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">  Add Delivery Cost
                    <a class="btn btn-link float-right" data-toggle="collapse" href="#form_collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fas fa-ellipsis-v"></i>
                    </a></h5>
                <div class="collapse" id="form_collapse">
                    <div class="row">
                        <div class="col-sm-12 p-4">
                            <form id="delivery_form">
                                @csrf
                                <div class="row form-group">

                                    <div class="col-sm-4">
                                        <label for="role">States</label>
                                        <select class="form-control" name="state_id" id="state_id">
                                            @foreach($states as $state)
                                                <option value="{{$state->state_id}}">{{$state->state_name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="role">City</label>
                                        <select class="form-control" name="city_id" id="city_id">

                                        </select>
                                        <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="role">Cost</label>
                                        <input type="number" name="cost" min="0" class="form-control">
                                        <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                    </div>

                                </div>


                                <div class="mt-1">
                                    <button class="btn float-right btn-primary btn-lg font-weight-medium add_user_btn" type="submit">
                                        <i class="fas fa-spinner fa-spin off process_indicator"></i>
                                        <span><i class="fas fa-save"></i> {{ __('Save') }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
